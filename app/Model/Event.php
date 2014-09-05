<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 * @property User $User
 * @property Game $Game
 * @property Match $Match
 * @property Result $Result
 * @property Team $Team
 */
class Event extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'min_teams' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Numeric value only',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'players_by_team' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Numeric value only',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date_debut' => array(
			'required' => array (
				'rule' => array('notEmpty')
			),
		),
		'date_fin' => array(
			'required' => array (
				'rule' => array('notEmpty')
			)
		),
		'name' => array(
			'required' => array (
				'rule' => array('notEmpty')
			),
			'unique' => array(
            	'rule'    => 'isUnique',
            	'message' => 'This event name has already been taken.'
        	),
        	'between' => array(
        		'rule' => array('between', 5, 50),
        		'message' => 'Your event name should be between 5 and 50 chars'
        	)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Game' => array(
			'className' => 'Game',
			'foreignKey' => 'game_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Match' => array(
			'className' => 'Match',
			'foreignKey' => 'event_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		/*'Result' => array(
			'className' => 'Result',
			'foreignKey' => 'event_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),*/
		'Saison' => array(
			'className' => 'Saison',
			'foreignKey' => 'event_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Division' => array(
			'classname' => 'Division',
			'foreignKey' => 'event_id',
			'dependent' => true
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Team' => array(
			'className' => 'Team',
			'joinTable' => 'events_teams',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'team_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	public function addTeam($idTeam, $eventId, $userId) {
		$db = $this->getDataSource();
		/*if ($userId == 72) {
			$sql = "INSERT INTO events_teams (event_id, team_id) VALUES(".$eventId.", ".$idTeam.")";
			$db->query($sql);
			return 0;
		}*/
		$event = $this->findById($eventId);
		$game_id = $event['Event']['game_id'];
		$team = $this->Team->findById($idTeam);
		$rosters = $this->Team->getRosters(array(0=>$team['Team']), $game_id);
		if ($rosters == null || count($rosters)<1) {
			return -3;
		}

		$sql = "SELECT * FROM events_teams WHERE event_id=".$eventId." AND team_id=".$idTeam;
		if ($db->fetchAll($sql)) return -1;
		$sql = "SELECT * FROM teams_users as Tu WHERE Tu.team_id=".$idTeam;
		$listUsersTeam = $db->fetchAll($sql);
		$tmp = '';
		foreach($listUsersTeam as $k=>$v) {
			$teams = $this->Team->getTeamsList($v['Tu']['user_id']);
			foreach($teams as $key => $val) {
				$tmp .= $key.',';
			}
		}
		$tmp = substr($tmp, 0, -1);
		//on verifie que le user n'est pas deja inscrit a event avec autre team
		$sql = "SELECT * FROM events_teams as et WHERE et.event_id=".$eventId." AND et.team_id IN(".$tmp.")";
		if ($db->fetchAll($sql)) {
			return -4;
		}
		if (!$this->Team->isLeaderOrSecondLeader($userId, $idTeam)) {
			return -2;
		}
		$sql = "INSERT INTO events_teams (event_id, team_id) VALUES(".$eventId.", ".$idTeam.")";
		$db->query($sql);
		return 0;
	}

	public function getSubscribed($userId) {
		$db = $this->getDataSource();
		$teams = $this->Team->getTeamsList($userId);
		if (!$teams) {
			return null;
		}
		$results = array();
		$tmp = '';
		foreach($teams as $k => $v) {
			$tmp .= $k.',';
		}
		$tmp = substr($tmp, 0, -1);
		$sql = "SELECT * FROM events_teams as EventTeam LEFT JOIN events as Event ON (EventTeam.event_id=Event.id) WHERE EventTeam.team_id IN (".
			$tmp.")";
		$results = $db->fetchAll($sql);
		foreach($results as $k => $v) {
			$results[$k]['EventTeam']['Team'] = $teams[$v['EventTeam']['team_id']];
			$game = $this->Game->findById($v['Event']['game_id']);
			$results[$k]['Game'] = $game['Game'];
		}
		return $results;
	}
	
	public function getSubsribedTeam($idEvent, $idUser) {
		//$db = $this->getDataSource();
		$this->recursive = 1;
		$event = $this->findById($idEvent);
		$team = array();
		foreach($event['Team'] as $t) {
			if ($t['leader_id'] == $idUser || $t['second_leader_id'] == $idUser) {
				$team = $t; break;
			}
		}
		return $team;
	}
	
	public function unsubsribedTeam($idEvent, $idTeam) {
		$db = $this->getDataSource();
		$sql = "DELETE FROM events_teams WHERE team_id=".$idTeam." AND event_id=".$idEvent;
		$db->query($sql);
	}
}

