<?php

namespace App\Utils;

use DateTime;
use Exception;

class DateUtil {

    public static function isDateValid_YMD(string $yyyy_mm_dd)
    {
        try {
            $split = explode('-', $yyyy_mm_dd);
            return checkdate($split[1], $split[2], $split[0]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function validateDate($date, $format = 'd-m-Y H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

}