<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanRequestRequest;
use App\Http\Requests\StoreLoanRequestRequest;
use App\Http\Requests\UpdateLoanRequestRequest;
use App\LoanRequest;
use App\Shareholder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LoanRequestController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('loan_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LoanRequest::with(['shareholder'])->select(sprintf('%s.*', (new LoanRequest)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'loan_request_show';
                $editGate = 'loan_request_edit';
                $deleteGate = 'loan_request_delete';
                $crudRoutePart = 'loan-requests';

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

            $table->editColumn('request_no', function ($row) {
                return $row->request_no ? $row->request_no : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'shareholder']);

            return $table->make(true);
        }

        return view('admin.loanRequests.index');
    }

    public function create()
    {
        abort_if(Gate::denies('loan_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.loanRequests.create', compact('shareholders'));
    }

    public function store(StoreLoanRequestRequest $request)
    {
        $loanRequest = LoanRequest::create($request->all());

        return redirect()->route('admin.loan-requests.index');
    }

    public function edit(LoanRequest $loanRequest)
    {
        abort_if(Gate::denies('loan_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholders = Shareholder::all()->pluck('fio', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loanRequest->load('shareholder');

        return view('admin.loanRequests.edit', compact('shareholders', 'loanRequest'));
    }

    public function update(UpdateLoanRequestRequest $request, LoanRequest $loanRequest)
    {
        $loanRequest->update($request->all());

        return redirect()->route('admin.loan-requests.index');
    }

    public function show(LoanRequest $loanRequest)
    {
        abort_if(Gate::denies('loan_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanRequest->load('shareholder');

        return view('admin.loanRequests.show', compact('loanRequest'));
    }

    public function destroy(LoanRequest $loanRequest)
    {
        abort_if(Gate::denies('loan_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanRequest->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyLoanRequestRequest $request)
    {
        LoanRequest::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
