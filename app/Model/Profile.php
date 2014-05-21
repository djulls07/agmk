<?php

App::uses('Model', 'AppModel');

class Profile extends AppModel {
	

	public $validate = array(
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

}

?>