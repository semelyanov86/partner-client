<?php

namespace App\Http\Requests;

use App\Place;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePlaceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('place_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
        ];
    }
}
