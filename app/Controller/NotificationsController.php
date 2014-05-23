<?php

class NotificationsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all')
	}

	public function isAuthorized($user) {
		if ($this->action === 'index') return true;
	}

	public function add_friend($id_dest) {

	}
}

?>