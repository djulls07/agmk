<?php
App::uses('AppModel', 'Model');

class Category extends AppModel {

	public $useTable = 'forum_categories';

	public $hasMany = array(
		'Forum' => array(
			'classname' => 'Forum',
			'foreignKey' => 'cat_id',
			'dependent' => true
		)
	);
}
