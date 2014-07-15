<?php
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
*/
class EventsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->Paginator->paginate());
		$this->set('teams', $this->Event->Team->find('list', array (
				'conditions' => array (
						'OR' => array (
								array ('leader_id' => $this->Auth->user('id')),
								array ('second_leader_id' => $this->Auth->user('id'))
						)
				)
		)
		));
		$subscribed = $this->Event->getSubscribed($this->Auth->user('id'));
		$this->set('subscribed', $subscribed);
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->Event->recursive = 1;
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$this->set('event', $this->Event->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			//unset($this->Event->Saison->validate);
			$this->Event->create();
			$this->request->data['Event']['date_debut'] .= ' 00:00:01';
			$this->request->data['Event']['date_fin'] .= ' 23:59:59';
			foreach($this->request->data['Saison'] as $k => $v) {
				$this->request->data['Saison'][$k]['date_debut'] = $v['date_debut'].' 00:00:01';
				$this->request->data['Saison'][$k]['date_fin'] = $v['date_fin'].' 23:59:59';
			}
			if ($this->Event->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		}
		//$users = $this->Event->User->find('list');
		$games = $this->Event->Game->find('list');
		//$teams = $this->Event->Team->find('list');
		$this->set(compact('users', 'games', 'teams'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
		$users = $this->Event->User->find('list');
		$games = $this->Event->Game->find('list');
		$teams = $this->Event->Team->find('list');
		$this->set(compact('users', 'games', 'teams'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Event->delete()) {
			$this->Session->setFlash(__('The event has been deleted.'));
		} else {
			$this->Session->setFlash(__('The event could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$this->set('event', $this->Event->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		}
		$users = $this->Event->User->find('list');
		$games = $this->Event->Game->find('list');
		$teams = $this->Event->Team->find('list');
		$this->set(compact('users', 'games', 'teams'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
		$users = $this->Event->User->find('list');
		$games = $this->Event->Game->find('list');
		$teams = $this->Event->Team->find('list');
		$this->set(compact('users', 'games', 'teams'));
	}

	/**
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Event->delete()) {
			$this->Session->setFlash(__('The event has been deleted.'));
		} else {
			$this->Session->setFlash(__('The event could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function addTeam() {
		if ($this->request->is('post')) {
			$id = $this->Auth->user('id');
			$switch = $this->Event->addTeam($this->request->data['Event']['teams'], $this->request->data['Event']['eventId'], $id);
			if ($switch == 0) {
				$this->Session->setFlash(__("Subscribe OK"));
				return $this->redirect(array('action' => 'view', $this->request->data['Event']['eventId']));
			} else if ($switch == -1) {
				$this->Session->setFlash(__("You have already subscribe to this Event with this team"));
				return $this->redirect(array('action' => 'index'));
			} else if($switch == -2) {
				$this->Session->setFlash(__("You have to be team leader to subscribe"));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__("You or a member of your team has already subscribe to this event with another team"));
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function deleteTeam($id) {
		$this->request->allowMethod('post');
		$userId = $this->Auth->user('id');
		$team = $this->Event->getSubsribedTeam($id, $userId);
		if ($team == null) {
			$this->Session->setFlash(__('You cant do this action'));
			return $this->redirect(array('controller'=>'events', 'action'=>'index'));
		}
		$teamId = $team['id'];
		if ($this->Event->Team->isLeaderOrSecondLeader($userId, $teamId)) {
			$this->Event->unsubsribedTeam($id, $teamId);
			$this->Session->setFlash(__('Your team has been removed from event'));
			return $this->redirect(array('controller'=>'events', 'action'=>'index'));
		} else {
			$this->Session->setFlash(__('You have to be the team leader'));
			return $this->redirect(array('controller'=>'events', 'action'=>'index'));
		}
	}


	public function isAuthorized($user) {
		if ($this->action === "addTeam") {
			return true;
		}
		if ($this->action === 'deleteTeam') {
			return true;
		}
		return parent::isAuthorized($user);
	}
}
