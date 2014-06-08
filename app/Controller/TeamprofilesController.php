<?php

class TeamprofilesController extends AppController {


	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function add($idTeam = null) {
		if (!$idTeam) {
			throw new NotFoundException(__('Invalid team'));
		}
		$this->Teamprofile->Team->recursive = 0;
		$team = $this->Teamprofile->Team->findById($idTeam);
		if (!$team || $team['Team']['leader_id'] != $this->Auth->user('id')) {
			$this->Session->setFlash(__('You cant manage a team if you are not the LEADER'));
			return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
		}
		if ($this->request->is('get')) {
			$games = $this->Teamprofile->getGamesProfiles($idTeam);
			$this->set('games', $games);
			$this->set('team_id',$idTeam);
		}
		if ($this->request->is('post')) {
			$this->request->data['Teamprofile']['team_id'] = $idTeam;
			debug($this->request->data);
		}
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('add'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}
}

?>