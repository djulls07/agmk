<?php 
class ForumsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->deny("all");
	}

	public function view($id = null) {
		$this->layout = 'default_forum';
		if (!$id) {
			throw new NotFoundException('Forum not found');
		}
		$forum = $this->Forum->find('first', array(
			'recursive'=>1,
			'conditions'=>array('id'=>(int)$id)
		));
		$forum['Topic'] = $this->sortSticky($forum['Topic']);
		$this->set('forum', $forum);
		//debug($forum);
	}

	public function sortSticky($results) {
		$ret = array();
		$i=0;
		foreach($results as $k=>$r) {
			if ($r['sticky'] == true) {
				$ret[$i++] = $r;
			}
		}
		foreach($results as $k=>$r) {
			if ($r['sticky'] != true) {
				$ret[$i++] = $r;
			}
		}
		return $ret;
	}

	//autorisation
	public function isAuthorized($user) {
		$this->fillForumSession();
		$forumId = (int) $this->request->params['pass'][0];
		if ($this->Forum->isDisp($forumId, $this->Session->read('forum_user'))) {
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