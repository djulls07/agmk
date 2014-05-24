<?php

class Friendship extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'classname' => 'User'
		)
	);

	public function canBeAdded($myId, $hisId) {
		$params = array(
			'conditions' => array(
	            'OR' => array(
	            	array(
		            	'AND' => array(
			                array('Friendship.user_id' => $myId),
			                array('Friendship.friend_id' => $hisId)
			            )
			        ),
			        array(
			        	'AND' => array(
			            	array('Friendship.user_id' => $hisId),
			                array('Friendship.friend_id' => $myId)
			            )
			        )
	            )
        	)
		);
		if ($this->find('all', $params)) {
			return false;
		}
		return true;
	}

	public function activeFriendship($myId, $hisId) {
		$params = array(
			'conditions' => array(
	            'OR' => array(
	            	array(
		            	'AND' => array(
			                array('Friendship.user_id' => $myId),
			                array('Friendship.friend_id' => $hisId)
			            )
			        ),
			        array(
			        	'AND' => array(
			            	array('Friendship.user_id' => $hisId),
			                array('Friendship.friend_id' => $myId)
			            )
			        )
	            )
        	)
		);
		$friendship = $this->find('first', $params);
		$friendship['Friendship']['actif'] = 1;
		if (!$friendship) {
			return false;
		}
		if ($this->save($friendship)) 
			return true;
		return false;
	}
}