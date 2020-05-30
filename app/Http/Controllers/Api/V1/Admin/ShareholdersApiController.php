<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShareholderRequest;
use App\Http\Requests\UpdateShareholderRequest;
use App\Http\Resources\Admin\ShareholderResource;
use App\Shareholder;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareholdersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shareholder_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShareholderResource(Shareholder::all());
    }

    public function store(StoreShareholderRequest $request)
    {
        $shareholder = Shareholder::create($request->all());

        return (new ShareholderResource($shareholder))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Shareholder $shareholder)
    {
        abort_if(Gate::denies('shareholder_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShareholderResource($shareholder);
    }

    public function update(UpdateShareholderRequest $request, Shareholder $shareholder)
    {
        $shareholder->update($request->all());

        return (new ShareholderResource($shareholder))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Shareholder $shareholder)
    {
        abort_if(Gate::denies('shareholder_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shareholder->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
