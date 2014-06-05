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

	public $belongsTo = array(
		'Game' => array(
			'classname' => 'Game',
			'foreignKey' => 'game_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'User' => array(
			'classname' => 'User',
			'joinTable' => 'teams_users',
            'foreignKey' => 'team_id',
            'associationForeignKey' => 'user_id'
		)
	);

	public function isLeader($user, $teamId) {
		$team = $this->findById($teamId);
		if ($team['Team']['leader_id'] == $user['id']) {
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
}

?>