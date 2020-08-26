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
}
