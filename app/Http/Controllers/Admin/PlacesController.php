<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlaceRequest;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlacesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('place_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Place::query()->select(sprintf('%s.*', (new Place)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'place_show';
                $editGate = 'place_edit';
                $deleteGate = 'place_delete';
                $crudRoutePart = 'places';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.places.index');
    }

    public function create()
    {
        abort_if(Gate::denies('place_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.places.create');
    }

    public function store(StorePlaceRequest $request)
    {
        $place = Place::create($request->all());

        return redirect()->route('admin.places.index');
    }

    public function edit(Place $place)
    {
        abort_if(Gate::denies('place_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.places.edit', compact('place'));
    }

    public function update(UpdatePlaceRequest $request, Place $place)
    {
        $place->update($request->all());

        return redirect()->route('admin.places.index');
    }

    public function show(Place $place)
    {
        abort_if(Gate::denies('place_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.places.show', compact('place'));
    }

    public function destroy(Place $place)
    {
        abort_if(Gate::denies('place_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $place->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyPlaceRequest $request)
    {
        Place::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
