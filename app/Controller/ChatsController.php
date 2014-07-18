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
			$path = $this->getFile($channel);
			if (file_exists($path)) {
				array_push($jsonArr, 
					array('channel'=>$channel, 'status'=>'ok', 'message'=>'You have join channel '.$channel.'(already exist)'));
			} else {
				//create channel/file
					$file = fopen($path, "x");
					fclose($file);
					array_push($jsonArr,
					array('channel'=>$channel, 'status'=>'ok', 'message'=>'You have join channel '.$channel.'(has been created)'));
			}
			if ($this->Auth->user('chat_id') == 0) {
				$this->Chat->create();
				$tmp = "";
				for($j=1;$j<$onglets; $j++) {
					$tmp .= ";";
				}
				$data = array('Chat'=> array('onglets_channels'=>$channel));
				if ($this->Chat->save($data)) {
					//ok
					$user = array();
					$user['User'] = $this->User->findById($this->Auth->user('id'));
					$user['User']['chat_id'] = $this->Chat->id;
					$this->User->id = $this->Auth->user('id');
					if ($this->User->saveField('chat_id', $this->Chat->id)) {
						$this->Session->write('Auth', $user['User']);
						
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
				} else {
					$tab[$onglet-1] = array();
				}
				array_push($tab[$onglet-1], $channel);
				$w = "";
				foreach($tab as $ong) {
					foreach($ong as $chann) {
						$w .= $chann.",";
					}
					$w = substr($w, 0, strlen($w)-1);
					$w.=";";
				}
				$w = substr($w, 0, strlen($w)-1);
				$chat['Chat']['onglets_channels'] = $w;
				$this->Chat->save($chat);
			}
		}
		echo json_encode($jsonArr);
		exit();
	}
	
	
	public function isAuthorized($user) {
		if (in_array($this->action, array("channels", 'checkCommand'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}
	
	
}