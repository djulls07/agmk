<?php

class Acomment extends AppModel {

	public $validate = array(
		'content' => array(
			'rule' => 'notEmpty'
		)
	);
	
	public $belongsTo = array(
		'User' => array(
			'classname' => 'User',
			'foreignKey' => 'user_id',
			'fields' => array('User.username, User.id, User.avatar')
		)
	);
}

?>