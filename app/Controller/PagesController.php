<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {

    public $uses = array('Electronic');

    public function index() {
        $this->set('title_for_layout', 'Tổng quan hệ thống');
        $this->set('unit', Configure::read('unit'));
        $array_day = [
            "labels" => ["LED1", "LED2", "Gray Color", "Green Color", "LED 05"],
            "datasets" => [
                "data" => [120, 12, 140, 456, 100],
                "color" => ["#455C73", "#9B59B6", "#BDC3C7", "#26B99A", "#3498DB"],
                "hover" => ["#34495E", "#B370CF", "#CFD4D8", "#36CAAB", "#49A9EA"]
            ]
        ];
        $array_week = [
            "labels" => ["Dark Grey", "Purple Color", "Gray Color", "Green Color", "Blue Color"],
            "datasets" => [
                "data" => [123, 50, 12, 180, 422],
                "color" => ["#455C73", "#9B59B6", "#BDC3C7", "#26B99A", "#3498DB"],
                "hover" => ["#34495E", "#B370CF", "#CFD4D8", "#36CAAB", "#49A9EA"]
            ]
        ];
        $array_month = [
            "labels" => ["Dark Grey", "Purple Color", "Gray Color", "Green Color", "Blue Color"],
            "datasets" => [
                "data" => [120, 50, 140, 180, 100],
                "color" => ["#455C73", "#9B59B6", "#BDC3C7", "#26B99A", "#3498DB"],
                "hover" => ["#34495E", "#B370CF", "#CFD4D8", "#36CAAB", "#49A9EA"]
            ]
        ];
        $array_bar = array(
            "labels" => ["January", "February", "March", "April", "May", "June", "July","August","September","October"],
            "datasets" => [
                "label" => '# of Votes',
                "color" => "#26B99A",
                "hover" => "#26B21A",
                "data" => [51, 30, 40, 28, 92, 50, 60,90,100,120]
            ]
        );
        $array["canvas_day"] = $array_day;
        $array["canvas_week"] = $array_week;
        $array["canvas_month"] = $array_month;
        $array["bar_month"] = $array_bar;
        $this->set("data", $array);
    }

    public function test() {
        
    }

    /**
     * Returns the amount of weeks into the month a date is
     * @param $date a YYYY-MM-DD formatted date
     * @param $rollover The day on which the week rolls over
     */
    private function getWeeks($timestamp) {
        $date = date("Y-m-d", $timestamp);
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i <= $elapsed; $i++) {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if ($day == strtolower("monday"))
                $weeks ++;
        }

        return $weeks;
    }

    private function getMonth($timestamp) {
        return intval(date('m', $timestamp));
    }

    private function getYear($timestamp) {
        return intval(date('Y', $timestamp));
    }

}
