<?php

class MessagesController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}

?>