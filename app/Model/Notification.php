<?php

class Notification extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'classname' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public function addFriend($id_src, $friends) {
		foreach($friends as $k => $val) {
			$data = array('user_id' => $val, 'content' => 'New friend request', 'controller' => 'friendsusers', 'action' => 'active' ,'param1' => $id_src);
			$user = $this->User->findById($val);
			$user['User']['notifications']++;
			unset($user['User']['password']);
			if (!$this->save($data)) {;
				return false;
			}
			if (!$this->User->save($user)) {
				debug($user);
				return false;
			}
		}
		return true;
	}
}

?>