<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareholderCreditCalcController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    public function index()
    {
        return view('shareholder.creditcalc');
    }

    public function data()
    {
        $calcSchedule = array(["no" => "2", "payment_date" => "2020-06-27", "debt" => "10000", "main_amt" => "1000", "percent_amt" => "373.70", "mem_fee"=>"110", "payment_amt" => "1483.70"],
            ["no" => "1", "payment_date" => "2020-07-27", "debt" => "10000", "main_amt" => "1000", "percent_amt" => "373.70", "mem_fee"=>"110", "payment_amt" => "1483.70"],

        );

        $data = array( 'data' => $calcSchedule,
            'recordsTotal' => 2,
            "recordsFiltered" => 2);

        return response()->json($data);
    }

}
