<?php 
class CommentsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->deny('all');
		if ($this->action !== 'add') {
			$this->Session->setFlash(__('Resource unavalaible !'));
		}
	}
	
	public function index() {
	
	}
	
	public function edit() {
	
	}
	
	public function delete() {
	
	}
	
	public function add($postId= null) {
		if (!$postId) {
			throw new NotFoundException(__('Invalid Post'));
		}
		if ($this->request->is('post')) {
			$this->request->data['Comment']['user_id'] = 
				$this->Auth->user('id');
			$this->request->data['Comment']['post_id'] = $postId;
			
			$this->Comment->create();
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('Comment added'));
				return $this->redirect(array(
						'controller' => 'posts',
						'action' => 'view',
						$postId
					)
				);
			}
			$this->Session->setFlash(__('Unable to add your comment'));
		}
	}
	
	public function view($id = null) {
	
	}
	
	public function isAuthorized($user) {
		if ($this->action === 'add') {
			return true;
		}
		return false;
	}
	
}