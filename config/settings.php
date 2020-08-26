<?php

return [
    'api_1c_url' => env('API_1C_URL', ''),
    'failed_sms_for_ban' => env('FAILED_SMS_FOR_BAN', 3),
    'ban_time_minutes' => env('BAN_TIME_MINUTES', 60),
    'failed_counts_for_ban' => env('FAILED_COUNTS_FOR_BAN', 3),
    'sms_resend_delay_seconds' => env('SMS_RESEND_DELAY_SECONDS', 60),
    'feedback_mail' => env('FEEDBACK_MAIL', 'admin@admin.ru'),
    'sms_expires_seconds' => env('SMS_EXPIRES_SECONDS', 60),
];
