<?php
App::uses("AppModel", "Model");

class Electronic extends AppModel{
    public $useTable = 'electronics';
    public $primaryKey = 'id';
    public $hasMany = array(
        'ActivityOn' => array(
            'className' => 'ActivityOn',
            'foreignKey' => 'electronic_id',
            'dependent' => true
        ),
        'ActivityOff' => array(
            'className' => 'ActivityOff',
            'foreignKey' => 'electronic_id',
            'dependent' => true
        )
    );
}