<?php

namespace App\Utils;

class Generator
{

    public static function getRandomStringWithSpecialChar(int $length)
    {
        $digits = '0123456789';
        $alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $specialChar = '@$&_-';
        $characters = $digits . $alpha . $specialChar;
        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }

    public static function getRandomString(int $length, bool $digits = true, bool $lowercase = true, bool $uppercase = true)
    {

        $num = '0123456789';
        $alphaU = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $alphaL = 'abcdefghijklmnopqrstuvwxyz';

        $new = "";
        $new .= $digits ? $num : "";
        $new .= $lowercase ? $alphaL : "";
        $new .= $uppercase ? $alphaU : "";

        $new = $new == "" ? $num . $alphaL . $alphaU : $new;

        $charactersLength = strlen($new);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $new[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function getUniqueRandomString(int $length, bool $digits = true, bool $lowercase = false, bool $uppercase = true)
    {

        $num = range(0, 9);
        $alphaL = range('a', 'z');
        $alphaU = range('A', 'Z');

        shuffle($num);
        shuffle($alphaL);
        shuffle($alphaU);

        $new = [];

        if (!$digits && $lowercase && $uppercase) {
            $new = array_merge($alphaL, $alphaU);
        } elseif ($digits && !$lowercase && $uppercase) {
            $new = array_merge($num, $alphaU);
        } elseif ($digits && $lowercase && !$uppercase) {
            $new = array_merge($num, $alphaL);
        } elseif (!$digits && !$lowercase && $uppercase) {
            $new = $alphaU;
        } elseif ($digits && !$lowercase && !$uppercase) {
            $new = $num;
        } elseif (!$digits && $lowercase && !$uppercase) {
            $new = $alphaL;
        }

        shuffle($new);

        $final = "";
        for ($i = 0; $i < $length; $i++) {
            $final .= $new[$i];
        }

        return $final;
    }

    public static function getWarehouseCode()
    {
        return Generator::getRandomString(1, false, false) . Generator::getUniqueRandomString(5);
    }
}
