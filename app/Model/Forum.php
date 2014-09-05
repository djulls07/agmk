<?php
class Forum extends AppModel {

	public $useTable = 'forum_forums';

	public $hasMany = array(
		'Topic' => array(
			'classname' => 'Topic',
			'foreignKey' => 'forum_id',
			'dependent' => true
		)
	);
}