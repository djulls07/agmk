<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

class ProfilesController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow('checkSc2');
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
		$gamesInProfiles = $this->Profile->getGamesInProfiles($this->Auth->user('id'));
		//debug($gamesInProfiles);return;
		$games = $this->Profile->Game->find('list', array(
			'fields' => array('Game.id', 'Game.name')
		));
		foreach($games as $k =>$v) {
			if (isset($gamesInProfiles[$k])) {
				//user already have a profile for this game
				unset($games[$k]);
			}
		}
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

	public function createFromNotif($id_notif = null, $idTeam = null, $idProfileTeam = null) {
		$teamProfile = $this->Profile->User->Team->Teamprofile->findById($idProfileTeam);
		$games[$teamProfile['Teamprofile']['game_id']] = $teamProfile['Teamprofile']['game_name'];
		$this->set('games', $games);
		$this->set('params', array($id_notif, $idTeam, $idProfileTeam));
		//debug($games);
		if ($this->request->is('post')) {
			if (!empty($this->request->data['Profile']['level'])) {
				$this->Profile->create();
				$this->request->data['Profile']['user_id'] = $this->Auth->user('id');
				$this->request->data['Profile']['game_id'] = $teamProfile['Teamprofile']['game_id'];
				$this->request->data['Profile']['game_name'] = $teamProfile['Teamprofile']['game_name'];
				if ($this->Profile->save($this->request->data)) {
					if($this->Profile->User->Team->Teamprofile->addToRoster($this->Auth->user('id'), $teamProfile['Teamprofile']['game_id'], $idTeam)) {
						$this->Session->setFlash(__('Profile saved and added to Roster'));
						$this->Profile->User->Notification->delete($id_notif);
						return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
					}
				}
			}
		}
	}

	public function notcreateFromNotif($id_notif = null, $idTeam = null, $idProfileTeam = null) {
		$this->request->onlyAllow('post');
		if ($this->Profile->User->Notification->delete($id_notif)) {
			$this->Session->setFlash(__('Invitation to join Roster has been rejected'));
			return $this->redirect(array('controller' => 'teams', 'action' => 'view', $idTeam));
		} else {
			$this->Session->setFlash(__('Cant refuse, try again later'));
			return $this->redirect(array('controller' => 'notifications', 'action' => 'index'));
		}
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('add', 'createFromNotif', 'notcreateFromNotif'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}
	
}