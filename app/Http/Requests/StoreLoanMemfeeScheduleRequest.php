<?php

namespace App\Http\Requests;

use App\LoanMemfeeSchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreLoanMemfeeScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('loan_memfee_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'mem_fee_plan'   => [
                'required', ],
            'mem_fee_fact'   => [
                'required', ],
        ];
    }
}
