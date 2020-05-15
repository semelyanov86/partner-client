<?php

namespace App\Http\Controllers;

use App\LoanRequest;
use Illuminate\Http\Request;

class ShareholderRequestsController extends ShareholderController
{
    const PAGINATE_NUMBER = 5;

    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    public function index()
    {
        $loanRequests = LoanRequest::where('shareholder_id', auth()->user()->id)->orderBy('request_date', 'desc')->paginate(self::PAGINATE_NUMBER);
        return view('shareholder.requests')->with('badges',  $this->getBadges())->with('loanRequests', $loanRequests);
    }

    public function search (Request $request)
    {
        $loanRequests = LoanRequest::where('shareholder_id', auth()->user()->id)->when(request('dateFromFilter'), function($query) {
            return $query->where('request_date','>=', request('dateFromFilter'));
        })->when(request('dateToFilter'), function($query) {
            return $query->where('request_date','<=', request('dateToFilter'));
        })->orderBy('request_date', 'desc');

        $recordsTotal =  $loanRequests->count();

        $data = array('data' => $loanRequests->skip($request->query('start'))->take($request->query('length'))->get(),
            'recordsTotal' => $recordsTotal,
            "recordsFiltered" => $recordsTotal
            );

        return response()->json($data);
    }
}
