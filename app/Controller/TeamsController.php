<?php 

class TeamsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function index() {
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['User']['user_id'] = $this->Auth->user('id');
			$this->request->data['Team']['leader_id'] = $this->Auth->user('id');
			if ($this->Team->saveAll($this->request->data)) {
				$this->Session->setFlash(__('New team saved'));
				return $this->redirect(array('controller' => 'users', 'action' => 'myteams'));
			}
		}
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('index', 'add'))) {
			return true;
		}
		return parent::isAuthorized();
	}
}

?>