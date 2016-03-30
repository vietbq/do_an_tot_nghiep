<?php

App::uses("AppModel", "Model");

class Week extends AppModel {

    public $useTable = 'week';
    public $primaryKey = 'id';
    public $hasMany = array(
        'ActivityOn' => array(
            'className' => 'ActivityOn',
            'foreignKey' => 'week_id',
            'dependent' => true
        ),
        'ActivityOff' => array(
            'className' => 'ActivityOff',
            'foreignKey' => 'week_id',
            'dependent' => true
        ),
        'WeekEnergy' => array(
            'className' => 'WeekEnergy',
            'foreignKey' => 'week_id',
            'dependent' => true
        )
    );

}
