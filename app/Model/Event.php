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
        		'rule' => array('between', 5, 25),
        		'message' => 'Your event name should be between 5 and 25 chars'
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

	public function addTeam($idTeam, $eventId) {
		$db = $this->getDataSource();
		$sql = "SELECT * FROM events_teams WHERE event_id=".$eventId." AND team_id=".$idTeam;
		if ($db->fetchAll($sql)) return false;
		$sql = "INSERT INTO events_teams (event_id, team_id) VALUES(".$eventId.", ".$idTeam.")";
		$db->query($sql);
		return true;
	}

	public function getSubscribed($userId) {
		$db = $this->getDataSource();
		$teams = $this->Team->getTeamsList($userId);
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

}
