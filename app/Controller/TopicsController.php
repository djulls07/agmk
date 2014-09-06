<?php

class TopicsController extends AppController {

	public $components = array('Paginator');

	public function beforeFilter() {
		$this->Auth->deny("all");
	}

	public function view($id = null) {
		$this->loadModel('Post');
		$this->layout = 'default_forum';
		$topic = $this->Topic->find('all',array('recursive'=>1, 'conditions'=>array('id'=>$id)));
		if (!$topic) {
			throw new NotFoundException('Topics not found');
		}
		$this->Paginator->settings = array(
			'recursive'=>1,
			'conditions'=>array('id'=>$id)
		);
		$posters = $this->Topic->getPosters($topic[0]['Post']);
		$this->set('topic', $this->Paginator->paginate());
		$this->set('posters', $posters);
	}
	


	//autorisation
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}