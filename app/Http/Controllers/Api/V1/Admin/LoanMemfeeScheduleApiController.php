<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanMemfeeScheduleRequest;
use App\Http\Requests\UpdateLoanMemfeeScheduleRequest;
use App\Http\Resources\Admin\LoanMemfeeScheduleResource;
use App\LoanMemfeeSchedule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanMemfeeScheduleApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_memfee_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanMemfeeScheduleResource(LoanMemfeeSchedule::with(['shareholder', 'loan'])->get());
    }

    public function store(StoreLoanMemfeeScheduleRequest $request)
    {
        $loanMemfeeSchedule = LoanMemfeeSchedule::create($request->all());

        return (new LoanMemfeeScheduleResource($loanMemfeeSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LoanMemfeeSchedule $loanMemfeeSchedule)
    {
        abort_if(Gate::denies('loan_memfee_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanMemfeeScheduleResource($loanMemfeeSchedule->load(['shareholder', 'loan']));
    }

    public function update(UpdateLoanMemfeeScheduleRequest $request, LoanMemfeeSchedule $loanMemfeeSchedule)
    {
        $loanMemfeeSchedule->update($request->all());

        return (new LoanMemfeeScheduleResource($loanMemfeeSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LoanMemfeeSchedule $loanMemfeeSchedule)
    {
        abort_if(Gate::denies('loan_memfee_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanMemfeeSchedule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
