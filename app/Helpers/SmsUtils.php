<?php


namespace App\Helpers;

class SmsUtils
{
    public static function sendSMSCode($phone, $code, $ip)
    {
        //TODO Send SMS script
        FailedLoginUtils::addNewFailEvent($ip, $phone, 1);
    }
}
