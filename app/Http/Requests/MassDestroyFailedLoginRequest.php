<?php

namespace App\Http\Requests;

use App\FailedLogin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFailedLoginRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('failed_login_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:failed_logins,id',
        ];
    }
}
