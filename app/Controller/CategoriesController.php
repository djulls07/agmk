<?php

App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny("all");
		$this->fillForumSession();
	}

	public function index() {
		$this->layout = 'default_forum';
		$this->Categorie->recursive = 1;
		$cat = $this->Category->find('all', array('order'=>array('Category.disp_position'), 'recursive'=>2));
		$this->loadModel('User');
		$fuser = $this->Session->read('forum_user');
		//debug($cat);
		$cat = $this->User->getForumIndispo($fuser['group_id'], $cat);
		$this->set('cat', $cat);
		//debug($cat);
	}
	
	//autorisation
	public function isAuthorized($user) {
		return true;
		return parent::isAuthorized($user);
	}

	public function fillForumSession() {
		$fuser = $this->Session->read('forum_user');
		//if(empty($fuser)) {
			$this->loadModel('User');
			$fuser = $this->User->readForumUser($this->Auth->user());
			$this->Session->write('forum_user', $fuser);
		//}
	}
}