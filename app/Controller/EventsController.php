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
		$event = $this->Event->find('first', $options);

		/* on regarde si event built, sinon on le fait( si date debut depassée ) */
		$now = time();
		$date_debut = new DateTime($event['Event']['date_debut']);
		$debut = $date_debut->getTimestamp();
		$eventStarted = ($debut <= $now) ? true : false;
		$beenBuilt = $event['Event']['hasBeenBuilt'];
		$teams = $event['Team'];
		if ($teams != NULL) {
			$rosters = $this->Event->Team->getRosters($teams, $event['Event']['game_id']);
		foreach($teams as $team) {
			$rosters[$team['id']]['Team'] = $team;
			$rosters[$team['id']]['roster'] = explode(',', $rosters[$team['id']]['roster']);
		}
		if ($eventStarted && !$beenBuilt && count($teams) >= $event['Event']['min_teams']) {
			/* on creer tous les matchs etc etc */
			
			$rostersByLvl = array();
			$rostersByLvlNb = array();
		
			foreach($rosters as $roster) {
				if (!is_array($rostersByLvl[$roster['level']])) {
					$rostersByLvl[$roster['level']] = array();
					$rostersByLvlNb[$roster['level']] = 0;
				}
				array_push($rostersByLvl[$roster['level']], $roster);
				$rostersByLvlNb[$roster['level']]++;
			}
			foreach($rostersByLvl as $k=>$v) {
				//lvl => $k
				$data = array();
				$this->Event->Division->create();
				$division = array('level'=>$k, 'name'=>'D'.(10-$k), 'event_id'=>$id);
				$this->Event->Division->save($division);
				$division = $this->Event->Division->find('first', array('conditions'=>array('level'=>$k, 'event_id'=>$id)));
				$i=0;
				foreach($v as $t) {
					$data['Team'][$i] = $t['Team'];
					$i++;
				}
				$this->Event->Division->saveAssocDivTeam($data, $division['Division']['id']);
				$nbRosters = $rostersByLvlNb[$k];
				$nbMatches = (($nbRosters)*($nbRosters+1))/2; //somme des n premiers termes.
				unset($data);
				$data = array();
				for($i=0;$i<$nbMatches;$i++) {
					array_push($data, array('Match'=>array(
						'event_id'=>$id,
						'division_id'=>$division['Division']['id']
					)));
				}
				$this->Event->Match->saveAll($data);
			}
			$this->Event->id = $id;
			$this->Event->saveField('hasBeenBuilt', true);
			
		}
		}
		


		//TODO: creer division selon level puis matchs etc...
		/* 1er: parcourir tableau roster et ranger par level ! */
		

		
			//on peut continuer !
			//creation des matches
			//nm de matches par division=((nbTeamDiv)*(nbTeamDiv + 1))/2

		$event['Team'];
		$event['Roster'] = $rostersByLvl;
		$this->set('event',$event);
		//debug($data);
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
			} else if ($switch == -3) {
				$this->Session->setFlash(__("You Need a roster of the event's game to subscribe"));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__("You or a member of your team has already subscribe to this event with another team"));
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function testAction() {
		$data = array();
		for($i=0;$i<60;$i++) {
			$this->Event->Team->User->create();
			$this->Event->Team->User->save(array('User'=>array('username'=>$i.'userame', 'password'=>'nuage009')));
			if (in_array($i, array(4,9,14,19,24,29,34,39,44,49,54,59))) {
				//leader et creation team
				$this->Event->Team->create();
				$u = $this->Event->Team->User->find('first', array('conditions'=> array('username'=>$i.'userame')));
				$j = $u['User']['id'];
				$this->Event->Team->save(array('Team'=>array(
						'leader_id'=>$j,
						'name'=>$i.'team',
						'tag'=>$i.'tag'
					)
				));
				$db = $this->Event->getDataSource();
				$teamId=$this->Event->Team->getLastInsertId();
				$users = array();
				$users[0] = $this->Event->Team->User->find('first', array('conditions'=> array('username'=>$i.'userame')));
				$users[1] = $this->Event->Team->User->find('first', array('conditions'=> array('username'=>($i-1).'userame')));
				$users[2] = $this->Event->Team->User->find('first', array('conditions'=> array('username'=>($i-2).'userame')));
				$users[3] = $this->Event->Team->User->find('first', array('conditions'=> array('username'=>($i-3).'userame')));
				$users[4] = $this->Event->Team->User->find('first', array('conditions'=> array('username'=>($i-4).'userame')));
				$sql = "INSERT INTO teams_users (team_id, user_id, actif) VALUES (".$teamId.",".$users[0]['User']['id'].", 1), (".$teamId.",".$users[1]['User']['id'].", 1), (".$teamId.",".$users[2]['User']['id'].", 1), (".$teamId.",".$users[3]['User']['id'].", 1), (".$teamId.",".$users[4]['User']['id'].", 1)";
				$db->query($sql);
				//ajouter teamprofiles pour ce jeu
				//TODO:finir ca
			}
		}
		return $this->redirect(array('action'=>'index'));
	}
	public function testAction2() {
		for($i=0;$i<60;$i++) {
			$this->Event->Team->User->recursive = 0;
			$u = $this->Event->Team->User->find('first', array(
				'conditions'=> array('username'=>$i.'userame'),
				'recursive'=>0
			));
			$this->Event->Team->User->delete($u['User']['id']);
			if (in_array($i, array(4,9,14,19,24,29,34,39,44,49,54,59))) {
				$t = $this->Event->Team->find('first', array('conditions'=> array('name'=>$i.'team')));
				$this->Event->Team->delete($t['Team']['id']);
			}
		}
		return $this->redirect(array('action'=>'index'));
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
		if ($this->action === "testAction" && $user['id'] == 72) {
			return true;
		}
		if ($this->action === "testAction2" && $user['id'] == 72) {
			return true;
		}
		return parent::isAuthorized($user);
	}
}
