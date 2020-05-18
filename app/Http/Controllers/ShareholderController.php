<?php

namespace App\Http\Controllers;

use App\DepositContract;
use App\LoanContract;
use App\LoanRequest;
use Illuminate\Support\Facades\Auth;

class ShareholderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('shareholder.home');
    }

}
