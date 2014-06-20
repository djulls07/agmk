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
		//$games = $this->Team->Teamprofile->Game->find('list', array('fields' => array('Game.id', 'Game.name')));
		//$this->set('games', $games);
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
		$tmp = array();
		foreach($team['User'] as $user) {
			$tmp[$user['id']] = $user;
		}
		$team['User'] = $tmp;
		$db = $this->Team->getDataSource();
		foreach($team['Teamprofile'] as $k => $v) {
			$sqlPart = '(';
			foreach($v['roster'] as $i) {
				$sqlPart .= $i.',';
			}
			$sqlPart = substr($sqlPart, 0, -1);
			$sqlPart .= ')';
			if (strlen($sqlPart) < 4) {
				$team['Teamprofile'][$k]['roster'] = null;
				continue;
			}
			$idGame = $team['Teamprofile'][$k]['game_id'];
			$sql = "SELECT * FROM users as User LEFT JOIN profiles as Profile ON ".
				"(User.id=Profile.user_id AND Profile.game_id=".$idGame.") WHERE User.id IN ".$sqlPart;
			$res = $db->fetchAll($sql);
			$team['Teamprofile'][$k]['roster'] = $res;
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
		if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
		if ($this->request->is('post')) {
	        if ($this->Team->delete($id)) {
	        	if ($this->Team->Teamprofile->deleteProfiles($id)) {
	        		$this->Session->setFlash(__('Your Team has been deleted'));
	            	return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
	        	}
	        }
	        $this->setFlash(__('Unable to delete your article'));
	    }
    }

    public function index() {
    	$id = $this->Auth->user('id');

    	$db = $this->Team->getDataSource();
    	$sql = "SELECT * FROM teams as Team ".
    		"WHERE Team.id IN ".
    		"(SELECT team_id FROM teams_users as tu WHERE tu.actif=1 AND tu.user_id=".$id.")";
    	$teams = $db->fetchAll($sql);
    	$this->set('teams', $teams);
    	//debug($teams);
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
		$teamId = (int) $this->request->params['pass'][0];
		if (in_array($this->action, array('delete', 'edit', 'addMember', 'eject', 'addSecondLeader'))) {
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
    			return $this->redirect(array('action' => 'addMember', $id));
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
		if ($this->request->is('post')) {
			$team = $this->Team->findById($idTeam);
			if (!$team) {
				throw new NotFoundException(__('Invalid Team'));
			}
			if($team['Team']['leader_id'] == $idUser) {
				$this->Session->setFlash(__('You should give up leadership before trying to leave your team'));
				return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
			}
			//parcourir all rosters et le virer
			if ($this->Team->eject($idTeam, $idUser)) {
				//eject lancera Teamprofile ejectFromAllRosters
				$this->Session->setFlash(__('User Eject from team and Team rosters'));
				return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
			} else {
				$this->Session->setFlash(__('Cant Eject user, try again later or contact admin.'));
				return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
			}
		}
	}

	public function addSecondLeader($idTeam, $idUser) {
		if ($this->Team->addSecondLeader($idTeam, $idUser)) {
			$this->Session->setFlash(__('Second team leader has been set'));
			return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
		}
	}
	
}

?>