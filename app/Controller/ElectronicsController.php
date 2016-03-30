<?php

App::uses('AppController', 'Controller');

class ElectronicsController extends AppController {

    public $helpers = array('Paginator', 'Html', 'Form', 'Js' => array('Jquery'));
    public $uses = array('Electronic');

    public function index() {
        $this->set('title_for_layout', Configure::read('title')['electronic']['index']);
        $this->set("electronics", $this->Electronic->find('all'));
    }

    public function change_status($status = null) {
        $this->layout = 'ajax';
        die;
    }

}
