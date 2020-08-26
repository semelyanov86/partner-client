<?php

namespace App\Http\Requests;

use App\LoanMemfeeSchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLoanMemfeeScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('loan_memfee_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'exists:loan_memfee_schedules,id',
            ],
        ];
    }
}
