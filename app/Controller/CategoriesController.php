<?php

App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny("all");
	}

	public function index() {
		$this->layout = 'default_forum';
		$this->Categorie->recursive = 1;
		$cat = $this->Category->find('all', array('order'=>array('Category.disp_position'), 'recursive'=>2));
		$this->set('cat', $cat);
		//debug($cat);
	}
	
	//autorisation
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}