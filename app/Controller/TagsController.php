<?php

class TagsController extends AppController {

    public $paginate = array(
        'fields' => 'Tag.content, Tag.id, Tag.modified',
        'order' => array(
            'Tag.id' => 'asc'
        ),
        'limit' => 100
    );

    public function beforeFilter() {
        $this->Auth->deny('all');
    }

    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Tag->create();
            if (!$this->Tag->isInDataBase($this->request->data['Tag']['content'])) {
                if ($this->Tag->save($this->request->data)) {
                    $this->Session->setFlash(__('Your #tag has been added to DB'));
                    return $this->redirect(array('action' => 'index'));
                }
            }
            $this->Session->setFlash(__('Your #tag is already in database'));
        }
    }

    public function index() {
        $this->recursive = -1;
        $this->set('tags', $this->paginate());
    }
    
    public function delete($id) {
        if ($this->request->is('post')) {
            if ($this->Tag->delete($id)) {
                $this->Session->setFlash(__('Your tag has been deleted'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash((__('Unable to delete your post')));
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid tag'));
        }
        
        if ($this->request->is(array('post','put'))) {
            $this->Tag->id = $id;
            if ($this->Tag->save($this->request->data)) {
                $this->Session->setFlash(__('Your tag has been updated'));
                return $this->redirect(array('action' => 'index'));
            }
        }
        if (!$this->request->data) {
            $this->request->data = $this->Tag->findById($id);
        }

    }

}

?>