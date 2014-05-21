<?php

App::uses('AppController', 'Controller');


class ArticlesController extends AppController {

    public $helpers = array('Form', 'Html', 'Session', 'Media.Media');
    public $components = array('Session', 'Paginator');
    
    public function beforeFilter() {
        $this->Auth->allow('view', 'index');
    }

    public function add() {

        if ($this->request->is('post')) {
            $this->request->data['Article']['author_id'] = $this->Auth->user('id');
            $this->request->data['Article']['published'] = 0;
            $this->Article->Create();
            if ($this->Article->save($this->request->data)) {
                $this->Session->setFlash(__('Your article has been created'));
                return $this->redirect(array(
                        'action' => 'edit',
                        $this->Article->id
                ));
            }
            $this->Session->setFlash(__('Unable to add your article'));
        }
        $this->set('games', $this->Article->Game->find('list', array('fields'=> array('Game.id', 'Game.name'))));
    }

    /* List to admin them */
    public function display($id = null) {
        
    }

    public function admin_index($id = null) {
        $this->Article->recursive = 0;
        $this->set('articles', $this->Paginator->paginate());
    }
    
    public function index($id = null) {
        if (!$id) {
            /* diplay news about everything */
            $conditions = array('Article.published' => 1);
            $params = array(
                'order' => 'Article.modified DESC',
                'limit' => 10,
                'fields' => array('Article.id, Article.title, Article.subtitle, Article.created, Article.author_id', 'Thumb.file'),
                'contain' => array('Thumb'),
                'conditions' => $conditions
            );
        } else {
            /* display news about the $id (games table) */
            $params = array(
                'conditions' => array('Article.game_id' => $id),
                'order' => 'Article.created DESC',
                'limit' => 10,
                'fields' => array('Article.id, Article.title, Article.subtitle, Article.created, Article.author_id', 'Thumb.file'),
                'contain' => array('Thumb'),
                'conditions' => $conditions
            );
        }
        $articles = $this->Article->find('all', $params);
        if (!$articles) {
            /* throw new NotFoundException(__('Invalid request')); */
            $this->Session->setFlash((__('No articles to show')));
            //return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
        }
        $this->set('articles', $articles);
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');
        $this->Article->id = $id;
        
        if (!$this->Article->exists()) {
            throw new NotFoundException(__('Invalid article'));
        }
        if ($this->Article->delete()) {
            $this->Session->setFlash(__('Your article has been deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->setFlash(__('Unable to delete your article'));
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid article'));
        }
        $article = $this->Article->findById($id);
        if (!$article) {
            throw new NotFoundException(__('Invalid Article'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->Article->id = $id;
            if ($this->Article->save($this->request->data)) {
                $this->Session->setFlash(__('Article updated'));
                return $this->redirect(array('action' => 'view', $id));
            }
            $this->Session->setFlash(__('Unable to save your article'));
        }

        if (!$this->request->data) {
            $this->request->data = $article;
        } 
        $tags = $this->Article->Tag->find('list', array(
            'fields' => array('Tag.content')
        ));
        $this->set('tags', $tags);
        $this->set('games', $this->Article->Game->find('list', array('fields'=> array('Game.id', 'Game.name'))));

    }

    public function view() {
        
    }

    public function isAuthorized($user) {
        if ($user['role'] === 'basic') {
            $this->Session->setFlash(__('You are not author or owner of the article'));
        }
        if ($user['role'] === 'author') {
            if (in_array($this->action, array('index', 'add'))) {
                return true;
            }
            if (in_array($this->action, array('edit', 'delete'))) {
                $articleId = (int) $this->request->params['pass'][0];
                if ($this->Article->isOwnedBy($articleId, $user['id'])) {
                    return true;
                } else {
                    $this->Session->setFlash(__('You should be owner to delete or edit'));
                }
            }
        }
        return parent::isAuthorized($user);
    }

}

?>