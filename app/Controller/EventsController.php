<?php

App::uses('AppController', 'Controller');

class EventsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized() {
		if (in_array($this->action, array('add', 'index'))) 
			return true;
	}

	public function index() {
		if ($this->request->is('get')) {
			$this->Event->recursive = 0;
			$this->set('events', $this->Event->paginate());
		}
	}

	public function add() {
		
	}

}
?>