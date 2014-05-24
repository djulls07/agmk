<?php

class NotificationsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized($user) {
		if ($this->action === 'index') return true;
	}

	public function index() {
		if ($this->request->is('get')) {
			$id = $this->Auth->user('id');
			$this->Notification->recursive = 0;
			$this->Notification->User->id = $id;
			$this->Notification->User->saveField('notifications', 0);
			$notifications = $this->Notification->find('all', array(
				'conditions' => array('user_id' => $id),
				'limits' => 20,
				'order' => array('Notification.created', 'Notification.created DESC')
			));
			if (!$notifications) {
				$this->Session->setFlash(__('No notification'));
			}
			$this->set('notifications', $notifications);
		}
	}

}

?>