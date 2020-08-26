<?php

namespace App\Http\Requests;

use App\DepositContract;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDepositContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('deposit_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => [
                'required',
                'array',
            ],
            'ids.*' => [
                'exists:deposit_contracts,id',
            ],
        ];
    }
}
