<?php

namespace App\Helpers;

class Utils
{
    public static function getFormatedPhone($phone)
    {
        $formatedPhone = str_replace('+7', '', $phone);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        return $formatedPhone;
    }
}
