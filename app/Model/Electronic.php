<?php
App::uses("AppModel", "Model");

class Electronic extends AppModel{
    public $useTable = 'electronics';
    public $primaryKey = 'id';
    public $hasMany = array(
        'Activity' => array(
            'className' => 'Activity',
            'foreignKey' => 'electronic_id',
            'dependent' => true
        ),
        'ActivityOff' => array(
            'className' => 'ActivityOff',
            'foreignKey' => 'electronic_id',
            'dependent' => true
        )
    );
    public $validate = array(
        'name' => array(
            'rule' => 'isUnique',
            'required' => 'create',
            'message' => 'Tên thiết bị này đã có trong hệ thống, hãy nhập tên khác'
            )
        );
}
