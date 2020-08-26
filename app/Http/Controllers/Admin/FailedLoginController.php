<?php

namespace App\Http\Controllers\Admin;

use App\FailedLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFailedLoginRequest;
use App\Http\Requests\StoreFailedLoginRequest;
use App\Http\Requests\UpdateFailedLoginRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FailedLoginController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('failed_login_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FailedLogin::query()->select(sprintf('%s.*', (new FailedLogin)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'failed_login_show';
                $editGate = 'failed_login_edit';
                $deleteGate = 'failed_login_delete';
                $crudRoutePart = 'failed-logins';

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
            $table->editColumn('ip_address', function ($row) {
                return $row->ip_address ? $row->ip_address : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('sms', function ($row) {
                return '<input type="checkbox" disabled '.($row->sms ? 'checked' : null).'>';
            });

            $table->rawColumns(['actions', 'placeholder', 'sms']);

            return $table->make(true);
        }

        return view('admin.failedLogins.index');
    }

    public function create()
    {
        abort_if(Gate::denies('failed_login_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.failedLogins.create');
    }

    public function store(StoreFailedLoginRequest $request)
    {
        $failedLogin = FailedLogin::create($request->all());

        return redirect()->route('admin.failed-logins.index');
    }

    public function edit(FailedLogin $failedLogin)
    {
        abort_if(Gate::denies('failed_login_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.failedLogins.edit', compact('failedLogin'));
    }

    public function update(UpdateFailedLoginRequest $request, FailedLogin $failedLogin)
    {
        $failedLogin->update($request->all());

        return redirect()->route('admin.failed-logins.index');
    }

    public function show(FailedLogin $failedLogin)
    {
        abort_if(Gate::denies('failed_login_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.failedLogins.show', compact('failedLogin'));
    }

    public function destroy(FailedLogin $failedLogin)
    {
        abort_if(Gate::denies('failed_login_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $failedLogin->delete();

        return back();
    }

    public function massDestroy(MassDestroyFailedLoginRequest $request)
    {
        FailedLogin::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
