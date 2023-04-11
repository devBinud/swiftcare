<?php

namespace App\Utils;

use Illuminate\Support\Facades\Config;

class Sms2Factor
{

    public static function sendOTP(string $phone, string $templateName = 'Simple OTP')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://2factor.in/API/V1/" . Config::get('constants.2factor.api_key', '') . "/SMS/$phone/AUTOGEN/$templateName",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    public static function verifyOTP(string $sessionID, string $otp)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://2factor.in/API/V1/" . Config::get('constants.2factor.api_key', '') . "/SMS/VERIFY/$sessionID/$otp",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    public static function sendRegistrationSuccessMsg(string $gatePassNumber, string $phone) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://2factor.in/API/V1/". Config::get('constants.2factor.api_key', '') ."/ADDON_SERVICES/SEND/TSMS",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => [
                'From' => Config::get('constants.2factor.templates.registration_successful.sender_id', ''),
                'To' => $phone,
                'TemplateName' => Config::get('constants.2factor.templates.registration_successful.template_name', ''),
                'VAR1' => $gatePassNumber
            ],
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }
}
