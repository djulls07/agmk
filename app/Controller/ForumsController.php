<?php 
class ForumsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->deny("all");
	}

	//autorisation
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}