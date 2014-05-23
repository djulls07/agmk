<?php
App::uses('AppController', 'Controller');
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		if (!$this->request->data) {
			$this->request->data = $this->User->findById($id);
			unset($this->request->data['User']['password']);
		}
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

	public function addFriend() {
		if ($this->request->is('post')) {
			$friend = $this->User->findById($id);
			if(!$friend) {
				throw new NotFoundException(__('Invalid friend'));
			}
			if ($this->User->saveAssociated($this->request->data) {
				$this->Session->setFlash(__('Friend added'));
				return $this->redirect(array('action' => 'view', $this->Auth->user('id')));
			}
		}
		$users = $this->User->find('list', array('fields' => array('User.id','User.username')));
		$this->set('users', $users);
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('logout', 'index', 'view', 'addFriend'))) return true;
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
}
