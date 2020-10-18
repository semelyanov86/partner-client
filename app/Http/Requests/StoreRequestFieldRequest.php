<?php

namespace App\Http\Requests;

use App\RequestField;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRequestFieldRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('request_field_create');
    }

    public function rules()
    {
        return [
            'no'          => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'key'         => [
                'string',
                'required',
                'unique:request_fields',
            ],
            'type'        => [
                'required',
            ],
            'title'       => [
                'string',
                'required',
            ],
            'placeholder' => [
                'string',
                'nullable',
            ],
        ];
    }
}
