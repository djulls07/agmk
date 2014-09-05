<?php

App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny("all");
	}

	public function index() {
		$this->Categorie->recursive = 2;
		$cat = $this->Category->find('all', array('order'=>array('Category.disp_position')));
		$this->set('cat', $cat);
		debug($cat);
	}
	
	//autorisation
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}