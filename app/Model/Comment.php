<?php
class Comment extends AppModel {

	public $validate = array(
		'body' => array(
			'rule' => 'notEmpty'
		)
	);
	
	public $belongsTo = array(
		'User' => array(
			'classname' => 'User',
			'foreignKey' => 'user_id',
			'fields' => array('User.username, User.id')
		)
	);
	
}
?>