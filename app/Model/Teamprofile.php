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
				$results[$k]['Teamprofile']['roster'] = explode(',', $results[$k]['Teamprofile']['roster']);
			}
			return $results;
		}
		return $results;
	}

	public function getRosterToManage($id) {
		$db = $this->getDataSource();
		$sql = "SELECT * FROM teamprofiles as Teamprofile WHERE Teamprofile.id=".$id;
		$teamProfile = $db->fetchAll($sql);
		$teamProfile['Teamprofile'] = $teamProfile[0]['Teamprofile'];
		unset($teamProfile[0]);
		$teamProfile['Teamprofile']['roster'] = explode(',', $teamProfile['Teamprofile']['roster']);
		$sql = "SELECT * FROM teams_users as Tu LEFT JOIN users as User ON ".
			"(Tu.user_id=User.id) LEFT JOIN profiles as Profile ON ".
			"(Profile.user_id=User.id AND Profile.game_id=".$teamProfile['Teamprofile']['game_id'].
			") WHERE Tu.actif=1 AND Tu.team_id=".$teamProfile['Teamprofile']['team_id'];
		$teamProfile['Users'] = $db->fetchAll($sql);
		foreach($teamProfile['Users'] as $k => $v) {
			$teamProfile['Users'][$teamProfile['Users'][$k]['User']['id']]['Profile'] = $teamProfile['Users'][$k]['Profile'];
			$teamProfile['Users'][$teamProfile['Users'][$k]['User']['id']]['User'] = $teamProfile['Users'][$k]['User'];
			unset($teamProfile['Users'][$k]);
		}
		foreach($teamProfile['Teamprofile']['roster'] as $k => $v) {
			$teamProfile['Teamprofile']['roster'][$v] = $v;
			unset($teamProfile['Teamprofile']['roster'][$k]);
		}
		foreach($teamProfile['Users'] as $k => $user) {
			if (!isset($teamProfile['Teamprofile']['roster'][$k])) {
				$teamProfile['Teamprofile']['notRoster'][$k] = $k;
			}
		}
		$sql = "SELECT * FROM teams as Team WHERE Team.id=".$teamProfile['Teamprofile']['team_id'];
		$team = $db->fetchAll($sql);
		$teamProfile['Teamprofile']['Team'] = $team[0]['Team'];
		unset($team);
		return $teamProfile;
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
			foreach(explode(',', $tp['Teamprofile']['roster']) as $id) {
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

	public function ejectFromAllRosters($idTeam, $idUser) {
		$teamProfiles = $this->find('all', array(
			'conditions' => array('Teamprofile.team_id' => $idTeam)
		));
		foreach($teamProfiles as $k => $v) {
			$tmp = '';
			foreach(explode(',', $v['Teamprofile']['roster']) as $id) {
				if ($id != $idUser) {
					//on gare lidUser
					$tmp .= $id.',';
				}
			}
			//sauveProfile
			$teamProfiles[$k]['Teamprofile']['roster'] = substr($tmp,0,-1);
			$this->id = $v['Teamprofile']['id'];
			if (!$this->save($teamProfiles[$k])) {
				return false;
			}
		}
		return true;
	}

	public function ejectFromRoster($idTeamProfile, $idUser) {
		$teamProfile = $this->findById($idTeamProfile);
		if (!$teamProfile) {
			throw new NotFoundException(__('Invalid TeamProfile'));
		}
		if ($teamProfile['Teamprofile']['roster_leader_id'] == $idUser) {
			$teamProfile['Teamprofile']['roster_leader_id'] = '';
		}
		$tmp = '';
		foreach(explode(',', $teamProfile['Teamprofile']['roster']) as $id) {
			if ($id != $idUser) {
				$tmp .= $id.',';
			}
		}
		$teamProfile['Teamprofile']['roster'] = substr($tmp, 0, -1);
		$this->id = $idTeamProfile;
		if ($this->save($teamProfile)) {
			return true;
		}
		return false;
	}

	public function makeLeaderRoster($idTeamProfile, $idUser) {
		$teamProfile = $this->findById($idTeamProfile);
		if (!$teamProfile) {
			throw new NotFoundException(__('Invalid TeamProfile/Roster'));
		}
		$this->id = $teamProfile['Teamprofile']['id'];
		$b = false;
		foreach(explode(',', $teamProfile['Teamprofile']['roster']) as $id) {
			if($id == $idUser) {
				$b =true;
				break;
			}
		}
		if($b) {
			$teamProfile['Teamprofile']['roster_leader_id'] = $idUser;
			if ($this->save($teamProfile)) {
				return true;
			}
		}
		return false;
	}

	public function addToRoster($idUser, $idGame, $idTeam) {
		$teamProfile = $this->find('first', array(
			'conditions' => array(
				'game_id' => $idGame,
				'team_id' => $idTeam
			)
		));
		foreach(explode(',', $teamProfile['Teamprofile']['roster']) as $id) {
			if($id == $idUser) {
				return true;
			}
		}
		//id non trouve dans roster, on ajoute.
		$this->id = $teamProfile['Teamprofile']['id'];
		if ($teamProfile['Teamprofile']['roster'] != '')
			$teamProfile['Teamprofile']['roster'] .= ','.$idUser;
		else
			$teamProfile['Teamprofile']['roster'] = $idUser;
		if ($this->save($teamProfile)) {
			return true;
		}
		return false;
	}

	public function canManage($idRoster, $idUser) {
		$roster = $this->findById($idRoster);
		if ($idUser == $roster['Teamprofile']['roster_leader_id']) {
			return true;
		}
		$team = $this->Team->findById($roster['Teamprofile']['team_id']);
		if ($team['Team']['leader_id'] == $idUser) {
			return true;
		}
		return false;
	}
}

?>