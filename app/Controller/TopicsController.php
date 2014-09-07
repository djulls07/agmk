<?php

class TopicsController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter() {
		$this->Auth->deny("all");
	}

	public function add($forumId) {
		$this->layout = 'default_forum';

		$this->loadModel('Forum');
		$this->loadModel('User');
		$user = $this->User->readForumUser($this->Auth->user());
		$forum = $this->Forum->find('all', array('conditions'=>array('id'=>$forumId)));
		if (!$forum) {
			throw new NotFoundException('Forum not found');
		}
		$forum = $forum[0];
		$forum_indispo = $this->User->getForumIndispo($user['group_id']);
		if (in_array($forum['Forum']['id'], $forum_indispo)) {
			$this->Session->setFlash('Dont have the right');
			return $this->redirect(array('controller'=>'forums', 'action'=>'view', $forumId));
		}

		if ($this->request->is('post')) {
			debug($this->request->data);
			//save topic, le post assoc, forum egalement ( topic++ etc) TODO...
		}

		$this->set('forum', $forum);

	}

	public function view($id = null, $page=1) {
		$this->loadModel('Post');
		$this->layout = 'default_forum';
		$topic = $this->Topic->find('all',array('recursive'=>0, 'conditions'=>array('id'=>$id)));
		if (!$topic) {
			throw new NotFoundException('Topics not found');
		}
		$count = $this->Topic->Post->countPosts($id);
		$count = $count[0][0]['COUNT(*)'];
		$nbPage = (int)($count/25) + 1;
		if ($page < 0) {
			$page = $nbPage;
		}
		if ($page > $nbPage) {
			return $this->redirect(array('controller'=>'categories', 'action'=>'index'));
		}
		/*$this->Paginator->settings = array(
			'recursive'=>1,
			'conditions'=>array('id'=>$id),
			'limit'=>25
		);*/
		$topic[0]['Post'] = $this->Topic->Post->myFind($page, $id);
		//debug($topic[0]['Post']);
		$posters = $this->Topic->getPosters($topic[0]['Post']);
		
		//creation index pagination
		$index = array();
		if ($page>1) {
			$index[0] = '<li class="active"><a href="http://agamek.org/topics/view/'.$id.'/'.($page-1).'">Prev</a></li>';
		} else {
			$index[0] = '<li class="disable"><a href="#">Prev</a></li>';
		}

		for ($i=1;$i<=$nbPage;$i++) {
			if ($i == $page) {
				$index[$i] = '<li class="active"><a href="http://agamek.org/topics/view/'.$id.'/'.$i.'">'.$i.'</a></li>';
			} else {
				$index[$i] = '<li><a href="http://agamek.org/topics/view/'.$id.'/'.$i.'">'.$i.'</a></li>';
			}
		}

		if ($page<$nbPage) {
			$index[$nbPage+1] = '<li class="active"><a href="http://agamek.org/topics/view/'.$id.'/'.($page+1).'">Next</a></li>';
		} else {
			$index[$nbPage+1] = '<li class="disable"><a href="#">Next</a></li>';
		}
		$this->Topic->id = $id;
		$this->Topic->saveField('num_views', $topic[0]['Topic']['num_views']+1);
		$this->set('topic', $topic);
		$this->set('posters', $posters);
		$this->set('index', $index);
		$this->set('page', $page);
	}
	


	//autorisation
	public function isAuthorized($user) {
		/* si afmin fofo ou agmk ok sinon need savoir si forum_id ok pour le group_id du user */
		$this->fillForumSession();
		$topicId = (int) $this->request->params['pass'][0];
		if ($this->Topic->isDisp($topicId, $this->Session->read('forum_user'))) {
			return true;
		} else {
			return false;
		}
		return parent::isAuthorized($user);
	}

	public function fillForumSession() {
		$fuser = $this->Session->read('forum_user');
		//if(empty($fuser)) {
			$this->loadModel('User');
			$fuser = $this->User->readForumUser($this->Auth->user());
			$this->Session->write('forum_user', $fuser);
		//}
	}
}