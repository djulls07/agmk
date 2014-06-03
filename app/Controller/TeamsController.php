<?php 

class TeamsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function index() {
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Team->create();
			$this->request->data['User']['user_id'] = $this->Auth->user('id');
			$this->request->data['Team']['leader_id'] = $this->Auth->user('id');
			if ($this->Team->saveAll($this->request->data)) {
				$this->Session->setFlash(__('New team saved'));
				return $this->redirect(array('controller' => 'users', 'action' => 'myteams'));
			}
		}
	}

	public function view ($id = null) {
		if (!$id) {
			throw new NotFoundException()__('Invalid Team');
		}
		$this->Team->recursive = 1;
		$team = $this->Team->findById($id);
		if (!$team) {
			throw new NotFoundException()__('Invalid Team');
		}
		$this->set('team', $team);
	}

	public function edit($id) {
		if (!$id) {
			throw new NotFoundException()__('Invalid Team');
		}
		$this->Team->recursive = 1;
		$team = $this->Team->findById($id);
		if (!$team) {
			throw new NotFoundException()__('Invalid Team');
		}
		if ($this->request->is('post')) {
			if ($team['Team']['leader_id'] == $this->Auth->user('id')) {
				//leader of the team can edit it
				if ($this->Team->saveAll($this->request->data)) {
					$this->Session->setFlash(__('Team saved'));
					return $this->redirect(array('action' => 'view', $team['Team']['id']));
				}
				$this->Session->setFlash(__('Error saving team'));
			}
		}
		$this->set('team', $team);
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('index', 'add', 'view'))) {
			return true;
		}
		return parent::isAuthorized();
	}
}

?>