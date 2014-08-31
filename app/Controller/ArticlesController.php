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
            $this->Batiment->Create();
            if ($this->Article->saveAssociated($this->request->data)) {
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
            $params = array(
                'order' => 'Article.modified DESC',
                'recursive' => 1,
                'limit' => 100,
                'fields' => array('Article.id, Article.title, Article.subtitle, Article.created, Article.author_id, Article.type, Article.game_id', 'Thumb.file','User.username'),
                'contain' => array('Thumb','User'),
                'conditions' => array('Article.published' => 1)
            );
        } else {
            /* display news about the $id (games table) */
            $params = array(
                'conditions' => array('Article.game_id' => $id, 'Article.published' => 1),
                'order' => 'Article.created DESC',
                'limit' => 100,
                'contain' => array('Thumb','User'),
                'recursive' => 0
            );
            $this->Article->Game->recursive = 1;
            $game = $this->Article->Game->findById($id);
            if (!$game) {
                throw new NotFoundException(__('Invalid Game'));
            }
            $this->set('game', $game);
            //debug($game);
        }
        $articles = $this->Article->find('all', $params);
        if (!$articles) {
            /* throw new NotFoundException(__('Invalid request')); */
            $this->Session->setFlash((__('No articles to show')));
            //return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
        }
        $newsParPage = 20; // nombre de news par page par défaut
        if ($this->Auth->user('id'))
            $newsParPage = $this->Auth->user('newsParPage');
        $this->set('newsParPage', $newsParPage);
        $this->set('articles', $articles);
		
		$Acomment=$this->Article->Acomment->find('all',array('order' => array('Acomment.article_id'), 'fields' => array('id', 'article_id')));
		$this->set('Acomment', $Acomment);
		
		$articles_a_la_une = array();
		$articles_main_news = array();
		foreach ($articles as $article_tmp){
			if ( $article_tmp['Article']['type'] == 1 ||  $article_tmp['Article']['type'] == 3)
				array_push($articles_main_news,$article_tmp);
			if ( $article_tmp['Article']['type'] >= 2 )
				array_push($articles_a_la_une,$article_tmp);
		}
		$this->set('articles_a_la_une', $articles_a_la_une);
		$this->set('articles_main_news', $articles_main_news);
		/* article.type = 0 :  normal ; article.type = 1 : main_news ; article.type = 2 : colonne droite ; article.type = 3 : main + droite*/
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

    public function view($id = null) {
        $this->Article->recursive = 2;
        $article = $this->Article->find('all', array('conditions' => array('Article.id' => $id)));
        if (!$article) {
            throw new NotFoundException(__('Invalid Article'));
        }
        if ($this->request->is('get')) {
            $this->set('article', $article[0]);
            $game = array();
            $game['Game'] = $article[0]['Game'];
            $game['Link'] = $article[0]['Game']['Link'];
            unset($game['Game']['Link']);
            $this->set('game', $game);
            //debug($article);
			
			$articles_a_la_une = $this->Article->find('all', array('recursive' => 0,'conditions' => array('Article.game_id' => $article[0]['Game']['id'], 'Article.published' => 1,'Article.type' => '2', 'Article.type' => '3' , 'NOT' => array('Article.id' => $id)),'order' => 'Article.modified DESC'));			
			$this->set('articles_a_la_une', $articles_a_la_une);
			/* article.type = 0 :  normal ; article.type = 1 : main_news ; article.type = 2 : colonne droite ; article.type = 3 : main + droite*/
        }
    }

    public function isAuthorized($user) {
        if ($user['role'] === 'basic') {
            $this->Session->setFlash(__('You are not author of the article'));
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