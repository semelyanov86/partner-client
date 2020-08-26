<?php

namespace App\Http\Controllers\Admin;

use App\DepositContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDepositContractRequest;
use App\Http\Requests\StoreDepositContractRequest;
use App\Http\Requests\UpdateDepositContractRequest;
use App\Shareholder;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DepositContractController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('deposit_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DepositContract::with(['shareholder'])->select(sprintf('%s.*', (new DepositContract)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'deposit_contract_show';
                $editGate = 'deposit_contract_edit';
                $deleteGate = 'deposit_contract_delete';
                $crudRoutePart = 'deposit-contracts';

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
            $table->addColumn('shareholder_fio', function ($row) {
                return $row->shareholder ? $row->shareholder->fio : '';
            });

            $table->editColumn('agreement', function ($row) {
                return $row->agreement ? $row->agreement : '';
            });

            $table->editColumn('percent', function ($row) {
                return $row->percent ? $row->percent : '';
            });
            $table->editColumn('is_open', function ($row) {
                return '<input type="checkbox" disabled '.($row->is_open ? 'checked' : null).'>';
            });

            $table->rawColumns(['actions', 'placeholder', 'shareholder', 'is_open']);

            return $table->make(true);
        }

        return view('admin.depositContracts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('deposit_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.depositContracts.create', compact('shareholders'));
    }

    public function store(StoreDepositContractRequest $request)
    {
        $depositContract = DepositContract::create($request->all());

        return redirect()->route('admin.deposit-contracts.index');
    }

    public function edit(DepositContract $depositContract)
    {
        abort_if(Gate::denies('deposit_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $depositContract->load('shareholder');

        return view('admin.depositContracts.edit', compact('shareholders', 'depositContract'));
    }

    public function update(UpdateDepositContractRequest $request, DepositContract $depositContract)
    {
        $depositContract->update($request->all());

        return redirect()->route('admin.deposit-contracts.index');
    }

    public function show(DepositContract $depositContract)
    {
        abort_if(Gate::denies('deposit_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depositContract->load('shareholder', 'depositDepositSchedules');

        return view('admin.depositContracts.show', compact('depositContract'));
    }

    public function destroy(DepositContract $depositContract)
    {
        abort_if(Gate::denies('deposit_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depositContract->delete();

        return back();
    }

    public function massDestroy(MassDestroyDepositContractRequest $request)
    {
        DepositContract::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
