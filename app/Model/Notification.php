<?php

class Notification extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'classname' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public function addFriend($user_src, $friends) {
		$id_src = $user_src['id'];
		foreach($friends as $k => $val) {
			$data = array('user_id' => $val, 'content' => 'New friend request from '.$user_src['username'], 'controller' => 'friendships', 'action' => 'active' ,'param1' => $id_src);
			$user = $this->User->findById($val);
			$user['User']['notifications']++;
			unset($user['User']['password']);
			$this->create();
			if (!$this->save($data)) {
				return false;
			}
			if (!$this->User->save($user)) {
				return false;
			}
		}
		return true;
	}

	public function addTeamMember($idTeam,$userSrcName ,$idDest) {
		$user = $this->User->findById($idDest);
		$team = $this->User->Team->findById($idTeam);
		$data = array(
			'user_id' => $idDest,
			'content' => 'You have beed invited to join '.$team['Team']['name'] . ' By ' .$userSrcName,
			'controller' => 'teams',
			'action' => 'activeMember',
			'param1' => $idTeam,
			'param2' => $team['Team']['name']
		);
		unset($user['User']['password']);
		$this->create();
		if (!$this->save($data)) {
			return false;
		}
		$user['User']['notifications']++;
		if (!$this->User->save($user)) {
			return false;
		}
		return true;
	}

	public function addToRosterWithoutProfile($idUser, $idTeam, $idGame) {
		$user = $this->User->findById($idUser);
		unset($user['User']['password']);
		$team = $this->User->Team->findById($idTeam);
		$teamProfile = $this->User->Team->Teamprofile->find('first',array(
			'conditions' => array('Teamprofile.game_id' => $idGame, 'Teamprofile.team_id' => $idTeam)
		));
		$idProfileTeam = $teamProfile['Teamprofile']['id'];
		$data = array(
			'user_id' => $idUser,
			'content' => 'You have beed invited to join roster '.$teamProfile['Teamprofile']['game_name'] . ' Of ' .$team['Team']['name']. ' Team',
			'controller' => 'profiles',
			'action' => 'createFromNotif',
			'param1' => $idTeam,
			'param2' => $idProfileTeam
		);
		$this->create();
		if (!$this->save($data)) {
			return false;
		}
		$user['User']['notifications']++;
		if (!$this->User->save($user)) {
			return false;
		}
		return true;
	}
}

?>