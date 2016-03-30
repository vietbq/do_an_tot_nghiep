<?php
App::uses("AppCpntroller", "Controller");

class DevicesController extends AppController{
    public $uses = array('Device');
    public $helpers = array('Paginator', 'Html', 'Form');
    public $components = array('Paginator');
    
    public function index(){
        $this->set('title_for_layout', Configure::read('title')['device']['index']);
        $devices = $this->Device->find("all",array("conditions"=>array('status'=>1)));
        $this->set('devices', $devices);
    }
    public function request(){
        $this->set('title_for_layout', Configure::read('title')['device']['request']);
        $devices = $this->Device->find("all",array("conditions"=>array('status'=>0)));
        $this->set('devices', $devices);
    }
} 