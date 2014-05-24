<?php

class MessagesController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}

	public function index() {
		if ($this->request->is('get')) {
			$id = $this->Auth->user('id');
			$this->Message->recursive = 0;
			$params = array(
				'conditions' => array('src_id' => $id)
			);
			$send_mess = $this->Message->find('all', $params)
			$params = array(
				'conditions' => array('dest_id' => $id)
			);
			$receive_mess = $this->Message->find('all', $params);
			if (!$messages) {
				$this->Session->setFlash(__('No message, sorry dude !'));
			}
			$this->set('send_mess', $send_mess);
			$this->set('receive_mess', $receive_mess);
		}
	}

}

?>