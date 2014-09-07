<?php
class Forum extends AppModel {

	public $useTable = 'forum_forums';

	public $hasMany = array(
		'Topic' => array(
			'classname' => 'Topic',
			'foreignKey' => 'forum_id',
			'dependent' => true,
			'order'=>array('Topic.last_post'=>'desc')
		)
	);

	public function isDisp($forumId, $forum_user) {
		$userGid = $forum_user['group_id'];
		if ($userGid == 1) return true;
		$classUser = new User();
		$forum_indispo = $classUser->getForumIndispo($userGid);
		if (in_array($forumId, $forum_indispo)) {
			return false;
		}
		return true;
	}
}