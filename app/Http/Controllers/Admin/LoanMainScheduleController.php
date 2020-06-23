<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanMainScheduleRequest;
use App\Http\Requests\StoreLoanMainScheduleRequest;
use App\Http\Requests\UpdateLoanMainScheduleRequest;
use App\LoanContract;
use App\LoanMainSchedule;
use App\Shareholder;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LoanMainScheduleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('loan_main_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LoanMainSchedule::with(['shareholder', 'loan'])->select(sprintf('%s.*', (new LoanMainSchedule)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'loan_main_schedule_show';
                $editGate      = 'loan_main_schedule_edit';
                $deleteGate    = 'loan_main_schedule_delete';
                $crudRoutePart = 'loan-main-schedules';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('shareholder_fio', function ($row) {
                return $row->shareholder ? $row->shareholder->fio : '';
            });

            $table->addColumn('loan_agreement', function ($row) {
                return $row->loan ? $row->loan->agreement : '';
            });

            $table->editColumn('period', function ($row) {
                return $row->period ? $row->period : "";
            });
            $table->editColumn('days', function ($row) {
                return $row->days ? $row->days : "";
            });
            $table->editColumn('main_amt_plan', function ($row) {
                return $row->main_amt_plan ? $row->main_amt_plan : "";
            });
            $table->editColumn('main_amt_fact', function ($row) {
                return $row->main_amt_fact ? $row->main_amt_fact : "";
            });
            $table->editColumn('main_amt_debt_plan', function ($row) {
                return $row->main_amt_debt_plan ? $row->main_amt_debt_plan : "";
            });
            $table->editColumn('main_amt_debt_fact', function ($row) {
                return $row->main_amt_debt_fact ? $row->main_amt_debt_fact : "";
            });
            $table->editColumn('percent_amt_plan', function ($row) {
                return $row->percent_amt_plan ? $row->percent_amt_plan : "";
            });
            $table->editColumn('percent_amt_fact', function ($row) {
                return $row->percent_amt_fact ? $row->percent_amt_fact : "";
            });
            $table->editColumn('fee_plan', function ($row) {
                return $row->fee_plan ? $row->fee_plan : "";
            });
            $table->editColumn('fee_fact', function ($row) {
                return $row->fee_fact ? $row->fee_fact : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'shareholder', 'loan']);

            return $table->make(true);
        }

        return view('admin.loanMainSchedules.index');
    }

    public function create()
    {
        abort_if(Gate::denies('loan_main_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loans = LoanContract::all()->pluck('agreement', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.loanMainSchedules.create', compact('shareholders', 'loans'));
    }

    public function store(StoreLoanMainScheduleRequest $request)
    {
        $loanMainSchedule = LoanMainSchedule::create($request->all());

        return redirect()->route('admin.loan-main-schedules.index');
    }

    public function edit(LoanMainSchedule $loanMainSchedule)
    {
        abort_if(Gate::denies('loan_main_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loans = LoanContract::all()->pluck('agreement', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loanMainSchedule->load('shareholder', 'loan');

        return view('admin.loanMainSchedules.edit', compact('shareholders', 'loans', 'loanMainSchedule'));
    }

    public function update(UpdateLoanMainScheduleRequest $request, LoanMainSchedule $loanMainSchedule)
    {
        $loanMainSchedule->update($request->all());

        return redirect()->route('admin.loan-main-schedules.index');
    }

    public function show(LoanMainSchedule $loanMainSchedule)
    {
        abort_if(Gate::denies('loan_main_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanMainSchedule->load('shareholder', 'loan');

        return view('admin.loanMainSchedules.show', compact('loanMainSchedule'));
    }

    public function destroy(LoanMainSchedule $loanMainSchedule)
    {
        abort_if(Gate::denies('loan_main_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanMainSchedule->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanMainScheduleRequest $request)
    {
        LoanMainSchedule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
