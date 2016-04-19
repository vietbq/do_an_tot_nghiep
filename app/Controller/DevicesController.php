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

    public function accept($id = null){
        $this->autoRender = false;
        if($device = $this->Device->findById(intval($id))){
            $device['Device']['status'] = 1;
            if($this->Device->save($device)){
                echo json_encode(array('ret'=> 'OK'));
                die(); 
            }
        }
        return false;
    }
    public function accept_all(){
        $this->autoRender = false;
        if($devices = $this->Device->find('all', array('conditions' => array('status' => 0)))){
            foreach ($devices as $device) {
              $device['Device']['status'] = 1;
                $this->Device->save($device);  
            }
            echo json_encode(array('ret'=> 'OK'));
            die(); 
        }    
        return false;
    }
} 
