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
        $this->Auth->deny('all');
    }

   /* public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid Post'));
        }
        $this->Post->recursive = 0;
        $post = $this->Post->read(array('Post.poster', 'Post.message'),$id);
        if (!$post) {
            throw new NotFoundException(__('Invalid Post'));
        }
        $this->set('post', $post);
    }*/

    public function add($idTopic=null) {
        $this->layout="default_forum";

        $this->loadModel('Topic');
        $this->loadModel('User');
        $this->loadModel('Forum');

        $user = $this->User->readForumUser($this->Auth->user());

        $topic = $this->Topic->find('all', array('conditions'=>array('id'=>$idTopic)));

        $topic = $topic[0];

        $forum = $this->Forum->find('all', array('conditions'=>array('id'=>$topic['Topic']['forum_id'])));
        $forum = $forum[0];

        $firstPost = $this->Post->find("all", array('conditions'=>array('id'=>$topic['Topic']['first_post_id'])));

        $firstPost = $firstPost[0];
        $firstPost['Post']['message'] = $this->Post->parseMessage($firstPost['Post']['message']);
        
        if ($this->request->is('post')) {
            //topic last post et poster etc etc date last post
            //mais avant save post voir champs
            $data = array('Post'=>array(
                'message'=>$this->request->data['Post']['message'],
                'topic_id'=>$idTopic,
                'poster'=>$user['username'],
                'poster_id'=>$user['id'],
                'poster_ip'=>$this->request->clientIp(),
                'poster_email'=>$user['email'],
                'posted'=>time()
            ));
            $this->Post->create();
            if ($this->Post->save($data)) {
                //now on save si il faut les infos du topic
                $lastPostId = $this->Post->id;
                unset($data);
                $data = array('Topic'=>array(
                    'last_post'=>time(),
                    'last_poster'=>$user['username'],
                    'last_post_id'=>$lastPostId,
                    'num_replies'=>$topic['Topic']['num_replies']+1
                ));
                $this->Topic->id = $idTopic;
                if ($this->Topic->save($data)) {
                    //et le fofo
                    $this->Forum->id = $forum['Forum']['id'];
                    unset($data);
                    $data = array('Forum'=>array(
                        'num_posts'=>$forum['Forum']['num_posts']+1,
                        'last_post'=>time(),
                        'last_post_id'=>$lastPostId,
                        'last_poster'=>$user['username']
                    ));
                    if ($this->Forum->save($data)) {
                        $this->Session->setFlash('Post Added');
                        return $this->redirect(array('controller'=>'topics', 'action'=>'view', $idTopic, -1));
                    }
                }
            }
        }

        $this->set('topic', $topic);
        $this->set('user', $user);
        $this->set('firstPost', $firstPost);
        
    }

    public function edit($id = null) {
       
    }

    public function isAuthorized($user) {
        if ($this->action === "add") {
            $this->loadModel('User');
            $topicId = (int) $this->request->params['pass'][0];
            $auth = $this->Post->isAuthReply($topicId, $this->User->readForumUser($this->Auth->user()));
            if ($auth == true) {
                return true;
            } else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }

}

?>