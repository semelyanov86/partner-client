<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShareholderRequest;
use App\Http\Requests\StoreShareholderRequest;
use App\Http\Requests\UpdateShareholderRequest;
use App\Shareholder;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ShareholdersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('shareholder_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Shareholder::query()->select(sprintf('%s.*', (new Shareholder)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'shareholder_show';
                $editGate      = 'shareholder_edit';
                $deleteGate    = 'shareholder_delete';
                $crudRoutePart = 'shareholders';

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
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : "";
            });
            $table->editColumn('password', function ($row) {
                return $row->password ? $row->password : "";
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : "";
            });
            $table->editColumn('fio', function ($row) {
                return $row->fio ? $row->fio : "";
            });
            $table->editColumn('allow_request', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->allow_request ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'allow_request']);

            return $table->make(true);
        }

        return view('admin.shareholders.index');
    }

    public function create()
    {
        abort_if(Gate::denies('shareholder_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shareholders.create');
    }

    public function store(StoreShareholderRequest $request)
    {
        $shareholder = Shareholder::create($request->all());

        return redirect()->route('admin.shareholders.index');
    }

    public function edit(Shareholder $shareholder)
    {
        abort_if(Gate::denies('shareholder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shareholders.edit', compact('shareholder'));
    }

    public function update(UpdateShareholderRequest $request, Shareholder $shareholder)
    {
        $shareholder->update($request->all());

        return redirect()->route('admin.shareholders.index');
    }

    public function show(Shareholder $shareholder)
    {
        abort_if(Gate::denies('shareholder_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholder->load('shareholderLoanRequests', 'shareholderDepositContracts', 'shareholderLoanContracts');

        return view('admin.shareholders.show', compact('shareholder'));
    }

    public function destroy(Shareholder $shareholder)
    {
        abort_if(Gate::denies('shareholder_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholder->delete();

        return back();
    }

    public function massDestroy(MassDestroyShareholderRequest $request)
    {
        Shareholder::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
