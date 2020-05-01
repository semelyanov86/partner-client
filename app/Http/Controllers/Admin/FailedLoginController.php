<?php

namespace App\Http\Controllers\Admin;

use App\FailedLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFailedLoginRequest;
use App\Http\Requests\StoreFailedLoginRequest;
use App\Http\Requests\UpdateFailedLoginRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FailedLoginController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('failed_login_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $failedLogins = FailedLogin::all();

        return view('admin.failedLogins.index', compact('failedLogins'));
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
