<?php 

class TeamsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}


	public function add() {
		if ($this->request->is('post')) {
			$this->Team->create();
			$this->request->data['Team']['User']['id'] = $this->Auth->user('id');
			$this->request->data['Team']['leader_id'] = $this->Auth->user('id');
			if ($this->Team->saveAll($this->request->data)) {
				$this->Session->setFlash(__('New team saved'));
				return $this->redirect(array('controller' => 'users', 'action' => 'myteams'));
			}
		}
	}

	public function view ($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Team'));
		}
		$this->Team->recursive = 1;
		$team = $this->Team->findById($id);
		if (!$team) {
			throw new NotFoundException(__('Invalid Team'));
		}
		$this->set('team', $team);
	}

	public function edit($id) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Team'));
		}
		$this->Team->recursive = 1;
		$team = $this->Team->findById($id);
		if (!$team) {
			throw new NotFoundException(__('Invalid Team'));
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

	public function index() {
    	
    }

	public function delete($id = null) {
		$this->request->onlyAllow('post');
        $this->Team->id = $id;
        
        if (!$this->Team->exists()) {
            throw new NotFoundException(__('Invalid article'));
        }
        if ($this->Team->delete()) {
            $this->Session->setFlash(__('Your Team has been deleted'));
            return $this->redirect(array('controller' => 'users', 'action' => 'myteams'));
        }
        $this->setFlash(__('Unable to delete your article'));
    }

    public function myteams() {
    	$id = $this->Auth->user('id');
    	/*$params = array(
    		'joins' => array(
					array(
						'table' => 'teams_users',
						'alias' => 'teamsusers',
						'type' => 'left',
						'foreignKey' => false,
						'conditions' => array(
							'AND' => array(
								array('teamsusers.user_id = User.id')
							)
						)
					),
					array(
						'table' => 'teams',
						'alias' => 'team',
						'type' => 'left',
						'foreignKey' => false,
						'conditions' => array(
							'AND' => array(
								array('teamsusers.team_id = team.id')
							)
						)
					)
				), 
    		'conditions' => array(
    			'User.id' => $id,
    		),
    		'fields' => array('User.id', 'User.username')
    	);
    	$teams = $this->User->find('all', $params);
    	debug($teams); 
    	return;*/

    	$db = $this->User->getDataSource();
    	$sql = "SELECT * FROM teams as t LEFT JOIN teams_users as tu ON (t.id=tu.team_id) WHERE tu.user_id=".$id;
    	debug($db->fetchAll($sql));
    	$this->set('teams', $user['Team']);
    }

	public function isAuthorized($user) {
		if (in_array($this->action, array('index', 'add', 'view'))) {
			return true;
		}
		if (in_array($this->action, array('delete', 'edit'))) {
			$teamId = (int) $this->request->params['pass'][0];
			if ($this->Team->isLeader($user, $teamId)) {
				return true;
			}
		}
		return parent::isAuthorized();
	}
}

?>