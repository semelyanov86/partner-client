<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestFieldRequest;
use App\Http\Requests\UpdateRequestFieldRequest;
use App\Http\Resources\Admin\RequestFieldResource;
use App\RequestField;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestFieldsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('request_field_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RequestFieldResource(RequestField::all());
    }

    public function store(StoreRequestFieldRequest $request)
    {
        $requestField = RequestField::create($request->all());

        return (new RequestFieldResource($requestField))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RequestField $requestField)
    {
        abort_if(Gate::denies('request_field_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RequestFieldResource($requestField);
    }

    public function update(UpdateRequestFieldRequest $request, RequestField $requestField)
    {
        $requestField->update($request->all());

        return (new RequestFieldResource($requestField))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RequestField $requestField)
    {
        abort_if(Gate::denies('request_field_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $requestField->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
