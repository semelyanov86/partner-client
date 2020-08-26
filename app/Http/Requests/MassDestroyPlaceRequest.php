<?php

namespace App\Http\Requests;

use App\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlaceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('place_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:places,id',
            ],
        ];
    }
}
