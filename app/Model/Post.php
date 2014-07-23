<?php
class Post extends AppModel {

	public $validate = array(
		'title' => array(
		'rule' => 'notEmpty'
		),
		'body' => array(
		'rule' => 'notEmpty'
		)
	);
	
	public $belongsTo = array(
		'User' => array(
			'classname' => 'User',
			'foreignKey' => 'user_id',
			'fields' => 'User.username'
		)
	);
	
	public $hasMany = array(
		'Comment' => array(
			'classname' => 'Comment',
			'foreignKey' => 'post_id',
			'limits' => '25',
			'order' => 'Comment.created ASC'
		)
	);
	
	public function isOwnedBy($post, $user) {
		if ($this->field('id', array('id' => $post, 'user_id' => $user)) == false) {
			return false;
		}
		return true;
	}

}
?>