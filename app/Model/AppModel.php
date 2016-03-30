<?php

App::uses('Model', 'Model');

class AppModel extends Model {

    public function beforeSave($options = array()) {
        if ((!$this->id) && ( empty($this->data[$this->alias][$this->primaryKey]))) {
            $this->data[$this->alias]['created_at'] = time();
            $this->data[$this->alias]['updated_at'] = time();
        } else {
            $this->data[$this->alias]['updated_at'] = time();
        }
        return true;
    }

}
