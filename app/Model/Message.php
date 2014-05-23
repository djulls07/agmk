<?php

class Message extends AppModel {

	public validate = array(
		'body' => array(
			'rule' => 'notEmpty'
		)
	);

	public $hasMany = array(
		'Reponse' => array(
			'classname' => 'Reponse',
			'foreignKey' => 'message_id'
		)
	);
}

?>