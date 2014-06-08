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
			$g = $this->Teamprofile->Game->findById($this->request->data['Teamprofile']['game_id']);
			if (!$g) {
				throw new NotFoundException(__('Invalid game'));
			}
			$this->request->data['Teamprofile']['game_name'] = $g['Game']['name'];
			if ($this->Teamprofile->save($this->request->data)) {
				$this->Session->setFlash(__('Roster/Profile created'));
				return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
			}
		}
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('add'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}

	public function delete($id = null) {
		if ($this->request->is('post')){
			if ($this->Teamprofile->delete($id)){
				$this->Session->setFlash(__('Team Profile deleted'));
				return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
			}
		}
	}
}

?>