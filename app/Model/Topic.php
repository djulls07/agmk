<?php

class Topic extends AppModel {

	public $hasMany = array(
		'Post' => array(
			'classname' => 'Post',
			'foreignKey' => 'topic_id',
			'dependent' => true
		),
	);
}