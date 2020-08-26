<?php

namespace App\Http\Requests;

use App\FailedLogin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateFailedLoginRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('failed_login_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ip_address' => [
                'min:5',
                'max:20',
                'required',
            ],
            'phone'      => [
                'min:5',
                'max:20',
                'required',
            ],
        ];
    }
}
