
<?php

class Friend extends AppModel {


	/*public $hasAndBelongsToMany = array(
		'User' => array(
			'classname' => 'User',
			'joinTable' => 'friends_users',
			'foreignKey' => 'friend_id',
			'associationForeignKey' => 'user_id',
			'fields' => array('User.id', 'User.username')
		)
	);*/

	public function addPotential($id) {
		$data = array('user_id' => $id);
		if ($this->save($data)) return true;
		return false;
	}
}

?>