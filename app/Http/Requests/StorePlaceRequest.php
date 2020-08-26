<?php

namespace App\Http\Requests;

use App\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StorePlaceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('place_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
