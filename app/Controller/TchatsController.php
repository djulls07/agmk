<?php

App::uses('AppController', 'Controller');

class TchatsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('getMessages', 'createFile', 'readMessages', 'writeMessage'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}

	public function getMessages() {
		$tabIndex = array();
		$debut = $this->request->data['debut'];
		$path = $this->request->data['ressource'];
		$nombreLignes = $this->request->data['nombreLignes'];
		$messages = array();

		try {		
			$file = fopen($path, "r");
			//on lock
			flock($file, LOCK_SH);
			//on lit index du file
			$tabIndex = $this->getIndex($path);
			//on lit le fichier entre debut et fin
			$messages = $this->readMessages($file, $tabIndex, $debut, $nombreLignes);
			flock($file, LOCK_UN);
			echo json_encode($messages);
			fclose($file);
			exit();
		} catch (Exception $e) {
			die('Error: '.$e->getMessage());
		}
	}

	public function createFile() {
		$path = $this->request->data['ressource'];
		$file = null;
		try {
			if (!file_exists($path)) {
				$file = fopen($path, "x");
				fclose($file);
				$file = fopen($path.".index", "x");
				fclose($file);
			}
			//Faire qqch sur le fichier !
			echo json_encode(array('status' => 'ok'));
			exit();
		} catch (Exception $e) {
			die('Error: ' . $e->getMessage());
		}
	}

	public function getIndex($path) {
		return explode(";", file_get_contents($path.".index"));
	}

	public function readMessages($file, $tabIndex, $debut, $nombreLignes) {
		if($debut<0) {
			$debut = count($tabIndex) - $nombreLignes;
		}
		if ($debut < 0) $debut = 0;
		$start = intval($tabIndex[$debut]);
		$i = 0;
		$messages = array();
		$tmp = "";

		fseek($file, $start, SEEK_SET);
		for($i=0; $i<$nombreLignes; $i++) {
			if (false != ($tmp = fgets($file))) {
				$messages[$debut+$i] = $tmp;
			} else {
				break;
			}
		}
		if ($i == 0) {
			$messages = array('message' => 'none');
		}
		return $messages;
	}

	public function writeMessage() {
		$file = null;
		$fileIndex = null;
		$tmp = "";
		if (!isset($this->request->data['message'])) {
			echo json_encode(array('status' => 'ko'));
			exit();
		}
		if (!isset($this->request->data['ressource'])) {
			echo json_encode(array('status' => 'ko'));
			exit();
		}
		$message = $this->request->data['message'];
		$ressource = $this->request->data['ressource'];
		try {
			$fileIndex = fopen($ressource.".index", "r+");
			$file = fopen($ressource, "r+");
			//on lock ex
			flock($fileIndex, LOCK_EX);
			flock($file, LOCK_EX);
			fseek($file, 0, SEEK_END);
			fseek($fileIndex, 0, SEEK_END);
			//on ecrit index
			$tmp = ftell($file);
			fwrite($fileIndex, $tmp.";");
			fseek($file, 0, SEEK_END);
			$preLink = '['.date("d.m.y", time()).'] <a href="/users/view/'.$this->Auth->user('id').'">';
			$postLink = '</a>';
			fwrite($file, $preLink . $this->Auth->user('username') . ': ' .$postLink . h($message."\n"));
			flock($fileIndex, LOCK_UN);
			flock($file, LOCK_UN);
			fclose($file);
			fclose($fileIndex);
			echo json_encode(array('status' => 'ok'));
			exit();
		} catch(Exception $e) {
			die("Error: ".$e->getMessage());
		}
	}

}

// valLseek;Vallseek..etcetc.. \n --> index
?>