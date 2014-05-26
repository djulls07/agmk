<?php

class MessagesController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('index', 'add', 'view', 'received', 'sent', 'reponse', 'ecrire')))
			return true;
		return parent::isAuthorized($user);
	}

	public function index() {
		if ($this->request->is('get')) {
			$id = $this->Auth->user('id');
			$this->Message->recursive = -1;
			$params = array(
				'conditions' => array(
					'OR' => array(
						array('dest_id' => $id),
						array('src_id' => $id)
					)
				),
				'limits' => 100,
				'order' => 'Message.created DESC',
				'fields' => array('Message.id', 'Message.dest_username', 'Message.dest_id','Message.src_username', 'Message.src_id','Message.content', 'Message.created', 'Message.open_src', 'Message.open_dest')
			);
			$this->Paginator->settings = $params;
			$messages= $this->Paginator->paginate();
			if (!$messages) {
				$this->Session->setFlash(__('No message, sorry dude !'));
			}
			$this->set('messages', $messages);
		}
	}

	public function received() {
		if ($this->request->is('get')) {
			$id = $this->Auth->user('id');
			$this->Message->recursive = -1;
			$params = array(
				'conditions' => array('dest_id' => $id),
				'limits' => 50,
				'order' => 'Message.created DESC',
				'fields' => array('Message.id', 'Message.dest_username', 'Message.dest_id','Message.src_username', 'Message.src_id','Message.content', 'Message.created', 'Message.open_src', 'Message.open_dest')
			);
			$this->Paginator->settings = $params;
			$messages= $this->Paginator->paginate();
			if (!$messages) {
				$this->Session->setFlash(__('No message, sorry dude !'));
			}
			$this->set('messages', $messages);
		}
	}

	public function sent() {
		if ($this->request->is('get')) {
			$id = $this->Auth->user('id');
			$this->Message->recursive = -1;
			$params = array(
				'conditions' => array('src_id' => $id),
				'limits' => 50,
				'order' => 'Message.created DESC',
				'fields' => array('Message.id', 'Message.dest_username', 'Message.dest_id','Message.src_username', 'Message.src_id','Message.content', 'Message.created', 'Message.open_src', 'Message.open_dest')
			);
			$this->Paginator->settings = $params;
			$messages= $this->Paginator->paginate();
			if (!$messages) {
				$this->Session->setFlash(__('No message, sorry dude !'));
			}
			$this->set('messages', $messages);
		}
	}

	public function add($idDest = null, $usernameDest = null) {
		if ($this->request->is('post')) {
			$this->Message->create();
			$this->request->data['Message']['src_id'] = $this->Auth->user('id');
			$this->request->data['Message']['src_username'] = $this->Auth->user('username');
			if (!($user=$this->Message->User->findById($this->request->data['Message']['dest_id']))) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($user['User']['username'] == $this->request->data['Message']['dest_username']) {
				if ($this->Message->save($this->request->data)) {
					$this->Message->User->id = $user['User']['id'];
					$this->Message->User->saveField('messages', ($user['User']['messages'] + 1)); 
					$this->Session->setFlash(__('Message sent'));
					return $this->redirect(array('controller' => 'friendships', 'action' => 'index'));
				}
				$this->Session->setFlash(__('Error while sending message'));
			}
		}
		if (!$idDest || !$usernameDest) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('dest_id', $idDest);
		$this->set('dest_username', $usernameDest);
	}

	public function view($id = null) {
		$idUser = $this->Auth->user('id');
		if ($this->request->is('get')) {
			$message = $this->Message->findById($id);
			if (!$message) {
				throw new NotFoundException(__('Invalid message'));
			}
			if ($message['Message']['src_id'] != $idUser && $message['Message']['dest_id'] != $idUser) {
				$this->Session->setFlash(__('You cant see messages that dont concern you !'));
				return $this->redirect(array('controller' => 'messages','action'=>'index'));
			} else {
				$this->set('message', $message);
				$this->Message->id = $message['Message']['id'];
				if ($message['Message']['src_id'] == $idUser) {
					$this->Message->saveField('open_src', 1);
				} else {
					$this->Message->saveField('open_dest', 1);
					$user = $this->Message->User->findById($idUser);
					$this->Message->User->id = $idUser;
					if ($user['User']['messages'] > 0)
						$this->Message->User->saveField('messages', $user['User']['messages'] - 1);
				}
			}
		}
	}

	public function reponse($messageId) {
		$message = $this->Message->findById($messageId);
		if(!$message) {
			throw new NotFoundException(__('Invalid message'));
		}
		if (!$message['Message']['dest_id'] == $this->Auth->user('id')) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->data['Message']['dest_id'] = $message['Message']['src_id'];
		$this->request->data['Message']['src_id'] = $this->Auth->user('id');
		$this->request->data['Message']['dest_username'] = $message['Message']['src_username'];
		$this->request->data['Message']['src_username'] = $this->Auth->user('username');
		if ($this->request->is('get')) {
			$this->set('message_src', $message);
		} else if ($this->request->is('post')) {	
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$user = $this->Message->User->findById($this->request->data['Message']['dest_id']);
				$this->Message->User->id = $user['User']['id'];
				$this->Message->User->saveField('messages', ($user['User']['messages'] + 1)); 
				$this->Session->setFlash(__('Message sent'));
				return $this->redirect(array('action' => 'received'));
			}
			$this->Session->setFlash(__('Cant send message'));
		}
	}

	public function ecrire() {

	}
}


?>