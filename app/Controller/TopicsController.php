<?php

class TopicsController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter() {
		$this->Auth->deny("all");
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