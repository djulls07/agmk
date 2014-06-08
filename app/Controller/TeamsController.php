<?php 

App::uses('AppController', 'Controller');

class TeamsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}


	public function add() {
		if ($this->request->is('post')) {
			$team = $this->Team->findByName($this->request->data['Team']['name']);
			if ($team) {
				$this->Session->setFlash(__('Team name already taken.'));
			} else {
				$this->Team->create();
				$this->request->data['User']['id'] = $this->Auth->user('id');
				$this->request->data['Team']['leader_id'] = $this->Auth->user('id');
				if ($this->Team->saveAssociated($this->request->data)) {
					$this->Session->setFlash(__('New team saved'));
					return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
				}
			}
		}
		$games = $this->Team->Teamprofile->Game->find('list', array('fields' => array('Game.id', 'Game.name')));
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
    	$sql = "SELECT * FROM teams as Team ".
    		"LEFT JOIN teams_users as tu ON (Team.id=tu.team_id) ".
    		"LEFT JOIN teamprofiles as Teamprofile ON (Teamprofile.team_id=Team.id) ".
    		"LEFT JOIN games as Game ON (Game.id=Teamprofile.game_id) ".
    		"WHERE tu.user_id=".$id." AND tu.actif=1";
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
		if (in_array($this->action, array('index', 'add', 'view', 'activeMember', 'notactiveMember'))) {
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
    			//send notifications//TODOODODODODODDODODO
    			$this->Team->User->Notification->addTeamMember($id, $this->Auth->user('username'), $this->request->data['Team']['user_id']);
    			$this->Session->setFlash(__('Invitation sent'));
    			return $this->redirect(array('action' => 'addMember'));
    		} else {
    			$this->Session->setFlash(__($this->request->data['Team']['name'] . ' is already in your Team.'));
    			return $this->redirect(array('action' => 'addMember'));
    		}
    	}
	}

	public function activeMember($id_notif, $idTeam, $teamName) {
		if ($this->request->is('post')) {
			if($this->Team->activeMember($idTeam, $this->Auth->user('id'))) {
				$this->Team->User->Notification->delete($id_notif);
				$this->Session->setFlash(__('You are now member of ' . $teamName));
				return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
			} else {
				$this->Session->setFlash(__('Cant accept invitation, retry later or contact admin'));
				return $this->redirect(array('controller' => 'notifications', 'action' => 'index'));
			}
		}
	}

	public function notactiveMember($id_notif, $id_team, $teamName) {
		if ($this->request->is('post')) {
			if ($this->Team->notActiveMember($id_team, $this->Auth->user('id'))) {
				$this->Session->setFlash('You refused the invitation to join the Team '.$teamName);
				$this->Team->User->Notification->delete($id_notif);
				return $this->redirect(array('controller' => 'notifications', 'action' => 'index'));
			}
		}
	}

	public function eject($idTeam, $idUser) {
		
	}
}

?>