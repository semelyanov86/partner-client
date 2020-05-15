<?php

namespace App\Http\Controllers;

use App\DepositContract;
use App\LoanContract;
use App\LoanRequest;
use Illuminate\Http\Request;
use Auth;

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
        return view('shareholder.home')->with('badges',  $this->getBadges());
    }

    public function getBadges()
    {
        $requestsCount = LoanRequest::where('shareholder_id', '=', Auth::id())->count();
        $loansCount = LoanContract::where('shareholder_id', '=', Auth::id())->count();
        $depositsCount = DepositContract::where('shareholder_id', '=', Auth::id())->count();

        $badges = array("loans" => $loansCount, "requests" => $requestsCount, "deposits" => $depositsCount);

        return $badges;
    }
}
