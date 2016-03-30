<?php
App::uses("AppModel", "Model");

class WeekEnergy extends AppModel{
    public $userTable = 'week_energy';
    
    public $belongsTo = array(
        'Week' => array(
            'className' => 'Week',
            'foreignKey' => 'week_id'
        )
    );
}