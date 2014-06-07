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

	public function addTeamMember($idTeam,$idSrc ,$idDest) {
		$user = $this->User->findById($idDest);
		$team = $this->User->Team->findById($idTeam);
		$data = array(
			'user_id' => $idDest,
			'content' => 'You have beed invited to join '.$team['Team']['name'] . ' By ' .$user['User']['username'],
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
}

?>