<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {

    public $uses = array('Electronic', 'ElectricalPower');

    public function index() {
        $this->set('title_for_layout', 'Tổng quan hệ thống');
        $this->set('unit', Configure::read('unit'));
        $sumDay = $this->ElectricalPower->getElectricalPower(
                GetTime::getFirtTimeDay(), GetTime::getEndTimeDay()
        );
        $sumWeek = $this->ElectricalPower->getElectricalPower(
                GetTime::getFirstDayOfWeek(time()), GetTime::getEndDayOfWeek(time())
        );
        $sumMonth = $this->ElectricalPower->getElectricalPower(
                GetTime::getFirstDayOfMonth(time()), GetTime::getEndDayOfMonth(time())
        );
        $this->set("sum", array($sumDay, $sumWeek, $sumMonth));
        $e_num = $this->Electronic->find('count', array('conditions' => array('type' => 1)));
        $t_num = $this->Electronic->find('count', array('conditions' => array('type' => 2)));
        $this->set('num', array($e_num, $t_num));
        $t_array = $this->Electronic->find('all', array(
            'conditions' => array('type' => 2)
        ));
        $this->set('t_array',$t_array);
        $e_array = $this->Electronic->find('all', array(
            'conditions' => array('type' => 1)
        ));
        $array['canvas_day'] = $this->ElectricalPower->getPowerOfElectrocal(
                $e_array, GetTime::getFirtTimeDay(), GetTime::getEndTimeDay()
        );
        $array['canvas_week'] = $this->ElectricalPower->getPowerOfElectrocal(
                $e_array, GetTime::getFirstDayOfWeek(), GetTime::getEndDayOfWeek()
        );
        $array['canvas_month'] = $this->ElectricalPower->getPowerOfElectrocal(
                $e_array, GetTime::getFirstDayOfMonth(time()), GetTime::getEndDayOfMonth(time())
        );
        $month_power = $this->ElectricalPower->getPowerOfMonth();
        $array['bar_month'] = array(
            "labels" => $month_power['labels'],
            "datasets" => [
                "color" => "#26B99A",
                "hover" => "#26B21A",
                "data" => $month_power['data']
            ]
        );
        $this->set("data", $array);
    }

    public function test() {
        
    }

}
