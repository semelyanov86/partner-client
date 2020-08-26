<?php

namespace App\Http\Requests;

use App\DepositContract;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateDepositContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('deposit_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'shareholder_id' => [
                'required',
                'integer', ],
            'date_calculate' => [
                'required',
                'date_format:'.config('panel.date_format'), ],
            'agreement'      => [
                'min:5',
                'max:15',
                'required', ],
            'date_start'     => [
                'required',
                'date_format:'.config('panel.date_format'), ],
            'date_end'       => [
                'required',
                'date_format:'.config('panel.date_format'), ],
            'percent'        => [
                'required',
                'max:100', ],
        ];
    }
}
