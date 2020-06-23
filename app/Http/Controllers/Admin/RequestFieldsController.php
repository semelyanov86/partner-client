<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRequestFieldRequest;
use App\Http\Requests\StoreRequestFieldRequest;
use App\Http\Requests\UpdateRequestFieldRequest;
use App\RequestField;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestFieldsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('request_field_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $requestFields = RequestField::all();

        return view('admin.requestFields.index', compact('requestFields'));
    }

    public function create()
    {
        abort_if(Gate::denies('request_field_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.requestFields.create');
    }

    public function store(StoreRequestFieldRequest $request)
    {
        $requestField = RequestField::create($request->all());

        return redirect()->route('admin.request-fields.index');
    }

    public function edit(RequestField $requestField)
    {
        abort_if(Gate::denies('request_field_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.requestFields.edit', compact('requestField'));
    }

    public function update(UpdateRequestFieldRequest $request, RequestField $requestField)
    {
        $requestField->update($request->all());

        return redirect()->route('admin.request-fields.index');
    }

    public function show(RequestField $requestField)
    {
        abort_if(Gate::denies('request_field_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.requestFields.show', compact('requestField'));
    }

    public function destroy(RequestField $requestField)
    {
        abort_if(Gate::denies('request_field_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $requestField->delete();

        return back();
    }

    public function massDestroy(MassDestroyRequestFieldRequest $request)
    {
        RequestField::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
