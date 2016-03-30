<?php

class GetTime {

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
