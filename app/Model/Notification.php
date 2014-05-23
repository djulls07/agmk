<?php

class Notification extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'classname' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public function addFriend($id_src, $id_dest) {
		$data = array('')
	}
}

?>