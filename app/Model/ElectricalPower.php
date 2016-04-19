<?php

App::uses("AppModel", "Model");

class ElectricalPower extends AppModel {

    public $useTable = "electrical_power";
    public $name = "ElectricalPower";
    public $primaryKey = 'id';
    public $belongsTo = array(
        'Electronic' => array(
            'className' => 'Electronic',
            'foreignKey' => 'electronic_id'
        )
    );

    public function getElectricalPower($begin, $end) {
        $sum = $this->find('all', array(
            'conditions' => array(
                'ElectricalPower.updated_at >=' => $begin,
                'ElectricalPower.updated_at <=' => $end
            ),
            'fields' => array('sum(ElectricalPower.power) as power')
                )
        );
        return (int) $sum[0][0]['power'];
    }

    public function getElectricalPowerByID($id, $begin, $end) {
        $power = $this->find('all', array(
            'conditions' => array(
                'ElectricalPower.electronic_id' => $id,
                'ElectricalPower.updated_at >=' => $begin,
                'ElectricalPower.updated_at <=' => $end
            ),
        ));
        return $power;
    }

    public function getPowerOfMonth() {
        $year = GetTime::getYear(time());
        $month = GetTime::getMonth(time());
        $data = array(
            'labels' => array(),
            'data' => array()
        );
        for ($i = 1; $i <= $month; $i++) {
            $firstDay = GetTime::getFirstDayOfMonth(strtotime($year . '-' . $i));
            $lastDay = GetTime::getEndDayOfMonth(strtotime($year . '-' . $i));
            $sum = $this->getElectricalPower($firstDay, $lastDay);
            array_push($data['labels'], "Tháng " . $i);
            array_push($data['data'], $sum);
        }
        return $data;
    }

    public function getPowerOfElectrocal($e_array, $begin, $end) {

        $data = array(
            'labels' => array(),
            "datasets" => array(
                'data' => array(),
                'color' => array(),
                'hover' => array()
            )
        );
        foreach ($e_array as $e) {
            $sum = $this->find('all', array(
                'conditions' => array(
                    'ElectricalPower.electronic_id' => $e['Electronic']['id'],
                    'ElectricalPower.updated_at >=' => $begin,
                    'ElectricalPower.updated_at <=' => $end
                ),
                'fields' => array('sum(ElectricalPower.power) as power')
                    )
            );
            $d = (int) $sum[0][0]['power'];
            $hover = sprintf("#%06x", rand(0, 16777215));
            $color = sprintf("#%06x", rand(0, 16777215));
            array_push($data['labels'], $e['Electronic']['name']);
            array_push($data['datasets']['data'], $d);
            array_push($data['datasets']['color'], $color);
            array_push($data['datasets']['hover'], $hover);
        }
        return $data;
    }

}
