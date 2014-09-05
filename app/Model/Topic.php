<?php

class Topic extends AppModel {

	public $useTable = 'forum_topics';

	public $hasMany = array(
		'Post' => array(
			'classname' => 'Post',
			'foreignKey' => 'topic_id',
			'dependent' => true
		),
	);
}
?>