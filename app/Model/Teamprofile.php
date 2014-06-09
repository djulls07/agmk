<?php

App::uses('AppModel', 'Model');

class Teamprofile extends AppModel {
	
	public $belongsTo = array(
		'Game' => array(
			'classname' => 'Game',
			'foreignKey' => 'game_id',
			'fields' => array('Game.id', 'Game.name')
		),
		'Team' => array(
			'classname' => 'Team',
			'foreignKey' => 'team_id',
			'fields' => array('id')
 		)
	);


	public function getGamesProfiles($idTeam) {
		$db = $this->getDataSource();
		//$sql = "SELECT * FROM games as Game LEFT JOIN teamprofiles as Teamprofile ON (Game.id=Teamprofile.game_id)";
		$sql = "SELECT name, id FROM games as Game WHERE Game.id NOT IN (SELECT game_id FROM teamprofiles WHERE teamprofiles.team_id=".$idTeam.")";
		$tab = array();
		$res = $db->fetchAll($sql);
		foreach($res as $r) {
			$tab[($r['Game']['id'])] = $r['Game']['name'];
		}
		return $tab;
	}

	public function afterFind($results, $primary) {
		if (!$primary) {
			foreach($results as $k => $v) {
				$results[$k]['Teamprofile']['roster'] = explode(';', $results[$k]['Teamprofile']['roster']);
			}
			return $results;
		}
		return $results;
	}

	public function deleteProfiles($idTeam) {
		$db = $this->getDataSource();
		$sql = "DELETE FROM teamprofiles WHERE team_id=".$idTeam;
		$db->query($sql);
		return true;
	}

	public function getGamesRosterWithout($idUser, $idTeam) {
		$db = $this->getDataSource();
		$listIds = '(';
		$tab = array();
		$teamProfiles = $this->find('all', array(
			'conditions' => array('Teamprofile.team_id' => $idTeam)
		));
		//debug($teamProfiles);
		foreach($teamProfiles as $tp) {
			$b = true;
			foreach(explode(';', $tp['Teamprofile']['roster']) as $id) {
				if ($id == $idUser) {
					$b = false;
					break;
				}
			}
			if ($b) {
				$listIds .= $tp['Teamprofile']['game_id'].',';
			}
		}
		$listIds = substr($listIds, 0, -1);
		$listIds .= ')';
		if (strlen($listIds) > 2) {
			$sql = "SELECT name, id FROM games as Game WHERE Game.id IN ".$listIds;
		} else {
			$tab[0] = 'No Roster';
			return $tab;
		}
		$res = $db->fetchAll($sql);
		foreach($res as $r) {
			$tab[($r['Game']['id'])] = $r['Game']['name'];
		}
		return $tab;
	}
}

?>