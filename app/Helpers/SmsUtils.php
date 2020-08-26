<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class SmsUtils
{
    public static function sendSMSCode($phone, $code, $ip)
    {
        $text_sms = 'Ваш код для входа: '.$code;

        $my_url = 'https://sms.rt.ru/api/send_message/?operation=send&login=4e9c9077';
        $my_url = $my_url.'&password=311191af&msisdn=7'.$phone.'&shortcode=KPKGPartner&text='.urlencode($text_sms);
        try {
            $response = Http::timeout(30)->get($my_url);
            if ($response->status() == 200) {
                if (strpos(strtolower($response->body()), 'message-id')) {
                    FailedLoginUtils::addNewFailEvent($ip, $phone, 1);

                    return true;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch (\Exception $exception) {
            return null;
        }

        //FailedLoginUtils::addNewFailEvent($ip, $phone, 1);
    }
}
