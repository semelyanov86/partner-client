<?php

namespace App\Http\Requests;

use App\DepositSchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UpdateDepositScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('deposit_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'deposit_id'    => [
                'required',
                'integer', ],
            'date_plan'     => [
                'required',
                'date_format:'.config('panel.date_format'), ],
            'date_fact'     => [
                'date_format:'.config('panel.date_format'),
                'nullable', ],
            'period'        => [
                'min:1',
                'max:100', ],
            'days'          => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647', ],
            'main_amt_debt' => [
                'required', ],
            'main_amt_fact' => [
                'required', ],
        ];
    }
}
