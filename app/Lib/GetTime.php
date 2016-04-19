<?php

class GetTime {

    public static function getWeeks($timestamp) {
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

    public static function getMonth($timestamp) {
        return intval(date('m', $timestamp));
    }

    public static function getYear($timestamp) {
        return intval(date('Y', $timestamp));
    }

    public static function getFirstDayOfMonth($timestamp) {
        // First day of the month.
        return strtotime(date('Y-m-01 ', $timestamp));
    }

    public static function getEndDayOfMonth($timestamp) {
        // End day of the month.
        return strtotime(date('Y-m-t 23:59:59', $timestamp));
    }

    public static function getFirstDayOfWeek() {
        // First day of the week.
        $date = new DateTime();
        $date->modify('this week');
        return strtotime($date->format('Y-m-d 00:00:00'));
    }

    public static function getEndDayOfWeek() {
        // End day of the week.
        $date = new DateTime();
        $date->modify('this week +6 days'); // to get the current week's last date
        return strtotime($date->format('Y-m-d 23:59:59'));
    }
    public static function getFirtTimeDay() {
        return strtotime(date('Y-m-d 00:00:00', time()));
    }
    public static function getEndTimeDay() {
        return strtotime(date('Y-m-d 23:59:59', time()));
    }
}
