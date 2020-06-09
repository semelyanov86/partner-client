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

    public static function updateContractLoan($agreement)
    {
        //TODO get real data
        return true;
    }

    public static function generateQrCodeText($purpose, $fio)
    {
        $text = "";
        //$fio = "иванов иван";
        $fioSplited = explode(" ", trim($fio));
        $lastName = $fioSplited[0];
        $firstName = $fioSplited[1];
        $middleName = $fioSplited[2];

        $text = $text.'ST00012|Name=КПКГ ""Партнер""|PersonalAcc=40703810268210000210'
            ."|BankName=УДМУРТСКОЕ ОТДЕЛЕНИЕ N8618 ПАО СБЕРБАНК|BIC=049401601"
            ."|CorrespAcc=30101810400000000601|KPP=183801001|PayeeINN=1827018260"
            ."|lastName=".$lastName."|FirstName=".$firstName."|MiddleName=".$middleName
            ."|Purpose=".$purpose."|Sum=#PayAmt#";

        return $text;
    }
}
