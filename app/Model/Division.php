<?php
class Division extends AppModel {

	public $hasAndBelongsToMany = array(
		'Team' => array(
			'classname' => 'Team',
			'joinTable' => 'divisions_teams',
            'foreignKey' => 'division_id',
            'associationForeignKey' => 'team_id'
		)
	);

	public function saveAssocDivTeam($data, $divId) {
		$division = $this->findById($divId);
		$teamsIds = array();
		foreach($data['Team'] as $team) {
			$teamsIds[] = $team['id'];
		}
		$db = $this->getDataSource();
		$sql = "INSERT INTO divisions_teams (division_id, team_id) VALUES ";
		foreach($teamsIds as $id) {
			$sql .= '('.$divId.','.$id.')';
		}
		$db->query($sql);
		return true;
	}
	
}
?>