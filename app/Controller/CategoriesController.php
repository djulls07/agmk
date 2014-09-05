<?php

class CategoriesController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny("all");
	}

	public function index() {
		$this->Categorie->recursive = 2;
		$this->set('categories', $this->find('all'));
		debug($this->find('all'));
	}
	
	//autorisation
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}