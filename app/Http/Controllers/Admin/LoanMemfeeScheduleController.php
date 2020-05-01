<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanMemfeeScheduleRequest;
use App\Http\Requests\StoreLoanMemfeeScheduleRequest;
use App\Http\Requests\UpdateLoanMemfeeScheduleRequest;
use App\LoanContract;
use App\LoanMemfeeSchedule;
use App\Shareholder;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanMemfeeScheduleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_memfee_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanMemfeeSchedules = LoanMemfeeSchedule::all();

        return view('admin.loanMemfeeSchedules.index', compact('loanMemfeeSchedules'));
    }

    public function create()
    {
        abort_if(Gate::denies('loan_memfee_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loans = LoanContract::all()->pluck('agreement', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.loanMemfeeSchedules.create', compact('shareholders', 'loans'));
    }

    public function store(StoreLoanMemfeeScheduleRequest $request)
    {
        $loanMemfeeSchedule = LoanMemfeeSchedule::create($request->all());

        return redirect()->route('admin.loan-memfee-schedules.index');

    }

    public function edit(LoanMemfeeSchedule $loanMemfeeSchedule)
    {
        abort_if(Gate::denies('loan_memfee_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loans = LoanContract::all()->pluck('agreement', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loanMemfeeSchedule->load('shareholder', 'loan');

        return view('admin.loanMemfeeSchedules.edit', compact('shareholders', 'loans', 'loanMemfeeSchedule'));
    }

    public function update(UpdateLoanMemfeeScheduleRequest $request, LoanMemfeeSchedule $loanMemfeeSchedule)
    {
        $loanMemfeeSchedule->update($request->all());

        return redirect()->route('admin.loan-memfee-schedules.index');

    }

    public function show(LoanMemfeeSchedule $loanMemfeeSchedule)
    {
        abort_if(Gate::denies('loan_memfee_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanMemfeeSchedule->load('shareholder', 'loan');

        return view('admin.loanMemfeeSchedules.show', compact('loanMemfeeSchedule'));
    }

    public function destroy(LoanMemfeeSchedule $loanMemfeeSchedule)
    {
        abort_if(Gate::denies('loan_memfee_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanMemfeeSchedule->delete();

        return back();

    }

    public function massDestroy(MassDestroyLoanMemfeeScheduleRequest $request)
    {
        LoanMemfeeSchedule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
