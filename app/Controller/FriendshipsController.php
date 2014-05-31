<?php

class FriendshipsController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter() {
		$this->Auth->allow('myfriends');
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
						$this->Session->setFlash(__('Friend request sent'));
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

	public function notactive($id_notif, $id_src) {
		if ($this->request->is('post')) {
			$id = $this->Auth->user('id');
			if ($this->Friendship->notActiveFriendship($id_src, $id)) {
				$this->Session->setFlash(__('friend invitation rejected'));
				$this->Friendship->User->Notification->delete($id_notif);
				return $this->redirect(array('controller' => 'notifications', 'action' => 'index'));
			}
			$this->Session->setFlash(__('Cant reject friend'));
			return $this->redirect(array('controller' => 'notifications', 'action' => 'index'));
		}
	}

	public function index() {
		if ($this->request->is('get')) {
			$id = $this->Auth->user('id');
			$params = array(	
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User1',
						'type' => 'left',
						'foreignKey' => false,
						'conditions' => array(
							'AND' => array(
								array('user_id = User1.id')
							)
						)
					),
					array(
						'table' => 'users',
						'alias' => 'User2',
						'type' => 'left',
						'foreignKey' => false,
						'conditions' => array(
							'AND' => array(
								array('friend_id = User2.id')
							)
						)
					)
				),
				'conditions' => array(
					'AND' => array(
						array(
				            'OR' => array(
				            	array('user_id' => $id),
				            	array('friend_id' => $id)					    
						    )
						),
						array('Friendship.actif' => 1)
					)
				),
				'fields' => array('User1.id', 'User1.username', 'User2.id', 'User2.username', 'Friendship.id', 'Friendship.user_id', 'Friendship.friend_id','Friendship.actif')
			);
			$this->Paginator->settings = $params;
			$friendships = $this->Paginator->paginate();
			$friendships = $this->Friendship->removeMe($friendships, $this->Auth->user('id'));
			$this->set('friendships', $friendships);
		}

	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('add', 'active', 'notactive', 'index', 'myfriends'))) return true;
	}

	public function myfriends($var = null) {
		if ($this->request->is('ajax')) {
			$id = $this->Auth->user('id');
			$params = array(	
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User1',
						'type' => 'left',
						'foreignKey' => false,
						'conditions' => array(
							'AND' => array(
								array('user_id = User1.id')
							)
						)
					),
					array(
						'table' => 'users',
						'alias' => 'User2',
						'type' => 'left',
						'foreignKey' => false,
						'conditions' => array(
							'AND' => array(
								array('friend_id = User2.id')
							)
						)
					)
				),
				'conditions' => array(
					'AND' => array(
						array(
				            'OR' => array(
				            	array('user_id' => $id),
				            	array('friend_id' => $id)					    
						    )
						),
						array('Friendship.actif' => 1)
					)
				),
				'fields' => array('User1.username', 'User2.username', 'User1.id', 'User2.id')
			);
			$friends = $this->Friendship->find('all', $params);
			$friends = $this->Friendship->removeMe($friends, $id);
			$this->set('friends', json_encode($friends));
		}
	}
}

?>