<?php

namespace App\Http\Requests;

use App\Shareholder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShareholderRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shareholder_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:shareholders,id',
            ],
        ];
    }
}
