<?php

class Tag extends AppModel {

    public function isInDatabase($content) {

        if ($this->field('id', array(
                'content' => $content
                )
            )) {
            return true;
        }
        return false;
    }

}
