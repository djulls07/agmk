<?php

class FriendsController extends AppController {


	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function add() {
		if ($this->request->is('post')) {
			debug($this->request->data);
			//return;
			if ($this->Friend->saveAssociated($this->request->data)) {
			//if ($this->User->addFriend($this->Auth->user('id'), $this->request->data['User']['id'])) {
				$this->Session->setFlash(__('Friend added'));
				return $this->redirect(array('controller' => 'friends', 'action' => 'index'));
			}
		}
		$users = $this->Friend->User->find('list', array('fields' => array('User.id','User.username')));
		$this->set('users', $users);
	}

	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}