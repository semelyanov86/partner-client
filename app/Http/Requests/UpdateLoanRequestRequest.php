<?php

namespace App\Http\Requests;

use App\LoanRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateLoanRequestRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('loan_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'request_no'   => [
                'min:1',
                'max:100',
                'required',
            ],
            'amount'       => [
                'required',
            ],
            'status'       => [
                'min:2',
                'max:100',
                'required',
            ],
            'request_date' => [
                'required',
                'date_format:'.config('panel.date_format'),
            ],
        ];
    }
}
