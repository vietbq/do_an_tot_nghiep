<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $uses = array('User');
    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'auth',
                'action' => 'login'
            ),
            'authError' => 'You must be logged in to view this page!!!',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'fields' => array('username' => 'email'),
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'md5'
                    ),
                )
            )
        )
    );

}
