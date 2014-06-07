<?php 

class TeamsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}


	public function add() {
		if ($this->request->is('post')) {
			$this->Team->create();
			$this->request->data['User']['id'] = $this->Auth->user('id');
			$this->request->data['Team']['leader_id'] = $this->Auth->user('id');
			if ($this->Team->save($this->request->data)) {
				$this->Session->setFlash(__('New team saved'));
				return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
			}
		}
		$games = $this->Team->Game->find('list', array('fields' => array('Game.id', 'Game.name')));
		$this->set('games', $games);
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
		//debug($team);
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


	public function delete($id = null) {
		$this->request->onlyAllow('post');
        $this->Team->id = $id;
        
        if (!$this->Team->exists()) {
            throw new NotFoundException(__('Invalid article'));
        }
        if ($this->Team->delete()) {
            $this->Session->setFlash(__('Your Team has been deleted'));
            return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
        }
        $this->setFlash(__('Unable to delete your article'));
    }

    public function index() {
    	$id = $this->Auth->user('id');

    	$db = $this->Team->getDataSource();
    	$sql = "SELECT * FROM teams as Team LEFT JOIN teams_users as tu ON (Team.id=tu.team_id) LEFT JOIN games as Game ON Game.id=Team.game_id WHERE tu.user_id=".$id;
    	$teams = $db->fetchAll($sql);
    	$this->set('teams', $teams);
    }

    public function leave($id = null) {
    	if (!$id) {
    		throw new NotFoundException(__('Invalid Team'));
    	}
    	$team = $this->Team->findById($id);
    	if (!$team) {
    		throw new NotFoundException(__('Invalid Team'));
    	}
    	if ($this->Auth->user('id') == $team['Team']['leader_id']) {
    		return $this->redirect(array('controller' => 'teams', 'action' => 'view', $id));
    	}
    	if ($this->Team->leave($id, $this->Auth->user('id'))) {
    		$this->Session->setFlash(__('You are no longer a member of '.$team['Team']['name']));
    		return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
    	}
    }

	public function isAuthorized($user) {
		if (in_array($this->action, array('index', 'add', 'view'))) {
			return true;
		}
		if (in_array($this->action, array('delete', 'edit', 'addMember'))) {
			$teamId = (int) $this->request->params['pass'][0];
			if (!$teamId) return false;
			if ($this->Team->isLeader($user, $teamId)) {
				return true;
			}
		}
		if ($this->action === 'leave') {
			$teamId = (int) $this->request->params['pass'][0];
			if ($this->Team->isLeader($user, $teamId)) {
				return false;
			}
			return true;
		}
		return parent::isAuthorized($user);
	}

	public function addMember($id = null) {
		if (!$id) {
    		throw new NotFoundException(__('Invalid Team'));
    	}
    	if ($this->request->is('post')) {
    		if ($this->Team->addMember($id, $this->request->data['Team']['user_id'])) {
    			//send notifications//TODOODODODODODDODODO et mettre searchBar.js partout ou needed
    			$this->Session->setFlash(__('Mate added'));
    			return $this->redirect(array('action' => 'addMember'));
    		} else {
    			$this->Session->setFlash(__('Cant add your mate'));
    			return $this->redirect(array('action' => 'addMember'));
    		}
    	}
	}
}

?>