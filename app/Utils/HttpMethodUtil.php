<?php

namespace App\Utils;

class HttpMethodUtil {

    /*
    --------------------------------
    Check Methods
    --------------------------------
    */

    public static function isMethodGet() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    public static function isMethodPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public static function isMethodDelete() {
        return $_SERVER['REQUEST_METHOD'] == 'DELETE';
    }

    public static function isMethodPut() {
        return $_SERVER['REQUEST_METHOD'] == 'PUT';
    }

}