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
		$this->set('forum', $forum);
		//debug($forum);
	}

	//autorisation
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}