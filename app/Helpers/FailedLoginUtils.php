<?php

namespace App\Helpers;

use App\FailedLogin;

class FailedLoginUtils
{
    public static function addNewFailEvent($ip, $phone, $sms = 0)
    {
        FailedLogin::create([
            'phone' => $phone,
            'sms' => $sms,
            'ip_address' => $ip,
        ]);
    }

    public static function getRemainSMSCount($phone)
    {
        return env('FAILED_SMS_FOR_BAN', 3)
            -
            FailedLogin::where('phone', $phone)
                ->where('sms', 1)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subMinutes(env('BAN_TIME_MINUTES', 60)))
                ->where('created_at', '<=', now())
                ->count();
    }

    public static function getRemainFailCount($ip)
    {
        return env('FAILED_COUNTS_FOR_BAN', 3)
            -
            FailedLogin::where('ip_address', $ip)
                ->where('sms', 0)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subMinutes(env('BAN_TIME_MINUTES', 60)))
                ->where('created_at', '<=', now())
                ->count();
    }

    public static function canResendSMS($phone)
    {
        return FailedLogin::where('phone', $phone)
                ->where('sms', 1)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subSeconds(env('SMS_RESEND_DELAY_SECONDS', 30)))
                ->where('created_at', '<=', now())
                ->count() == 0;
    }
}
