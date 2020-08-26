<?php

namespace App\Http\Requests;

use App\LoanMainSchedule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateLoanMainScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('loan_main_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'shareholder_id' => [
                'required',
                'integer', ],
            'loan_id'        => [
                'required',
                'integer', ],
            'date_plan'      => [
                'required',
                'date_format:'.config('panel.date_format'), ],
            'date_fact'      => [
                'required',
                'date_format:'.config('panel.date_format'), ],
            'period'         => [
                'min:1',
                'max:100', ],
            'days'           => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647', ],
        ];
    }
}
