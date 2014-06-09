<?php

App::uses('Model', 'AppModel');

class Profile extends AppModel {
	

	public $validate = array(
		'level' => array(
			'required' => array (
				'rule' => array('notEmpty')
			)
		),
		'pseudo' => array(
			'required' => array (
				'rule' => array('notEmpty')
			)
		),
	);

	public $belongsTo = array(
		'Game' => array(
			'classname' => 'Game',
            'fields' => array('Game.id', 'Game.name'),
            'foreignKey' => 'game_id'
		),
		'User' => array(
			'classname' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public function canBeAdded($profile) {
		if (!empty($profile['pseudo']) && !empty($profile['game_id'])) {
			return true;
		}
		return false;
	}

	public function hasProfile($idUser, $idGame) {
		$profile = $this->find('first', array(
			'conditions' => array(
				'Profile.user_id' => $idUser,
				'Profile.game_id' => $idGame
			)
		));
		if (!$profile) {
			return false;
		}
		return true;
	}

}

?>