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
        return config('settings.failed_sms_for_ban')
            -
            FailedLogin::where('phone', $phone)
                ->where('sms', 1)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subMinutes(config('settings.ban_time_minutes')))
                ->where('created_at', '<=', now())
                ->count();
    }

    public static function getRemainFailCount($ip)
    {
        return config('settings.failed_counts_for_ban')
            -
            FailedLogin::where('ip_address', $ip)
                ->where('sms', 0)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subMinutes(config('settings.ban_time_minutes')))
                ->where('created_at', '<=', now())
                ->count();
    }

    public static function canResendSMS($phone)
    {
        return FailedLogin::where('phone', $phone)
                ->where('sms', 1)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subSeconds(config('settings.sms_resend_delay_seconds')))
                ->where('created_at', '<=', now())
                ->count() == 0;
    }
}
