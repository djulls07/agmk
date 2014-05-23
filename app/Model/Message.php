<?php

class Message extends AppModel {


	public $hasMany = array(
		'Reponse' => array(
			'classname' => 'Reponse',
			'foreignKey' => 'message_id'
		)
	);
}

?>