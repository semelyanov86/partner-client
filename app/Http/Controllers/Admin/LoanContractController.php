<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanContractRequest;
use App\Http\Requests\StoreLoanContractRequest;
use App\Http\Requests\UpdateLoanContractRequest;
use App\LoanContract;
use App\Shareholder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LoanContractController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('loan_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LoanContract::with(['shareholder'])->select(sprintf('%s.*', (new LoanContract)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'loan_contract_show';
                $editGate = 'loan_contract_edit';
                $deleteGate = 'loan_contract_delete';
                $crudRoutePart = 'loan-contracts';

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

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('percent', function ($row) {
                return $row->percent ? $row->percent : '';
            });
            $table->editColumn('mem_fee', function ($row) {
                return $row->mem_fee ? $row->mem_fee : '';
            });
            $table->editColumn('actual_debt', function ($row) {
                return $row->actual_debt ? $row->actual_debt : '';
            });
            $table->editColumn('full_debt', function ($row) {
                return $row->full_debt ? $row->full_debt : '';
            });
            $table->editColumn('is_open', function ($row) {
                return '<input type="checkbox" disabled '.($row->is_open ? 'checked' : null).'>';
            });

            $table->rawColumns(['actions', 'placeholder', 'shareholder', 'is_open']);

            return $table->make(true);
        }

        return view('admin.loanContracts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('loan_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.loanContracts.create', compact('shareholders'));
    }

    public function store(StoreLoanContractRequest $request)
    {
        $loanContract = LoanContract::create($request->all());

        return redirect()->route('admin.loan-contracts.index');
    }

    public function edit(LoanContract $loanContract)
    {
        abort_if(Gate::denies('loan_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loanContract->load('shareholder');

        return view('admin.loanContracts.edit', compact('shareholders', 'loanContract'));
    }

    public function update(UpdateLoanContractRequest $request, LoanContract $loanContract)
    {
        $loanContract->update($request->all());

        return redirect()->route('admin.loan-contracts.index');
    }

    public function show(LoanContract $loanContract)
    {
        abort_if(Gate::denies('loan_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanContract->load('shareholder', 'loanLoanMainSchedules', 'loanLoanMemfeeSchedules');

        return view('admin.loanContracts.show', compact('loanContract'));
    }

    public function destroy(LoanContract $loanContract)
    {
        abort_if(Gate::denies('loan_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanContract->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanContractRequest $request)
    {
        LoanContract::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
