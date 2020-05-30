<?php

namespace App\Http\Requests;

use App\Shareholder;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateShareholderRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shareholder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'phone'           => [
                'min:5',
                'max:15',
                'required',
            ],
            'password'        => [
                'required',
            ],
            'code'            => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'sms_sended_at'   => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'fio'             => [
                'min:5',
                'max:190',
                'required',
            ],
            'code_expires_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
