<?php

namespace App\Http\Controllers\Admin;

use App\DepositContract;
use App\DepositSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDepositScheduleRequest;
use App\Http\Requests\StoreDepositScheduleRequest;
use App\Http\Requests\UpdateDepositScheduleRequest;
use App\Shareholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DepositScheduleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('deposit_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DepositSchedule::with(['deposit', 'shareholder'])->select(sprintf('%s.*', (new DepositSchedule)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'deposit_schedule_show';
                $editGate = 'deposit_schedule_edit';
                $deleteGate = 'deposit_schedule_delete';
                $crudRoutePart = 'deposit-schedules';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('deposit_agreement', function ($row) {
                return $row->deposit ? $row->deposit->agreement : '';
            });

            $table->addColumn('shareholder_fio', function ($row) {
                return $row->shareholder ? $row->shareholder->fio : '';
            });

            $table->editColumn('days', function ($row) {
                return $row->days ? $row->days : '';
            });
            $table->editColumn('main_amt_debt', function ($row) {
                return $row->main_amt_debt ? $row->main_amt_debt : '';
            });
            $table->editColumn('main_amt_fact', function ($row) {
                return $row->main_amt_fact ? $row->main_amt_fact : '';
            });
            $table->editColumn('ndfl_amt', function ($row) {
                return $row->ndfl_amt ? $row->ndfl_amt : '';
            });
            $table->editColumn('percent_available', function ($row) {
                return $row->percent_available ? $row->percent_available : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'deposit', 'shareholder']);

            return $table->make(true);
        }

        return view('admin.depositSchedules.index');
    }

    public function create()
    {
        abort_if(Gate::denies('deposit_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deposits = DepositContract::all()->pluck('agreement', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.depositSchedules.create', compact('deposits', 'shareholders'));
    }

    public function store(StoreDepositScheduleRequest $request)
    {
        $depositSchedule = DepositSchedule::create($request->all());

        return redirect()->route('admin.deposit-schedules.index');
    }

    public function edit(DepositSchedule $depositSchedule)
    {
        abort_if(Gate::denies('deposit_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deposits = DepositContract::all()->pluck('agreement', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $depositSchedule->load('deposit', 'shareholder');

        return view('admin.depositSchedules.edit', compact('deposits', 'shareholders', 'depositSchedule'));
    }

    public function update(UpdateDepositScheduleRequest $request, DepositSchedule $depositSchedule)
    {
        $depositSchedule->update($request->all());

        return redirect()->route('admin.deposit-schedules.index');
    }

    public function show(DepositSchedule $depositSchedule)
    {
        abort_if(Gate::denies('deposit_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depositSchedule->load('deposit', 'shareholder');

        return view('admin.depositSchedules.show', compact('depositSchedule'));
    }

    public function destroy(DepositSchedule $depositSchedule)
    {
        abort_if(Gate::denies('deposit_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depositSchedule->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyDepositScheduleRequest $request)
    {
        DepositSchedule::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
