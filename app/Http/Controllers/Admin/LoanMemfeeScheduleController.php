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
use Yajra\DataTables\Facades\DataTables;

class LoanMemfeeScheduleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('loan_memfee_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LoanMemfeeSchedule::with(['shareholder', 'loan'])->select(sprintf('%s.*', (new LoanMemfeeSchedule)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'loan_memfee_schedule_show';
                $editGate      = 'loan_memfee_schedule_edit';
                $deleteGate    = 'loan_memfee_schedule_delete';
                $crudRoutePart = 'loan-memfee-schedules';

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

            $table->editColumn('mem_fee_plan', function ($row) {
                return $row->mem_fee_plan ? $row->mem_fee_plan : "";
            });
            $table->editColumn('mem_fee_fact', function ($row) {
                return $row->mem_fee_fact ? $row->mem_fee_fact : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'shareholder', 'loan']);

            return $table->make(true);
        }

        return view('admin.loanMemfeeSchedules.index');
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
