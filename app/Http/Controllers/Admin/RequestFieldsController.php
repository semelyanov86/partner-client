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
use Yajra\DataTables\Facades\DataTables;

class RequestFieldsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('request_field_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = RequestField::query()->select(sprintf('%s.*', (new RequestField)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'request_field_show';
                $editGate      = 'request_field_edit';
                $deleteGate    = 'request_field_delete';
                $crudRoutePart = 'request-fields';

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
            $table->editColumn('no', function ($row) {
                return $row->no ? $row->no : "";
            });
            $table->editColumn('key', function ($row) {
                return $row->key ? $row->key : "";
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('placeholder', function ($row) {
                return $row->placeholder ? $row->placeholder : "";
            });
            $table->editColumn('required', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->required ? 'checked' : null) . '>';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? RequestField::TYPE_SELECT[$row->type] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'required']);

            return $table->make(true);
        }

        return view('admin.requestFields.index');
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
