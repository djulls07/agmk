<?php
App::uses('AppModel', 'Model');
App::uses('User', 'AppModel');

class Topic extends AppModel {

	public $useTable = 'forum_topics';

	public $hasMany = array(
		'Post' => array(
			'classname' => 'Post',
			'foreignKey' => 'topic_id',
			'dependent' => true,
			'order'=>array('Post.posted'=> 'asc')
		),
	);

	public $validate = array(
		'subject' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			)
		)
	);


	public function getPosters($posts) {
		//return $posts;
		$ids = array();
		$reqPart = "(";
		foreach($posts as $post) {
			if(!isset($ids[$post['poster_id']])) {
				$ids[$post['poster_id']] = $post['poster_id'];
			}
		}
		$reqPart .= implode(",", $ids);
		$reqPart .= ")";
		$db = $this->getDataSource();
		$sql = "SELECT * FROM forum_users as User WHERE id IN".$reqPart;
		$res = $db->query($sql);
		$sql = "SELECT * FROM forum_groups";
		$groups = $db->query($sql);
		$g = array();
		foreach($groups as $group) {
			$g[$group['forum_groups']['g_id']] = $group['forum_groups'];
		}
		foreach($res as $k=>$r) {
			$res[$k]['User']['group_id'] = $g[$res[$k]['User']['group_id']];
			$ids[$r['User']['id']] = $res[$k]['User'];
		}
		return $ids;
	}

	public function isDisp($topicId, $forum_user) {
		$userGid = $forum_user['group_id'];
		if ($userGid == 1) return true;
		$classUser = new User();
		$forum_indispo = $classUser->getForumIndispo($userGid);
		$topic = $this->find('all', array('conditions'=>array('id'=>$topicId)));
		if (!$topic) {
			throw new NotFoundException('Not found topic');
		}
		$forumId = $topic[0]['Topic']['forum_id'];
		if (!in_array($forumId, $forum_indispo)) {
			return true;
		} else {
			return false;
		}
	}
}
?>