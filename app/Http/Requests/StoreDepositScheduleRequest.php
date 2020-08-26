<?php

namespace App\Http\Requests;

use App\DepositSchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreDepositScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('deposit_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
