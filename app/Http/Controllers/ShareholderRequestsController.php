<?php

namespace App\Http\Controllers;

use App\LoanRequest;
use Illuminate\Http\Request;

class ShareholderRequestsController extends ShareholderController
{
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    public function index()
    {
        return view('shareholder.requests');
    }

    public function item($id)
    {
        $loanRequest = LoanRequest::where('shareholder_id', auth()->user()->id)->where('id', $id);
        if ($loanRequest->count() > 0)
            return view('shareholder.requests-item')->with('loanRequest', $loanRequest->get());
        else
            abort(404);
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
