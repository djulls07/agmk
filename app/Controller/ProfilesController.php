<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

class ProfilesController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow('checkSc2');
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('add'))) return true;
		return parent::isAuthorized($user);
	}

	public function add() {
		//$this->loadModel('User');
		$id = $this->Auth->user('id');
		if (!$this->Profile->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post')) {
			$this->Profile->create();
			$game = $this->Profile->Game->findById($this->request->data['Profile']['Game']);
			if (!$game) {
				throw new NotFoundException(__('Invalid game'));
			}
			$this->request->data['Profile']['user_id'] = $id;
			$this->request->data['Profile']['game_id'] = $this->request->data['Profile']['Game'];
			$this->request->data['Profile']['game_name'] = $game['Game']['name'];

			if ($this->Profile->save($this->request->data)) {
				$this->Session->setFlash(__('Profile has been saved'));
				return $this->redirect(array('controller' => 'users', 'action' => 'view', $id));
			}
		}
		$games = $this->Profile->Game->find('list', array(
			'fields' => array('Game.id', 'Game.name')
		));
		$this->set('games', $games);
	}

	public function checkSc2() {
		$socket = new HttpSocket();
		$reponse = $socket->get(
			'http://'.$this->request->data['region'].'.battle.net/api/sc2/profile/'.$this->request->data['id'].'/1/'.$this->request->data['name'].'/'
		);
		echo $reponse;
		exit();
	}

	/*public function checkSc2() {
		//if ($this->request->is("ajax")) {
			$req = $this->request->data;
			$socket = new HttpSocket();
			$socket->request['redirect'] = true;
			$data = array(
				//'name' => $req['name'],
				'bracket' => '1v1',
				'league' => 'all',
				'expansion' => 'hots',
				'rank_region' => 'global',
				'api_key' => 'YfFdxi1P4mY9UOwBORCuEn3L7oOdzjkZb18E'
			);
			$reponse = $socket->post(
				'http://api.sc2ranks.com/v2/characters/search?name='.$req['name'],
				$data
			);
			echo json_encode($reponse);
			exit();
		//}
	}*/

	public function admin_index() {
		if (!$this->request->is('get')) {
			throw new NotFoundException(__('Invalid method'));
		}
		$this->Profile->recursive = 1;
		$this->set('profiles', $this->Profile->find('all'));
	}
	
}