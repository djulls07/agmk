<?php
App::uses('AppModel', 'Model');

class Saison extends AppModel {
	public $validate = array(
		'date_debut' => array(
			'required' => array (
				'rule' => array('notEmpty')
			),
		),
		'date_fin' => array(
			'required' => array (
				'rule' => array('notEmpty')
			)
		)
	);
}

?>