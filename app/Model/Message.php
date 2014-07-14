<?php

class Message extends AppModel {

	public $validate = array(
		'body' => array(
			'rule' => 'notEmpty'
		),
		'dest_username' => array(
			'rule' => 'notEmpty'
		),
		'dest_id' => array(
			'rule' => 'notEmpty'
		)
	);

	public $hasMany = array(
		'Reponse' => array(
			'classname' => 'Reponse',
			'foreignKey' => 'message_id'
		)
	);

	public $belongsTo = 'User';

	public function isConcerned($idUser, $idMessage) {
		$message = $this->findById($idMessage);
		if ($message['Message']['dest_id'] == $idUser) {
			return true;
		}
		return false;
	}
}

?>