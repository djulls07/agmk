<?php

App::uses('AppController', 'Controller');

class PostsController extends AppController {
    /*public $cacheAction = array(
    'view'  => array('callbacks' => true, 'duration' => 50)
);*/

    public $paginate = array(
        'fields' => array('Post.id', 'Post.poster', 'Post.message', 'Post.posted'),
        'limit' => 50,
        'order' => array(
            'Post.created' => 'desc'
        )
    );

    public function beforeFilter() {
        $this->Auth->allow('index');
    }

    public function index() {
        //$this->set('posts', $this->Post->find('all'));
        $this->Post->recursive = 0;
        $this->set('posts', $this->paginate());
    }

    public function admin_index() {
        $this->index();
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid Post'));
        }
        $this->Post->recursive = 0;
        $post = $this->Post->read(array('Post.poster', 'Post.message'),$id);
        if (!$post) {
            throw new NotFoundException(__('Invalid Post'));
        }
        $this->set('post', $post);
    }

    public function admin_view($id = null) {
        $this->view($id);
    }

    public function add() {
        debug($this->request->data);
        if ($this->request->is('post')) {
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            $this->Post->create();
            debug($this->request->data);
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid Post'));
        }

        $post = $this->Post->findById($id);

        if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been updated'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to validate your post'));
        }

        if (!$this->request->data) {
            $this->request->data = $post;
        }
    }

    public function delete($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid Post'));
        }
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Post->delete($id)) {
            $this->Session->setFlash(__('The post with id: %s has been deleted', h($id)));
            return $this->redirect(array('action' => 'index'));
        }
    }

    public function isAuthorized($user) {
        return parent::isAuthorized($user);
        if ($this->action === 'add' || $this->action === 'view') {
            return true;
        }
        if (in_array($this->action, array('edit', 'delete'))) {
            $postId = (int) ($this->request->params['pass'][0]);
            if ($this->Post->isOwnedBy($postId, $user['id']) || $user['role'] === 'admin') {
                return true;
            } else {
                $this->Session->setFlash(__('You should be owner of the post to Delete / Edit'));
                return false;
            }
        }
        return parent::isAuthorized($user);
    }

}

?>