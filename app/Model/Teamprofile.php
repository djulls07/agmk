<?php

class Teamprofile extends AppModel {
	
	public $belongsTo = array(
		'Game' => array(
			'classname' => 'Game',
			'foreignKey' => 'game_id'
		),
		'Team'
	);


	public function getGamesProfiles($idTeam) {
		$db = $this->getDataSource();
		//$sql = "SELECT * FROM games as Game LEFT JOIN teamprofiles as Teamprofile ON (Game.id=Teamprofile.game_id)";
		$sql = "SELECT name, id FROM games as Game WHERE Game.id NOT IN (SELECT game_id FROM teamprofiles WHERE teamprofiles.team_id=".$idTeam.")";
		$res = $db->fetchAll($sql);
		return $res;
	}
}

?>