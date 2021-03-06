<?php

namespace App\Http\Requests;

use App\RequestField;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRequestFieldRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('request_field_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:request_fields,id',
        ];
    }
}
