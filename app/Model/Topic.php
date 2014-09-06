<?php

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
		foreach($res as $r) {
			$ids[$r['User']['id']] = $r['User'];
		}
		return $ids;
	}
}
?>