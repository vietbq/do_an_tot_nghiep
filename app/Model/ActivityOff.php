<?php
App::uses("AppModel", "Model");

class ActivityOff extends AppModel{
    public $useTable = "activities_off";
    public $name = "ActivityOff";
    public $belongsTo = array(
        'Electronic' => array(
            'className' => 'Electronic',
            'foreignKey' => 'electronic_id'
        )
        ,'Week' => array(
            'className' => 'Week',
            'foreignKey' => 'week_id'
        )
    );
}