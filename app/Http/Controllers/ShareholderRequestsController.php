<?php

namespace App\Http\Controllers;

use App\Helpers\ExtApiUtils;
use App\LoanRequest;
use App\Place;
use App\RequestField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShareholderRequestsController extends Controller
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
        $loanRequest = LoanRequest::where('shareholder_id', auth()->user()->id)
            ->whereNull('deleted_at')->where('id', $id);
        if ($loanRequest->count() > 0)
             return view('shareholder.requests-item')->with('loanRequest', $loanRequest->first());
        else
            abort(404);
    }

    public function search (Request $request)
    {
        $loanRequests = LoanRequest::where('shareholder_id', auth()->user()->id)
        ->whereNull('deleted_at')->when(request('dateFromFilter'), function($query) {
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

    public function new()
    {
        if (auth()->user()->allow_request == false)
            abort(404);

        $fields = RequestField::whereNull('deleted_at')->orderBy('no', 'asc')->get();
        $places = Place::whereNull('deleted_at')->orderBy('name')->get();
        return view('shareholder.requests-create')
            ->with('fields', $fields)
            ->with('places', $places);
    }

    protected function validator(array $data)
    {
        $messages = array();
        $messages += ['required' => 'Поле обязательно к заполнению'];

        $rules = array(
            'place' => ['required'],
            'personal_date_accept' => ['required']
        );

        $requestFields = RequestField::whereNull('deleted_at')->get();

        foreach ($requestFields as $requestField)
        {
            $key = $requestField->key;
            if ($requestField)
            {
                $rules += [$key => []];

                if ($requestField['type'] == 'file')
                {
                    $messages += [$key.'.max' => 'Максимальный размер файла 3 Мб'];
                    $rules[$key] += ['max:3072'];
                }

                if ($requestField['required'] == true)
                {
                    $rules[$key] += ['required'];
                }
            }
        }

        return Validator::make($data, $rules, $messages);
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        return redirect()->route('client.thanks')->withMessage('Ваша заявка успешно отправлена!');
    }
}
