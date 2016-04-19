<?php

App::uses("AppModel", "Model");

class Activity extends AppModel {

    public $useTable = "activities";
    public $name = "Activity";
    public $primaryKey = 'id';
    public $belongsTo = array(
        'Electronic' => array(
            'className' => 'Electronic',
            'foreignKey' => 'electronic_id'
        )
    );
    
    public $validate = array(
    );

}
