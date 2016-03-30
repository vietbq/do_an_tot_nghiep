<?php


class CreateMonthShell extends AppShell{
    public $uses = array('Month','Week');
    public function main(){
        $year = GetTime::getYear(time());
        $mouth = GetTime::getMonth(time());
        $M = $this->Month->create();
        $M['Month']['year'] = $year;
        $M['Month']['month'] = $mouth;
        $this->Month->save($M);
    }
}
