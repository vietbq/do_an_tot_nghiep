<?php

App::uses("AppModel", "Model");

class Month extends AppModel {
    public $useTable = 'month';
    public $primaryKey = 'id';
    public $hasMany = array(
        'Week' => array(
            'className' => 'Week',
            'foreignKey' => 'month_id',
            'dependent' => true
        ),
    );
}
