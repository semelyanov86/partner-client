<?php

namespace App\Http\Controllers;

use App\LoanRequest;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Response;

class ShareholderRequestsController extends ShareholderController
{
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    public function index()
    {
        $loanRequests = LoanRequest::where('shareholder_id', '=', Auth::id())->orderBy('request_date', 'desc')->paginate(5);
        return view('shareholder.requests')->with('badges',  $this->getBadges())->with('loanRequests', $loanRequests);
    }

    public function search (Request $request)
    {
        $loanRequests = LoanRequest::where('shareholder_id', '=', Auth::id())
            ->where(function ($query) use ($request) {
                if ($request->input('dateFromFilter') != null) {
                    return $query->where('request_date','>=', $request->input('dateFromFilter'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->input('dateToFilter') != null) {
                    return $query->where('request_date','<=', $request->input('dateToFilter'));
                }
            })
            ->orderBy('request_date', 'desc');

        $recordsTotal =  $loanRequests->count();

        $data = array('data' => $loanRequests->skip($request->query('start'))->take($request->query('length'))->get(),
            'recordsTotal' => $recordsTotal,
            "recordsFiltered" => $recordsTotal
            );

        return $data;
    }
}
