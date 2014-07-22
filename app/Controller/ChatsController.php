<?php

class ChatsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->deny('all');
	}
	
	/* recupere (onglet/channels)s */
	public function channels() {
		$this->request->allowMethod('ajax');
		$chat = $this->Chat->findById($this->Auth->user('chat_id'));
		if ($chat == null) {
			echo json_encode(array('reponse'=>'null'));
			exit();
		}
		$ongletsChann = explode(";", $chat['Chat']['onglets_channels']);
		foreach($ongletsChann as $k=>$v) {
			$ongletsChan[$k] = explode(',', $v);
		}
		if ($ongletsChan == null) {
			echo json_encode(array('reponse'=>'null'));
			exit();
		}
		$nbOnglets = count($ongletsChan);
		echo json_encode(array('reponse'=>array('nb_onglets'=>$nbOnglets, 'ongletsChan'=>$ongletsChan)));
		exit();
	}
	
	public function checkCommand() {
		$this->request->allowMethod('ajax');
		
		$input = $this->request->data['message'];
		$onglet = (int)$this->request->data['onglet'];
		$matches = array();
		if(preg_match_all('#^/[a-z]+#', $input, $matches)) {
			$command = substr($matches[0][0],1);
			$this->$command($input,$onglet);
		} else {
			//tentative injection commande, blacklist ip et delete account
			echo '{"status":"ko"}';
		}
		exit();
	}
	
	public function talk($input, $onglet) {
		$input2 = substr($input, 5);
		$ligne = 0;
		if ($input2{0} != ' ') {
			echo json_encode(array('status'=>'ko', 'message'=>'Error with command talk, -> /talk channel message'));
			exit();
		}
		$tmp = explode(" ", $input2);
		if (!isset($tmp[1]) && isset($tmp[2])) {
			echo json_encode(array('status'=>'ko', 'message'=>"/talk channel command"));
			exit();
		}
		$channel = $tmp[1];
		$message = substr($input2, 2+strlen($channel), strlen($input2)-1);
		$chat = $this->Chat->findById($this->Auth->user('chat_id'));
		if ($chat == null) {
			echo json_encode(array('status'=>'ko', 'message'=>'/join channel before /talk !'));
			exit();
		}
		$channels = explode(";", $chat['Chat']['onglets_channels']);
		if (!isset($channels[$onglet-1])) {
			echo json_encode(array('status'=>'ko', 'message'=>'/join a channel in this frame before /talk !'));
			exit();
		} else {
			foreach($channels as $c) {
				foreach(explode(",", $c) as $one) {
					if ($one == $channel) {
						$path = $this->getFile($channel);
						$file = fopen($path, "r+");
						flock($file, LOCK_EX);
						$reponse = array();
						$ligne = (int)fgets($file);
						// cas nettoyage
						if ($ligne > 100) {
							ftruncate($file, 0);
							$ligne = 2;	
						}
						$ligne++;
						fseek($file, 0, SEEK_SET);
						fwrite($file, $ligne."\n");
						for ($i=0;$i<$ligne-1; $i++) {
							fgets($file);
						}
						fwrite($file, $this->Auth->user('username').': '.$message."\n");
						flock($file, LOCK_UN);
						fclose($file);
						echo json_encode(array('status'=>'ok', 'message'=>$this->Auth->user('username').': '.$message, 'ligne'=>$ligne, 'channel'=>$channel));
						exit();
					}
				}
			}
			echo json_encode(array('status'=>'ko', 'message'=>'Channel not found, /join the channel before.'));
			exit();
		}
		
		echo json_encode(array('status'=>'ok', 'message'=>$input));
		exit();
	}
	
	public function position() {
		$this->loadModel('User');
		$w = $this->request->data['width'];
		$h = $this->request->data['height'];
		$l = $this->request->data['left'];
		$t = $this->request->data['top'];
		$this->Session->write('chatposition', array(		
			'width' => $w,
			'height'=> $h,
			'left' => $l,
			'top' => $t
		));
		exit();
	}
	
	/* fonction pour avoir le nom du fichier(sur le serveur) correspondant au channel */
	
	public function getFile($channel) {
		return 'files/agmk_chat/'.md5($channel).'.agmkchat';
	}
	
	//fonctions correspondant aux commandes
	
	/* creer ou rejoins un channel */
	public function join($input, $onglet) {
		$this->loadModel('User');
		$input = substr($input, 6);
		$channels = array();
		$channels = explode(' ', $input);
		$jsonArr = array();
		$file = null;
		foreach($channels as $channel) {
			if ($channel == "agamek") {
				array_push($jsonArr,
				array('channel'=>$channel, 'status'=>'ko', 'message'=>'You cant join/leave agamek channel, it is the site channel to keep you posted ! So you are already in it'));
				echo json_encode($jsonArr);
				exit();
			}
			$path = $this->getFile($channel);
			if (file_exists($path)) {
				array_push($jsonArr, 
					array('channel'=>$channel, 'status'=>'ok', 'message'=>'You have join channel '.$channel.'(already exist)'));
			} else {
				//create channel/file
					$file = fopen($path, "w");
					flock($file, LOCK_EX);
					fwrite($file, "2\n");
					flock($file, LOCK_UN);
					fclose($file);
					array_push($jsonArr,
					array('channel'=>$channel, 'status'=>'ok', 'message'=>'You have join channel '.$channel.'(has been created)'));
			}
			if ($this->Auth->user('chat_id') == 0) {
				$this->Chat->create();
				$tmp = "";

				for($j=1;$j<$onglet; $j++) {
					$tmp .= "agamek;";
				}
				$data = array('Chat'=> array('onglets_channels'=>$tmp.'agamek,'.$channel));
				if ($this->Chat->save($data)) {
					//ok
					$user = array();
					$user = $this->User->findById($this->Auth->user('id'));
					$user['User']['chat_id'] = $this->Chat->id;
					$this->User->id = $this->Auth->user('id');
					if ($this->User->saveField('chat_id', $this->Chat->id)) {
						$this->Session->write('Auth', $user);
						
					}
				}
			} else {
				$chat = $this->Chat->findById($this->Auth->user('chat_id'));
				$tab = array();
				$i=0;
				foreach(explode(';', $chat['Chat']['onglets_channels']) as $ong) {
					$tab[$i++] = explode(',', $ong);
				}
				if (isset($tab[$onglet-1])) {
					foreach($tab[$onglet-1] as $chan) {
						if($chan == $channel) {
							echo json_encode($jsonArr);
							exit();
						}
					}
					array_push($tab[$onglet-1], $channel);
				} else {
					for($i=0;$i<($onglet-1); $i++) {
						if (!isset($tab[$i]) || !is_array($tab[$i])) {
							$tab[$i] = array();
							array_push($tab[$i], 'agamek');
						}
					}
					$tab[$onglet-1] = array();
					array_push($tab[$onglet-1], 'agamek');
					array_push($tab[$onglet-1], $channel);
				}
				$w = "";
				foreach($tab as $ong) {
					foreach($ong as $chann) {
						$w .= $chann.",";
					}
					$w = substr($w, 0, strlen($w)-1);
					$w.=";";
				}
				$w = substr($w, 0, strlen($w)-1);
				if ($chat['Chat']['onglets_channels'] == '')
					$w = 'agamek'.$w;
				$chat['Chat']['onglets_channels'] = $w;
				$this->Chat->save($chat);
			}
		}
		echo json_encode($jsonArr);
		exit();
	}
	
	public function open() {
		$this->Session->write('chatstate', true);
		echo '{"status":"ok"}';
		exit();
	}
	public function close() {
		$this->Session->write('chatstate', false);
		echo '{"status":"ok"}';
		exit();
	}
	
	//TODO finir le read et le traitement en js, on range les donnée ici pour envoyer au js qqch du genre channels[channel]=>messages
	public function read() {
		$bool = false;
		$len =  strlen($this->request->data['arr']) -1;
		if ($len < 3) exit();
		$input = substr($this->request->data['arr'], 0, $len);
		//echo $input; exit();
		$tab = explode(',', $input);
		$tabChan = array();
		$tabChan[0] = array();
		$tabChan[1] = array();
		$tmp = array();
		foreach($tab as $t) {
			$tmp = explode(":", $t);
			array_push($tabChan[0], $tmp[0]);
			array_push($tabChan[1], $tmp[1]);
		}
		//echo json_encode($tabChan);exit();
		$user = $this->Auth->user();
		$chat = $this->Chat->findById($user['chat_id']);
		$tabChanDB = explode(";", $chat['Chat']['onglets_channels']);
		$tabChannelsDB = array();
		foreach($tabChanDB as $k=>$v) {
			$tmp = explode(",", $v);
			foreach($tmp as $key=>$val) {
				array_push($tabChannelsDB, $val);
			}
		}
		foreach($tabChan[1] as $chanToCheck) {
			foreach($tabChannelsDB as $chanDB) {
				if ($chanToCheck == $chanDB) {
					$bool = true;
				}
			}
			if (!$bool) {
				echo json_encode(array('status'=>'ko', 'message'=>'One of the channel you try to get is not in our database for user:'.$this->Auth->user('username')));
				exit();
			}
			$bool = false;
		}
		
		$reponse = array();
		$ligne;
		
		$tmpRep = array();
		$compt = 0;
		foreach($tabChan[1] as $k=>$channel) {
			$currJS = (int)$tabChan[0][$k];
			$compt = 0;
			$reponse[$channel] = array();
			$reponse[$channel]['messages'] = array();
			$reponse[$channel]['ligne'] = -1;
			$path = $this->getFile($channel);
			if (file_exists($path)) {
				$file = fopen($path, "r");
				flock($file, LOCK_SH);
				/* on recupere la ligne current */
				$ligne = (int)fgets($file);
				if ($ligne <= 2) {
					$reponse[$channel]['ligne'] = $ligne;
					//none
				} else if ($currJS == -1) {
					//-2 car deja lu une ligne et qu'on veut lire la last ligne pas ecrire apres.
					for($i=0;$i<$ligne-3;$i++) {
						fgets($file);
					}
					array_push($reponse[$channel]['messages'], h(fgets($file)));
					$reponse[$channel]['ligne'] = $ligne;
				} else if ($currJS == $ligne) {
					//none;
					$reponse[$channel]['ligne'] = $ligne;
				} else {
					for ($i=0;$i<$currJS-2;$i++) {
						fgets($file);
					}
					for ($i=$currJS-3;$i<$ligne-3;$i++) {
						array_push($reponse[$channel]['messages'], h(fgets($file)));
					}
					$reponse[$channel]['ligne'] = $ligne;
				}
				flock($file, LOCK_UN);
				fclose($file);
			}
		}
		echo json_encode($reponse);
		exit();
	}
	
	public function clear() {
		$chat = $this->Chat->findById($this->Auth->user('chat_id'));
		if ($chat == null)
		{
			echo '{"status":"ko", "message":"No chat found"}';
			exit();
		}
		if ($chat['Chat']['onglets_channels'] == "") {
			echo '{"status":"ko", "message":Your chat is already empty ! dont abuse of commands !"}';
			exit();
		}
		$chat['Chat']['onglets_channels'] = "";
		$this->Session->write('chatstate', null);
		$this->Session->write('chatposition', null);
		if ($this->Chat->save($chat))
			echo '{"status":"ok", "message":"ok"}';
		else 
			echo '{"status":"ko", "message":"Cant save reset"}';
		exit();
	}
	
	public function write($input, $onglet) {
		$this->loadModel('Message');
		$this->loadModel('User');
		$input = substr($input, 7);
		$inputArr = array();
		$inputArr = explode(" ", $input);
				
		$destinataire = $this->User->findByUsername($inputArr[0]);
		
		if ($destinataire == null) {
			echo '{"status":"ko", "message":"cant find this user"}';
			exit();
		}
		
		$data = array('Message'=> array(
			'src_id'=>$this->Auth->user('id'),
			'src_username'=>$this->Auth->user('username'),
			'dest_id'=>$destinataire['User']['id'],
			'dest_username'=>$destinataire['User']['username'],
			'content'=>$inputArr[1]
		));
		if ($this->Chat->save($data)) {
			echo '{"status":"ok", "message":"Private Message sent"}';
			exit();
		}
		echo '{"status":"ko", "message":"cant save message"}';
		exit();
	}
	
	public function isAuthorized($user) {
		if (in_array($this->action, array("channels", 'checkCommand', 'open', 'close', 'talk', 'link', 'read', 'position', 'clear', 'write'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}
	
	
	
	
}