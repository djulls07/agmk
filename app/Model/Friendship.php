<?php

class Friendship extends AppModel {

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

	public function notActiveFriendship($myId, $hisId) {
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
		if (!$friendship) {
			return false;
		}
		$id = $friendship['Friendship']['id'];
		if ($this->delete($id))
			return true;
		return false;
	}

	public function removeMe($friends, $myId) {
		foreach($friends as $k => $v) {
			if ($friends[$k]['User1']['id'] == $myId) {
				$friends[$k]['User'] = $friends[$k]['User2'];
			} else {
				$friends[$k]['User'] = $friends[$k]['User1'];				
			}
			unset($friends[$k]['User1']);
			unset($friends[$k]['User2']);
		}
		return $friends;
	}
}