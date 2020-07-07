<?php


namespace App\Helpers;


use App\DepositContract;
use App\DepositSchedule;
use App\LoanContract;
use App\LoanMainSchedule;
use App\LoanMemfeeSchedule;
use App\LoanRequest;
use App\Shareholder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExtApiUtils
{
    CONST dateFormat = "d.m.Y";

    public static function getShareholderByPhone($phone)
    {
        $apiURL = env("API_1C_URL", "")."getbyphone/".$phone;

        try {
            $response = Http::timeout(30)->get($apiURL);
            if ($response->status() == 200)
            {
                $jsonData = $response->json();

                $data = array("fio" => $jsonData['fio'],
                    "doc" => $jsonData['doc'],
                    "allow_request" => $jsonData['AllowRequest'] == "true" ? 1 : 0 );

                return $data;
            }
            else
                return null;
        }
        catch (\Exception $exception) {
            return null;
        }

    }

    public static function getShareholderHeadersInfoByDoc($doc)
    {
        $docSplited = explode(" ", trim($doc));
        $ser = $docSplited[0];
        $num = $docSplited[1];

        $apiURL = env("API_1C_URL", "")."getheaders?ser=".$ser."&num=".$num;

        try {
            $response = Http::timeout(30)->get($apiURL);
            if ($response->status() == 200)
            {
                $jsonData = $response->json();
                $loans = array();
                foreach ($jsonData["loans"] as $loan)
                {
                    array_push($loans,
                        array(
                            "agreement" => $loan["agreement"],
                            "date_start" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $loan["date_start"])
                                ->setTime(0, 0,0,0)->format('Y-m-d'),
                            "date_end" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $loan["date_end"])
                                ->setTime(0, 0,0,0)->format('Y-m-d'),
                            "amount" => $loan["amount"],
                            "percent" => $loan["percent"],
                            "is_open"=> $loan['IsOpen'] == "true" ? 1 : 0,
                            "is_judgment"=> $loan['isJudgment'] == "true" ? 1 : 0,
                        )
                    );
                }

                $deposits = array();
                foreach ($jsonData["deposits"] as $deposit)
                {
                    array_push($deposits,
                        array(
                            "agreement" => $deposit["agreement"],
                            "date_start" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $deposit["date_start"])
                                ->setTime(0, 0,0,0)->format('Y-m-d'),
                            "date_end" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $deposit["date_end"])
                                ->setTime(0, 0,0,0)->format('Y-m-d'),
                            "percent" => $deposit["percent"],
                            "amount" => $deposit["amount"],
                            "is_open"=> $deposit['IsOpen'] == "true" ? 1 : 0,
                        )
                    );
                }

                $requests = array();
                foreach ($jsonData["requests"] as $request)
                {
                    array_push($requests,
                        array(
                            "request_no" => $request["requestno"],
                            "request_date" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $request["request_date"])
                                ->setTime(0, 0,0,0)->format('Y-m-d'),
                            "amount" => $request["amount"],
                            "status"=> $request['status'],
                        )
                    );
                }

                $data = array("loans" => $loans, "deposits" => $deposits, "requests" => $requests);

                return $data;
            }
            else
                return null;
        }
        catch (\Exception $exception) {
            return null;
        }
    }

    public static function getContractLoanInfoByAgreement($agreement)
    {
        $apiURL = env("API_1C_URL", "")."graphic/".$agreement;

        try {
            $response = Http::timeout(30)->get($apiURL);
            if ($response->status() == 200)
            {
                $jsonData = $response->json();

                $mainSchedule = array();
                foreach ($jsonData["schedule"] as $line)
                {
                    array_push($mainSchedule,
                        array(
                            "date_plan" => $line["date_plan"] ? Carbon::createFromFormat(ExtApiUtils::dateFormat, $line["date_plan"])
                                ->setTime(0, 0,0,0)->format('Y-m-d') : null,
                            "date_fact" =>  $line["date_fact"] ? Carbon::createFromFormat(ExtApiUtils::dateFormat, $line["date_fact"])
                                ->setTime(0, 0,0,0)->format('Y-m-d') : null,
                            "main_amt_debt_plan" => $line["main_amt_debt_plan"],
                            "period"=> $line['period'],
                            "days"=> $line['days'],
                            "percent_amt_plan"=> $line['percent_amt_plan'],
                            "main_amt_plan"=> $line['main_amt_plan'],
                            "percent_amt_fact"=> $line['percent_amt_fact'],
                            "main_amt_fact"=> $line['main_amt_fact'],
                            "fee_amt_fact"=> $line['fee_amt_fact'],
                            "main_amt_debt_fact"=> $line['main_amt_debt_fact'],
                            "fee_period"=> $line['fee_period'],
                            "fee_days"=> $line['fee_days'],
                            "fee_plan"=> $line['fee_amt_plan'],
                            "no"=> $line['no'],
                        )
                    );
                }

                $memFeeSchedule = array();
                foreach ($jsonData["mem_fee_schedule"] as $line)
                {
                    array_push($memFeeSchedule,
                        array(
                            "date_plan" => $line["date_plan"] ? Carbon::createFromFormat(ExtApiUtils::dateFormat, $line["date_plan"])
                                ->setTime(0, 0,0,0)->format('Y-m-d') : null,
                            "date_fact" =>  $line["date_fact"] ? Carbon::createFromFormat(ExtApiUtils::dateFormat, $line["date_fact"])
                                ->setTime(0, 0,0,0)->format('Y-m-d') : null,
                            "mem_fee_plan" => $line["main_amt_debt_plan"],
                            "mem_fee_fac"=> $line['period'],
                            "no"=> $line['no'],
                        )
                    );
                }


                $loanContract = array(
                    "date_start" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $jsonData["date_start"])
                        ->setTime(0, 0,0,0)->format('Y-m-d'),
                    "date_end" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $jsonData["date_end"])
                        ->setTime(0, 0,0,0)->format('Y-m-d'),
                    "percent" => $jsonData["percent"],
                    "is_open"=> $jsonData['IsOpen'] == "true" ? 1 : 0,
                    "amount" => $jsonData["amount"],
                    "actual_debt" => $jsonData["actual_debt"],
                    "full_debt" => $jsonData["full_debt"],
                    "mem_fee" => $jsonData["mem_fee"],
                    "date_calculate" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $jsonData["date_calculate"])
                        ->setTime(0, 0,0,0)->format('Y-m-d'),
                );

                $data = array(
                    "loanContract" => $loanContract,
                    "mainSchedule" => $mainSchedule,
                    "memFeeSchedule" => $memFeeSchedule,
                );

                return $data;
            }
            else
                return null;
        }
        catch (\Exception $exception)
        {
            return null;
        }

    }

    public static function getContractDepositInfoByAgreement($agreement)
    {
        $apiURL = env("API_1C_URL", "")."graphic/".$agreement;

        try {
            $response = Http::timeout(30)->get($apiURL);
            if ($response->status() == 200)
            {
                $jsonData = $response->json();

                $schedule = array();
                foreach ($jsonData["schedule"] as $line)
                {
                    array_push($schedule,
                        array(
                            "date_plan" => $line["date_plan"] ? Carbon::createFromFormat(ExtApiUtils::dateFormat, $line["date_plan"])
                                ->setTime(0, 0,0,0)->format('Y-m-d') : null,
                            "date_fact" =>  $line["date_fact"] ? Carbon::createFromFormat(ExtApiUtils::dateFormat, $line["date_fact"])
                                ->setTime(0, 0,0,0)->format('Y-m-d') : null,
                            "main_amt_debt" => $line["main_amt_debt"],
                            "period"=> $line['period'],
                            "days"=> $line['days'],
                            "percent_amt_plan"=> $line['percent_amt_plan'],
                            "ndfl_amt"=> $line['ndfl_amt'],
                            "percent_available"=> $line['percent_available'],
                            "percent_amt_fact"=> $line['percent_amt_fact'],
                            "main_amt_fact"=> $line['main_amt_fact'],
                            "no"=> $line['no'],
                        )
                    );
                }

                $depositContract = array(
                    "date_start" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $jsonData["date_start"])
                        ->setTime(0, 0,0,0)->format('Y-m-d'),
                    "date_end" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $jsonData["date_end"])
                        ->setTime(0, 0,0,0)->format('Y-m-d'),
                    "percent" => $jsonData["percent"],
                    "is_open"=> $jsonData['IsOpen'] == "true" ? 1 : 0,
                    "amount" => $jsonData["amount"],
                    "date_calculate" => Carbon::createFromFormat(ExtApiUtils::dateFormat, $jsonData["date_calculate"])
                        ->setTime(0, 0,0,0)->format('Y-m-d'),
                );

                $data = array(
                    "depositContract" => $depositContract,
                    "schedule" => $schedule,
                );

                return $data;
            }
            else
                return null;
        }
        catch (\Exception $exception)
        {
            return null;
        }

    }

    public static function updateShareholderInfo($phone)
    {
        $shareholderData =  ExtApiUtils::getShareholderByPhone($phone);
        if ($shareholderData)
            Shareholder::where('phone', $phone)->whereNull('deleted_at')->update($shareholderData);
    }

    public static function updateShareholderHeadersInfo($shareholder_id)
    {
        $shareholder = Shareholder::find($shareholder_id);

        $data = ExtApiUtils::getShareholderHeadersInfoByDoc($shareholder->doc);

        if ($data)
        {
            foreach ($data['loans'] as $loan)
            {
                $loanContract = LoanContract::updateOrCreate(
                    ["shareholder_id" => $shareholder_id, "agreement" => $loan["agreement"], "deleted_at" => null],
                    $loan
                );
            }

            foreach ($data['deposits'] as $deposit)
            {
                $depositContract = DepositContract::updateOrCreate(
                    ["shareholder_id" => $shareholder_id, "agreement" => $deposit["agreement"], "deleted_at" => null],
                    $deposit
                );
            }

            foreach ($data['requests'] as $request)
            {
                $depositContract = LoanRequest::updateOrCreate(
                    ["shareholder_id" => $shareholder_id, "request_no" => $request["request_no"],
                        "request_date" => $request["request_date"], "deleted_at" => null],
                    $request
                );
            }
        }
    }

    public static function updateContractLoan($agreement_id)
    {
        $success = false;
        $loanContract = LoanContract::find($agreement_id);
        $isJudjment = $loanContract->is_judgment;
        $data = ExtApiUtils::getContractLoanInfoByAgreement($loanContract->agreement);
        if ($data)
        {
            $loanContract = LoanContract::updateOrCreate(
                ["id" => $agreement_id,],
                $data["loanContract"]
            );

            if ($isJudjment == false)
            {
                LoanMainSchedule::where("loan_id", $loanContract->id)->forceDelete();
                foreach ($data['mainSchedule'] as $line)
                {
                    $line = array_merge($line, array("shareholder_id" => $loanContract->shareholder_id, "loan_id" => $loanContract->id));
                    $mainSchedule = LoanMainSchedule::create($line);
                }

                LoanMemfeeSchedule::where("loan_id", $loanContract->id)->forceDelete();
                foreach ($data['memFeeSchedule'] as $line)
                {
                    $line = array_merge($line, array("shareholder_id" => $loanContract->shareholder_id, "loan_id" => $loanContract->id));
                    $memFeeSchedule = LoanMemfeeSchedule::create($line);
                }
            }

            $success = true;
        }

        return $success;
    }

    public static function updateAllContractLoan($shareholder_id, $onlyOpen = true)
    {
        $loanContracts = LoanContract::where('shareholder_id', $shareholder_id)
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->where('date_calculate', '<', Carbon::now()->format('Y-m-d'))
                    ->orWhere('date_calculate', null);
            })
            ->where('is_open', $onlyOpen)->get();

        foreach ($loanContracts as $loan)
        {
            ExtApiUtils::updateContractLoan($loan->id);
        }
    }

    public static function updateContractDeposit($agreement_id)
    {
        $success = false;
        $depositContract = DepositContract::find($agreement_id);
        $data = ExtApiUtils::getContractDepositInfoByAgreement($depositContract->agreement);
        if ($data)
        {
            $depositContract = DepositContract::updateOrCreate(
                ["id" => $agreement_id,],
                $data["depositContract"]
            );

            DepositSchedule::where("deposit_id", $depositContract->id)->forceDelete();
            foreach ($data['schedule'] as $line)
            {
                $line = array_merge($line, array("shareholder_id" => $depositContract->shareholder_id, "deposit_id" => $depositContract->id));
                $schedule = DepositSchedule::create($line);
            }

            $success = true;
        }

        return $success;
    }

    public static function updateAllContractDeposit($shareholder_id, $onlyOpen = true)
    {
        $depositContracts = DepositContract::where('shareholder_id', $shareholder_id)
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->where('date_calculate', '<', Carbon::now()->format('Y-m-d'))
                    ->orWhere('date_calculate', null);
            })
            ->where('is_open', $onlyOpen)->get();

        foreach ($depositContracts as $deposit)
        {
            ExtApiUtils::updateContractLoan($deposit->id);
        }
    }

    public static function generateQrCodeText($purpose, $fio)
    {
        $text = "";
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
