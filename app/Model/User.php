<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');
/**
 * User Model
 *
 * @property Post $Post
 * @property Profile $Profile
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	var $name='User';
    var $captcha = ''; //intializing captcha var

	public $validate = array(
		'username' => array(
			'required' => array (
				'rule' => array('notEmpty')
			),
			'unique' => array(
            	'rule'    => 'isUnique',
            	'message' => 'This username has already been taken.'
        	),
        	'between' => array(
        		'rule' => array('between', 5, 25),
        		'message' => 'Your username should be between 5 and 25 chars'
        	)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'between' => array(
				'rule' => array('between', 5, 50),
				'message' => 'Your password should have between 5 and 50 chars'
			)
		),
		'passwordr' => array(
			'notEmpty' => array(
				'rule' => array('passwordsEquals'),
				'message' => 'passwords should be the same.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'between' => array(
				'rule' => array('between', 5, 50),
				'message' => 'Your password should have between 5 and 50 chars'
			)
		),
		'role' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'captcha' => array(
			'rule' => array('matchCaptcha'),
			'message' => 'Failed human validation check.'
		),
		'newsParPage' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			)
		),
		'mail' => array(
			'required' => array (
				'rule' => array('notEmpty')
			),
			'unique' => array(
            	'rule'    => 'isUnique',
            	'message' => 'This email has already been taken.'
        	),
        	'between' => array(
        		'rule' => array('email'),
        		'message' => 'Should be a valid email please.'
        	)
		),
		'mailr'=>array(
			'notEmpty' => array(
				'rule' => array('mailsEquals'),
				'message'=> 'Email should be the same.'
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Article' => array(
			'classname' => 'Article',
			'foreignKey' => 'author_id',
			'dependent' => false,
			'fields' => array('Article.title', 'Article.id', 'Article.modified', 'Article.published')
		),
		'Notification' => array(
			'classname' => 'Notification',
			'foreignKey' => 'user_id',
			'dependent' => true
		),
		'Friendship' => array(
			'classname' => 'Frienship',
			'foreignKey' => false,
			'conditions' => array(
	            'OR' => array(
	                array('Friendship.user_id' => '{$__cakeID__$}'),
	                array('Friendship.friend_id' => '{$__cakeID__$}')
	            )
        	)
		)
	);

	public $hasAndBelongsToMany = array(
		'Team' => array(
			'classname' => 'Team',
			'joinTable' => 'teams_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'team_id'
		)
	);
	
	public $hasOne = array(
		'Wallet' => array(
			'classname' => 'Wallet',
			'foreignKey' => 'id_assoc',
			'conditions'=> array('type' => 0),
			'dependent'=>true
		)
	);

	public function beforeSave($options = array()) {
        if (!empty($this->data['User']['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash(
                $this->data['User']['password']
            );
        }
        if (isset($this->data['passwordr'])) {
        	unset($this->data['passwordr']);
        }
        if (isset($this->data['mailr'])) {
        	unset($this->data['mailr']);
        }
        return true;
    }

    function matchCaptcha($inputValue)  {
        return $inputValue['captcha']==$this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
    }

    function setCaptcha($value) {
        $this->captcha = $value; //setting captcha value
    }

    function getCaptcha()   {
        return $this->captcha; //getting captcha value
    }

    public function passwordsEquals() {
    	if ($this->data['User']['password'] == $this->data['User']['passwordr']) {
    		return true;
    	}
    	return false;
    }

    public function mailsEquals() {
    	if ($this->data['User']['mail'] == $this->data['User']['mailr']) {
    		return true;
    	}
    	return false;
    }

    public function afterFind($results, $primary) {
    	if (!isset($results['avatar']))
    		return $results;
    	$img = '/img/avatar.jpg';
    	if ($primary) {
    		foreach($results as $k => $val) {
    			if ( ! empty($results[$k]['User']['avatar']) ) {
				    if ( file_exists ( $results[$k]['User']['avatar'] ) ) { // toussa à mettre dans le model de l'user
				    	$results[$k]['User']['avatar'] = $results[$k]['User']['avatar'];
				    	continue;
			        }
			        $file_headers = @get_headers($results[$k]['User']['avatar']);
			        if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
			           continue;
			        }
			    }
			    $results[$k]['User']['avatar'] = $img;
		    }
    	} else {
			if ( ! empty($results['avatar']) ) {
			    if ( file_exists ( $results['avatar'] ) ) { // toussa à mettre dans le model de l'user
			    	$results['avatar'] = $results['avatar'];
			    	return $results;
		        }
		        $file_headers = @get_headers($results['avatar']);
		        if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
		        	return $results;
		        }
		    }
		    $results['avatar'] = $img;
    	}    
	    return $results;
    }

    /*public function isUploadedAvatar($avatar, $dest) {
    	//redimensionner ( compression image et check tailler extension)
    	if ($avatar['size'] > 1000000) return false;
    	$tmp_name = $avatar['tmp_name'];
    	$finfo = new finfo();
    	$info = $finfo->file($tmp_name, FILEINFO_MIME_TYPE);
    	if (in_array($info, array('image/jpeg', 'image/png'))) {
	    	if (move_uploaded_file($tmp_name, $dest))
	    		return true;
	    }
	    return false;
    }*/

    public function isUploadedAvatar($avatar, $dest) {
    	//redimensionner ( compression image et check tailler extension)
    	$tmp_name = $avatar['tmp_name'];
    	$finfo = new finfo();
    	$info = $finfo->file($tmp_name, FILEINFO_MIME_TYPE);
    	list($wSrc, $hSrc) = getimagesize($tmp_name);
    	$ratio = 100/$wSrc;
    	$imgDest = imagecreatetruecolor($wSrc*$ratio, $hSrc*$ratio);
    	if ($info == 'image/jpeg') {
    		$src = imagecreatefromjpeg($tmp_name);
    		imagecopyresized($imgDest, $src, 0,0,0,0, $wSrc*$ratio, $hSrc*$ratio, $wSrc, $hSrc);
    		imagejpeg($imgDest, $dest);
    		imagedestroy($tmp_name);
    		return true;
    	} else if ($info == 'image/png') {
    		$src = imagecreatefrompng($tmp_name);
    		imagecopyresized($imgDest, $src, 0,0,0,0, $wSrc*$ratio, $hSrc*$ratio, $wSrc, $hSrc);
    		imagepng($imgDest, $dest);
    		imagedestroy($tmp_name);
    		return true;
    	}
    	return false;
    }

    /*public function writeLoggedIn($idUser, $ipUser) {
    	$db = $this->getDataSource();
    	$time = time();
    	$sql = "DELETE FROM logged_ins WHERE user_id=".$idUser." OR time<=".$time;
    	$db->query($sql);
    	$sql = "INSERT INTO logged_ins (user_id, user_ip, time) VALUES ('".$idUser."', '".$ipUser."', '".($time+1200)."')";
    	$db->query($sql);
    }

    public function writeNotLoggedIn($idUser, $ipUser) {
    	$db = $this->getDataSource();
    	$sql = "DELETE FROM logged_ins WHERE user_id=".$idUser;
    	$db->query($sql);
    }*/


	public function getFavGames($user) {
		$games = $this->Profile->Game->find('list', array(
			'conditions' => array(
				'OR' => array(
					array('Game.id' => $user['idgame1']),
					array('Game.id' => $user['idgame2']),
					array('Game.id' => $user['idgame3'])
				)
			),
			'fields' => array('Game.id', 'Game.name')
		));
		return $games;
	}

	public function sendEmailActivation($userArr) {
		$user = $userArr['User'];

		$db = $this->getDataSource();
		$sql = "SELECT * FROM textes WHERE id=1";
		$res = $db->fetchAll($sql);

		$r = $res[0]['textes'];

		$link = "<a href=\"http://agamek.org/users/activate?h=".$user['password']."&u=".$user['username']."&e=".$user['mail']."\"> Account activation link</a>";

		$Email = new CakeEmail();
		$Email->emailFormat('html');
		$Email->from(array('contact@agamek.org' => 'AgameK'));
		$Email->to($user['mail']);
		$Email->subject($r['sujet']);
		$Email->send("<html><body>".$r['contenu'].$link."</body></html>");
	}

	public function sendEmailRecover($mailAdr) {
		//TODO:finir !
		$user = $this->findByMail($mailAdr);
		if (!$user) {
			return false;
		}
		$newPass = rand().'';
		$this->id = $user['User']['id'];
		$user = $user['User'];
		$this->saveField('password', $newPass);
		//le save crypte le pass
		$passwordHasher = new SimplePasswordHasher();
		$link = "<a href=\"http://agamek.org/users/recoverpassword?h=".$passwordHasher->hash($newPass)."&u=".$user['username']."&e=".$user['mail']."\"> I've got no brain, please please i beg you, reset my password...</a>";

		$Email = new CakeEmail();
		$Email->emailFormat('html');
		$Email->from(array('contact@agamek.org' => 'AgameK'));
		$Email->to($mailAdr);
		$Email->subject("Password Recovery");
		$Email->send("<html><body> Follow this link to reset password:<br />".$link." </body></html>");
		return true;
	}

	public function setForumPass($pass, $username) {
		$db = $this->getDataSource();
		$sql = "UPDATE forum_users SET password='".sha1($pass)."' WHERE forum_users.username='".$username."'";
		$db->query($sql);
	}

}




?>