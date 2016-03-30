<?php
App::uses('AppModel', "Model");

class MonthEnergy extends AppModel{
    public $useTable = 'month_energy';
    public $belongsTo = array(
        'Month' => array(
            'className' => 'Month',
            'foreignKey' => 'month_id'
        )
    );
}
