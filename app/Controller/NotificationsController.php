<?php

class NotificationsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all')
	}

	public function isAuthorized($user) {
		if ($this->action === 'index') return true;
	}

	public function index() {
		$id = $this->Auth->user('id');
		$this->Notification->find('all', array(
			'conditions' => array('user_id' => $id),
			'limits' => 20,
			''
		));
	}

}

?>