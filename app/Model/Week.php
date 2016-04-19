<?php

App::uses("AppModel", "Model");

class Week extends AppModel {
    public $useTable = 'week';
    public $primaryKey = 'id';
    public $belongTo = array(
        'Month'=>array(
            'className' => 'Month',
            'foreignKey' => 'month_id',
        )
    );
}
