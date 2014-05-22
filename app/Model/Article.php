<?php

class Article extends AppModel {

//validate
//associations    
    public $actsAs = array(
        'Media.Media' => array(
            'extensions' => array('jpg', 'png', 'jpeg'),
            'path' => 'uploads/%y-%m/%f'
        ),
        'Containable'
    );

    /* Associations DB */
    public $belongsTo = array(
        'User' => array(
            'classname' => 'User',
            'foreignKey' => 'author_id',
            'fields' => array('User.username', 'User.id')
        ),
        'Game' => array(
            'classname' => 'Game',
            'foreignKey' => 'game_id'        )
    );
    
    public $hasAndBelongsToMany = array(
        'Tag' => array(
            'classname' => 'Tag',
            'joinTable' => 'articles_tags',
            'foreignKey' => 'article_id',
            'associationForeignKey' => 'tag_id',
            'fields' => array('Tag.content')
        )
    );
    
    public $validate = array(
        'title' => array(
            'rule' => array('between', 10, 50),
            'required' => true,
            'message' => 'Title length should be between 10 and 50'
        ),
        'subtitle' => array(
            'rule' => array('between', 5, 255),
            'message' => 'Subtitle length should be between 5 and 255'
        ),
        'intro' => array(
            'rule' => 'notEmpty'
        ),
    );

    public function isOwnedBy($articleId, $userId) {
        if ($this->field('id', array('id' => $articleId, 'author_id' => $userId)) == false) {
            return false;
        }
        return true;
    }

}

?>