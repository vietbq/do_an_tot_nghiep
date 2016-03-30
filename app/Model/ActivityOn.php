<?php

App::uses("AppModel", "Model");

class ActivityOn extends AppModel {

    public $useTable = "activities_on";
    public $name = "ActivityOn";
    public $primaryKey = 'id';
    public $belongsTo = array(
        'Electronic' => array(
            'className' => 'Electronic',
            'foreignKey' => 'electronic_id'
        ),
        'Week' => array(
            'className' => 'Week',
            'foreignKey' => 'week_id'
        )
    );
    
    public $validate = array(
    );

}
