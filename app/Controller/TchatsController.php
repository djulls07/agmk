<?php

App::uses('AppController', 'Controller');

class TchatsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('getMessages'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}

	public function getMessages($ressource = null, $indice = null) {
		if (!$ressource) {
			throw new NotFoundException(__('No File specified: contact admin'));
		}
		if (!$indice) $indice = 0;
		$nb = $indice + 20;
		$i = $indice;
		if ($this->request->is('ajax')) {
			$tabTchat = array_reverse(file($ressource));
			$tchat = array();
			while ($i < $nb) {
				$tchat[$i] = $tabTchat[$i++];
			}
			echo json_encode($tchat);
			unset($tabTchat);
			unset($tchat);
			exit();
		} else {
			exit();
		}
	}


	public function createConversationFile($path) {
		$path = 'files/'.$path;
		$file = null;
		try {
			if (file_exists($path)) {
				$file = fopen($path, "r");
				flock($file, LOCK_SH);
			} else {
				$file = fopen($path, "x");
			}
			//Faire qqch sur le fichier !
			flock($file, LOCK_UN);
			fclose($file);
			return $this->afficheForm($path);
		} catch (Exception $e) {
			die('Error: ' . $e->getMessage());
		}
	}

}


?>