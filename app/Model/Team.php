<?php

class Team extends AppModel {

	public $validate = array(
		'name' => array(
    		'rule' => array('between', 3, 25),
    		'message' => 'Your username should be between 3 and 50'
        ),
        'tag' => array(
        	'rule' => array('between', 1, 10),
        	'message' => 'Tag should be between 1 and 10'
        )
	);

	/*public $belongsTo = array(
		'Game' => array(
			'classname' => 'Game',
			'foreignKey' => 'game_id'
		)
	);*/

	public $hasMany = array(
		'Teamprofile' => array(
			'classname' => 'Teamprofile',
			'foreignKey' => 'team_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'User' => array(
			'classname' => 'User',
			'joinTable' => 'teams_users',
            'foreignKey' => 'team_id',
            'associationForeignKey' => 'user_id',
            'fields' => array('User.id', 'User.avatar', 'User.username')
		)
	);

	public function isLeader($user, $teamId) {
		if (is_array($teamId)) return false;
		if (is_array($user)) {
			$userId = $user['id'];
		} else {
			$userId = $user;
		}
		$team = $this->findById($teamId);
		if ($team['Team']['leader_id'] == $userId) {
			return true;
		}
		return false;
	}

	public function leave($teamId, $userId) {
		$db = $this->getDataSource();
    	$sql = "DELETE FROM teams_users WHERE team_id=".$teamId." AND user_id=".$userId;
    	$userTeam = $db->query($sql);
    	return true;
	}

	public function addMember($idTeam, $idMember) {
		$this->User->id = $idMember;
		if ($this->User->exists()) {
			$db = $this->getDataSource();
    		$sql = "SELECT * FROM teams_users as tu WHERE tu.team_id=".$idTeam." AND tu.user_id=".$idMember;
    		$res = $db->fetchAll($sql);
    		if ($res) {
    			return false;
    		} else {
    			$sql = "INSERT INTO teams_users(user_id, team_id, actif) VALUES('".$idMember."', '".$idTeam."', 0)";
    			$db->query($sql);
    			return true;
    		}
		}
	}

	public function activeMember($idTeam, $idUser) {
		$db = $this->getDataSource();
		$sql = "UPDATE teams_users SET actif=1 WHERE user_id=".$idUser." AND team_id=".$idTeam;
		$db->query($sql);
		return true;
	}

	public function notActiveMember($idTeam, $idUser) {
		$db = $this->getDataSource();
		$sql = "DELETE FROM teams_users WHERE user_id=".$idUser." AND team_id=".$idTeam . " AND actif=0";
		$db->query($sql);
		return true;
	}

	public function eject($idTeam, $idUser) {
		//on sait que la team exists
		//le user on sen fiche
		if (!$this->Teamprofile->ejectFromAllRosters($idTeam, $idUser)) {
			return false;
		}
		$db = $this->getDataSource();
		$sql = "DELETE FROM teams_users WHERE user_id=".$idUser." AND team_id=".$idTeam;
		$db->query($sql);
		return true;
	}

	public function isMember($idUser, $idTeam) {
		$db = $this->getDataSource();
		$sql = "SELECT * FROM teams_users as tu WHERE tu.team_id=".$idTeam." AND tu.user_id=".$idUser;
		if ($db->fetchAll($sql) == null) {
			return false;
		}
		return true;
	}

	public function addSecondLeader($idTeam, $idUser) {
		$team = $this->findById($idTeam);
		if (!$team) {
			return false;
		}
		$team['Team']['second_leader_id'] = $idUser;
		$this->id = $team['Team']['id'];
		if ($this->save($team)) {
			return true;
		}
		return false;
	}

	public function getTeamsList($userId) {
		$db = $this->getDataSource();
		$sql = "SELECT * FROM teams_users as Tu LEFT JOIN teams as Team ON (Tu.team_id=Team.id) WHERE Tu.user_id=".$userId;
		$res = $db->fetchAll($sql);
		$results = array();
		foreach($res as $k => $val) {
			$results[$val['Team']['id']] = $val['Team'];
		}
		return $results;
	}
}

?>