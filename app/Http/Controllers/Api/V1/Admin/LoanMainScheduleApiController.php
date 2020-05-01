<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanMainScheduleRequest;
use App\Http\Requests\UpdateLoanMainScheduleRequest;
use App\Http\Resources\Admin\LoanMainScheduleResource;
use App\LoanMainSchedule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanMainScheduleApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_main_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanMainScheduleResource(LoanMainSchedule::with(['shareholder', 'loan'])->get());

    }

    public function store(StoreLoanMainScheduleRequest $request)
    {
        $loanMainSchedule = LoanMainSchedule::create($request->all());

        return (new LoanMainScheduleResource($loanMainSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(LoanMainSchedule $loanMainSchedule)
    {
        abort_if(Gate::denies('loan_main_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanMainScheduleResource($loanMainSchedule->load(['shareholder', 'loan']));

    }

    public function update(UpdateLoanMainScheduleRequest $request, LoanMainSchedule $loanMainSchedule)
    {
        $loanMainSchedule->update($request->all());

        return (new LoanMainScheduleResource($loanMainSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(LoanMainSchedule $loanMainSchedule)
    {
        abort_if(Gate::denies('loan_main_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanMainSchedule->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
