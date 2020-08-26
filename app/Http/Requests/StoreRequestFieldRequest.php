<?php

namespace App\Http\Requests;

use App\RequestField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreRequestFieldRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('request_field_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'no'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'key'   => [
                'required',
                'unique:request_fields',
            ],
            'title' => [
                'required',
            ],
            'type'  => [
                'required',
            ],
        ];
    }
}
