<?php

class FriendshipsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function add() {
		if ($this->request->is('post')) {
			$username = $this->request->data['Friendship']['username'];
			$user = $this->Friendship->User->find('first', array('conditions' => array('User.username' => $username)));
			if (!$user) {
				$this->Session->setFlash(__('Invalid user'));
				return;
			}
			$this->request->data['Friendship']['friend_id'] = $user['User']['id'];
			$this->request->data['Friendship']['user_id'] = $this->Auth->user('id');
			$this->Friendship->create();
			if ($this->Friendship->canBeAdded($this->Auth->user('id'), $user['User']['id'])) {
				if ($this->Friendship->save($this->request->data)) {
					if ($this->Friendship->User->Notification->addFriend($this->Auth->user(), array(0=>$user['User']['id']))) {
						$this->Session->setFlash(__('Friend added'));
						return $this->redirect(array('controller' => 'friendships'));
					}
					$this->Session->setFlash(__('Cant send "add friend" request'));
				}
			} else {
				$this->Session->setFlash(__('You are already friend with: '.$username));
			}
		}
	}

	public function active($id_notif, $id_src) {
		if ($this->request->is('post')) {
			$id = $this->Auth->user('id');
			if ($this->Friendship->activeFriendship($id_src, $id)) {
				$this->Session->setFlash(__('You are now friends'));
				$this->Friendship->User->Notification->delete($id_notif);
				return $this->redirect(array('controller' => 'notifications', 'action' => 'index'));
			}
			$this->Session->setFlash(__('Cant confirm friend'));
			return $this->redirect(array('controller' => 'notifications', 'action' => 'index'));
		}

	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('add', 'active'))) return true;
	}
}

?>