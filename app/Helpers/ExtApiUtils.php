<?php


namespace App\Helpers;


class ExtApiUtils
{
    public static function getShareholderByPhone($phone)
    {
        //TODO get real data
        if ($phone == '9999999999' || $phone == '9000000000' || $phone == '9373769118')
        {
            return "json with details";
        }
        else
            return false;
    }
}
