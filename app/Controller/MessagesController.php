<?php

class MessagesController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}

	public function index() {
		if ($this->request->is('get')) {
			$id = $this->Auth->user('id');
			$this->Message->recursive = 0;
			$messages = $this->Message->findById($id);
			if (!$messages) {
				throw new NotFoundException(__('No Message'));
			}
			$this->set('messages', $messages);
		}
	}

}

?>