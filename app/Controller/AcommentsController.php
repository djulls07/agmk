<?php

class AcommentsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}

	public function add($postId= null) {
		if (!$postId) {
			throw new NotFoundException(__('Invalid Article'));
		}
		if ($this->request->is('post')) {
			$this->request->data['Acomment']['user_id'] = 
				$this->Auth->user('id');
			$this->request->data['Acomment']['article_id'] = $postId;			
			$this->Acomment->create();
			if ($this->Acomment->save($this->request->data)) {
				$this->Session->setFlash(__('Comment added'));
				return $this->redirect(array(
						'controller' => 'articles',
						'action' => 'view',
						$postId
					)
				);
			}
			$this->Session->setFlash(__('Unable to add your comment'));
		}
	}

	public function isAuthorized($user) {
		if (in_array($this->action, array('add'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}
}
?>