<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\FailedLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFailedLoginRequest;
use App\Http\Requests\UpdateFailedLoginRequest;
use App\Http\Resources\Admin\FailedLoginResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FailedLoginApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('failed_login_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FailedLoginResource(FailedLogin::all());
    }

    public function store(StoreFailedLoginRequest $request)
    {
        $failedLogin = FailedLogin::create($request->all());

        return (new FailedLoginResource($failedLogin))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FailedLogin $failedLogin)
    {
        abort_if(Gate::denies('failed_login_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FailedLoginResource($failedLogin);
    }

    public function update(UpdateFailedLoginRequest $request, FailedLogin $failedLogin)
    {
        $failedLogin->update($request->all());

        return (new FailedLoginResource($failedLogin))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FailedLogin $failedLogin)
    {
        abort_if(Gate::denies('failed_login_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $failedLogin->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
