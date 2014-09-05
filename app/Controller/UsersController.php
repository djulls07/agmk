<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public $helpers = array('Form', 'Html', 'Session', 'Captcha', 'Cache');

/**
 * index method
 *
 * @return void
 */
	
	public function beforeFilter() {
		$this->Auth->allow('login', 'add', 'admin_login', 'activate', 'recoverPassword', 'createOrLogFB');
	}
	
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	public function admin_edit($id = null) {
		$this->edit($id);
	}

	public function admin_index() {
		$this->index();
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->recursive = 1;
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array(
			'conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
		
		$this->set('are_friends', false);
		if ($this->User->Friendship->areActiveFriends(AuthComponent::user('id'), $id ))
			$this->set('are_friends', true);
	}

	public function admin_view($id = null) {
		$this->view($id);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//$this->loadModel('Friend');
		if ($this->Auth->user()!=null) {
			$this->Session->setFlash('Cant add account while you are logged in');
			return $this->redirect(array('controller'=>'articles', 'action'=>'index'));
		}
        $this->Captcha = $this->Components->load('Captcha', array('captchaType'=>'math', 'jquerylib'=>true, 'modelName'=>'User', 'fieldName'=>'captcha')); //load it
        if ($this->request->is('post')) {
        	if ($this->request->data['User']['password'] != $this->request->data['User']['passwordr']) {
        		$this->Session->setFlash(__('Passwords should be the same'));
        		return $this->redirect(array('controller'=>'users', 'action'=>'add'));
        	}
        	if ($this->request->data['User']['mail'] != $this->request->data['User']['mailr']) {
        		$this->Session->setFlash(__('Emails should be the same'));
        		return $this->redirect(array('controller'=>'users', 'action'=>'add'));
        	}
        	unset($this->request->data['User']['passwordr']);
        	unset($this->request->data['User']['mailr']);
            $this->User->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
            $this->User->set($this->request->data);
            $this->request->data['User']['avatar'] = '/img/avatar.jpg';
            $passwordHash = sha1($this->request->data['User']['password']);
            $username = $this->request->data['User']['username'];
            $mail = $this->request->data['User']['mail'];
            $time = time();
            if($this->User->validates()) {
                $this->User->create();
                if ($this->User->saveAssociated($this->request->data)) {
                	$db = $this->User->getDataSource();
                	//$sql = "INSERT INTO forum_users (group_id, username, password, email,title,realname,url,jabber,icq,msn,aim,yahoo,location,signature,disp_topics,disp_posts,email_setting,notify_with_post,auto_notify,show_smilies,show_img,show_img_sig,show_avatars,show_sig,timezone,dst,time_format,date_format,language,style,num_posts,last_post,last_search,last_email_sent,registered,registration_ip,last_visit,admin_note,activate_string,activate_key) ".
                	//	"VALUES(2, '".$username."', '".$passwordHash."', '".$mail."', NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,1,1,1,1,1,0,0,0,0,'english','Technetium',0,NULL,NULL,NULL,NULL,".time().",'".$this->request->clientIp()."',0,NULL,NULL,NULL)";
                	//$sql = "INSERT INTO forum_users VALUES(2, '".$username."', '".$passwordHash."', '".$mail."', NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,1,1,1,1,1,0,0,0,0,'english','Technetium',0,NULL,NULL,NULL,NULL,".time().",'".$this->request->clientIp()."',0,NULL,NULL,NULL)";
                	$sql = "INSERT INTO forum_users(group_id,username,password,email,language,style,registration_ip,registered) VALUES(4,'".$username."','".$passwordHash."','".$mail."','english', 'Air', '".$this->request->clientIp()."',".$time.")";
                	$db->query($sql);
               		$this->Session->setFlash(__('New user has been saved on agamek.org and forum. Please check your email to activate your account.'));
                	$user = $this->User->findByUsername($username);
                	$this->User->sendEmailActivation($user);
                	return $this->redirect(array('action' => 'login'));  
                }               
                $this->Session->setFlash(__('The user could not be saved, please try again'));
            } else {
                $this->Session->setFlash(__('Data validation failure'));
            }
        }
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$id || !$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$games = $this->User->Profile->Game->find('list', array('fields' => array('Game.id', 'Game.name')));
		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['User']['avatar2']['name']) && $this->request->data['User']['avatar1'] == '') {
				unset($this->request->data['User']['avatar']);
			} else if ($this->request->data['User']['avatar1'] != '') {
            		$this->request->data['User']['avatar'] = $this->request->data['User']['avatar1'];
	        } else {
            	//dans avatar2 on recoit l'upload, a gerer.
            	$this->request->data['User']['avatar'] = '/img/uploads/'.$this->Auth->user('id').'/'.
            		$this->request->data['User']['avatar2']['name'];
            	$dir = new Folder('img/uploads/'.$this->Auth->user('id'), true, 0755);	            		
            }
            for ($i=1; $i<4; $i++) {
            	$this->request->data['User']['namegame'.$i] = $games[$this->request->data['User']['idgame'.$i]];
            }
			if ($this->User->save($this->request->data)) {
				if (!empty($this->request->data['User']['avatar2']['name'])) {
                	if($this->User->isUploadedAvatar($this->request->data['User']['avatar2'], 
                			substr($this->request->data['User']['avatar'],1))) {
						$this->Session->setFlash(__('The user has been saved.'));
						$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
						return $this->redirect(array('action' => 'view', $this->Auth->user('id')));
					} else {
						$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
						$this->Session->setFlash(__('User saved, but error happened with file upload'));
					}
				} else {
					$this->Session->setFlash(__('The user has been saved.'));
					$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
					return $this->redirect(array('action' => 'view', $this->Auth->user('id')));
				}
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		if (!$this->request->data) {
			$this->request->data = $this->User->findById($id);
			unset($this->request->data['User']['password']);
		}
		$this->set('games', $games);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_delete($id = null) {
		$this->delete($id);
	}

	public function admin_login() {
		$this->login();
	}

	public function login() {
	    if ($this->request->is('post')) {
	    	$user = $this->User->findByUsername($this->request->data['User']['username']);
	    	if ($user && $user['User']['active']) {
		        if ($this->Auth->login()) {
			        $passwordHash = sha1($this->request->data['User']['password']);
			    	$username = $this->request->data['User']['username'];
			    	$mail = $this->Auth->user('mail');
			    	$time = time();
			    	if (empty($mail)) {
			    		$mail = "PLEASEsetyourmail@setyourmail.com";
			    	}
			    	$db = $this->User->getDataSource();
			    	$sql = "SELECT * FROM forum_users WHERE username='".$username."'";
			    	$res = null;
			    	$res = $db->query($sql);
			    	if ($res == null) {
			    		$sql = "INSERT INTO forum_users(group_id,username,password,email,language,style,registration_ip,registered) VALUES(4,'".$username."','".$passwordHash."','".$mail."','english', 'Air', '".$this->request->clientIp()."',".$time.")";
	                	$db->query($sql);
			    	}

		            return $this->redirect($this->Auth->redirect());
		        } else {
		            $this->Session->setFlash(__("Username or password incorrect"));
		        }
		    } else {
		    	$this->Session->setFlash('Account exists, please activate it ( check your email )');
		    	$this->User->sendEmailActivation($user);
		    }
	    }
	}

	public function admin_logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function logout() {
	    return $this->redirect($this->Auth->logout());
	}

	public function isAuthorized($user) {
		if (in_array($this->action, 
				array('logout', 'index', 'view', 'add_friend',
					'list_friend', 'myteams','getusernotifs',
					'getusers', 'alpha', 'saveChatState')))
			return true;
		if ($this->action ==='login') return false;
		if (in_array($this->action, array('delete', 'edit'))) {
			if ($user['id'] == (int) $this->request->params['pass'][0]) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}

	function captcha()  {
        $this->autoRender = false;
        $this->layout='ajax';
        if(!isset($this->Captcha))  { //if Component was not loaded throug $components array()
            $this->Captcha = $this->Components->load('Captcha', array(
                'width' => 150,
                'height' => 50,
                'theme' => 'random', //possible values : default, random ; No value means 'default'
            )); //load it
        }
        $this->Captcha->create();
    }

    public function getusernotifs() {
    	$tab = $this->User->find('first', array(
    		'conditions' => array('id' => $this->Auth->user('id')),
    		'fields' => array('notifications', 'messages')
    	));
    	echo json_encode($tab);
    	exit();
    }

    public function getusers($user) {
    	if ($this->request->is("ajax")) {
			$params = array(
				'conditions' => array(
					'User.username LIKE' => '%'.$user.'%'
				),
				'fields' => array('User.id','User.username'),
				'order' => 'User.username'
			);
			echo json_encode($this->User->find('all', $params));
			exit();
		}
    }

    public function alpha($idTeam) {
    	if (!$idTeam) {
    		throw new notFoundException(__('Invalid Team'));		
    	}
    	if ($this->request->is('post')) {
    		$this->User->id = $this->Auth->user('id');
    		if ($this->User->saveField('alpha_team_id', $idTeam)) {
    			$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
    			$this->Session->setFlash(__('Alpha Team added'));
    			return $this->redirect(array('controller' => 'teams', 'action' => 'index'));
    		}
    	}
    }

    public function saveChatState() {
    	if ($this->request->is("ajax")) {
    		$this->User->id = $this->Auth->user('id');
	    	if ($this->User->saveField('chat_state', $this->request->data['chatState'])) {
	    		$this->Session->write('Auth', $this->User->read(null, $this->Auth->user('id')));
	    		exit();
	    	}
    	}
    	exit();
    }

    public function activate() {
    	$hash = $this->request->query('h');
    	$username = $this->request->query('u');
    	$email = $this->request->query('e');
    	if (!$email || !$username || !$hash) {
    		throw new notFoundException(__('Invalid link'));		
    	}
    	$user = $this->User->findByUsername($username);
    	if ($user!=null) {
    		if ($user['User']['active'] != 1) {
    			$this->Session->setFlash('Account already activated');
    		}
    		$this->User->id = $user['User']['id'];
    		$this->User->saveField('active', 1);
    		$this->Session->setFlash("Account Activated.");
    		return $this->redirect(array('action'=>'login'));
    	} else {
    		throw new notFoundException(__('Invalid link'));
    	}
    	//return $this->redirect(array('controller'=>'articles','action'=>'index'));
    }

    public function recoverpassword() {
    		$email = $this->request->query('e');
	    	$passNC = $this->request->query('h');
	    	$username = $this->request->query('u');

	    if (isset($email) && isset($passNC) && isset($username)) {
	    	$user = $this->User->findByUsername($username);
	    	if (!$user) {
	    		throw new NotFoundException('__Invalid user');
	    	} else if ($user['User']['password']!=$passNC) {
	    		throw new NotFoundException('__Invalid link');
	    	}
	    	$this->set('phase2', 1);
	    	$this->set('hash',$h);
	    	$this->set('passnc', $passNC);
    	} else {
    		$this->set('phase2', 0);
    	}
    	if ($this->request->is('post')) {
    		if (isset($this->request->data['User']['password'])) {
    			if ($this->request->data['User']['password'] ==  $this->request->data['User']['passwordr']) {
    				if (!$user) {
    					throw new NotFoundException('Invalid Userr');
    				}
    				$this->User->id = $user['User']['id'];
    				
    				$this->User->saveField("password", $this->request->data['User']['password']);
    				$this->Session->setFlash('Password changed. You can now login');
    				$this->User->setForumPass($this->request->data['User']['password'], $username);
    				return $this->redirect(array('action'=>'login'));
    			} else {
    				$this->Session->setFlash("pass should be the same");
    				$this->set('phase2', 1);
    			}
    		} else {
	    		$this->User->sendEmailRecover($this->request->data['User']['mail']);
	    		$this->Session->setFlash('Email sent');
	    		return $this->redirect(array('action'=>'login'));
	    	}
    	}
    	//demande du mail user.
    }

    public function createOrLogFB() {
    	if ($this->request->is('ajax')) {
    		if ($this->Auth->user() == null) {
    			//pas log
    			echo 'okok';
    			exit();
    		} else {
    			$this->Session->setFlash('You already logged in !');
    			return $this->redirect(array('controller'=>'articles', 'action'=>'index'));
    		}
    	}
    }
}
?>