<?php 

class TeamsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	//functions here.

	public function isAuthorized($user) {
		return parent::isAuthorized();
	}
}

?>