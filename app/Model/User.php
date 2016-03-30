<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

    public $useTable = 'user';
    public $primaryKey = 'id';
    // Validation rules
    public $validate = array(
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email'
            ),
            'unique' => array(
                'rule' => 'uniqueEmail',
                'message' => 'This email has already been taken.'
            )
        ),
        'password_confirmation' => array(
            'match' => array(
                'rule' => 'validatePasswdConfirm',
                'message' => 'Passwords do not match'
            )
        ),
    );

    public function validatePasswdConfirm($data) {
        if ($this->data['User']['password'] !== $data['password_confirmation']) {
            return false;
        }
        return true;
    }

    public function encryptPassword($password) {
        $passwordHasher = new SimplePasswordHasher(array('hashType' => 'md5'));
        return $passwordHasher->hash($password);
    }

    public function uniqueEmail($check) {
        $existingEmail = $this->find('count', array(
            'conditions' => array(
                'id !=' => isset($this->id) ? $this->id : 0,
                'email' => $this->data[$this->alias]['email'],
            ),
            'recursive' => -1
        ));
        return ($existingEmail == 0);
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'md5'));
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        if (isset($this->data['User']['password_confirmation'])) { 
            unset($this->data['User']['password_confirmation']); 
        }
        return true;
    }

}
