<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
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
				'rule' => array('between', 5, 25),
				'message' => 'Your password should have between 5 and 25 chars'
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
			'message' => 'Failed human validation check'
		),
		'newsParPage' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			)
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
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
		)
	);

	public $hasAndBelongsToMany = array(
		'Friend' => array(
			'classname' => 'User',
			'joinTable' => 'friends_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'friend_id',
            'fields' => array('User.id', 'User.username')
		)
	);

	public function beforeSave($options = array()) {
        if (!empty($this->data['User']['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash(
                $this->data['User']['password']
            );
        }
        return true;
    }

    public function addFriend($idUser, $idFriend) {
    	if ($idUser == $idFriend) {
    		return false;
    	}
    	
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

}
