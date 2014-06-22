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
		$this->Auth->allow('login', 'add', 'admin_login');
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
        $this->Captcha = $this->Components->load('Captcha', array('captchaType'=>'math', 'jquerylib'=>true, 'modelName'=>'User', 'fieldName'=>'captcha')); //load it
        if ($this->request->is('post')) {
            $this->User->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
            $this->User->set($this->request->data);
            unset($this->User->Profile->validate['user_id']);
            /* l'ajout d'utilisateur propose l'ajout de profile, on les
			 * verifie et retire ceux qui sont vide pour eviter de sercharger bdd.
             */
            foreach ($this->request->data['Profile'] as $k => $profile) {
                if (!$this->User->Profile->canBeAdded($profile)) {
                	unset($this->request->data['Profile'][$k]);
                }
            }
            $this->request->data['User']['avatar'] = '/img/avatar.jpg';
            if($this->User->validates()) {
                $this->User->create();
                if ($this->User->saveAssociated($this->request->data)) {
               		$this->Session->setFlash(__('New user has been saved'));
                	return $this->redirect(array('action' => 'login'));  
                }               
                $this->Session->setFlash(__('The user could not be saved, please try again'));
            } else {
                $this->Session->setFlash(__('Data validation failure'));
            }
        }
        $games = $this->User->Profile->Game->find('list', array(
            'fields' => array('Game.id', 'Game.name'),
            'recursive' => 0
        ));
        $this->set('games', $games);
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
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirect());
	        } else {
	            $this->Session->setFlash(__("Username or password incorrect"));
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

}
?>