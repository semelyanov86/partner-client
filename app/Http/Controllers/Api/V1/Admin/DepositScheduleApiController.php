<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DepositSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositScheduleRequest;
use App\Http\Requests\UpdateDepositScheduleRequest;
use App\Http\Resources\Admin\DepositScheduleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DepositScheduleApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deposit_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DepositScheduleResource(DepositSchedule::with(['deposit', 'shareholder'])->get());
    }

    public function store(StoreDepositScheduleRequest $request)
    {
        $depositSchedule = DepositSchedule::create($request->all());

        return (new DepositScheduleResource($depositSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DepositSchedule $depositSchedule)
    {
        abort_if(Gate::denies('deposit_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DepositScheduleResource($depositSchedule->load(['deposit', 'shareholder']));
    }

    public function update(UpdateDepositScheduleRequest $request, DepositSchedule $depositSchedule)
    {
        $depositSchedule->update($request->all());

        return (new DepositScheduleResource($depositSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DepositSchedule $depositSchedule)
    {
        abort_if(Gate::denies('deposit_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depositSchedule->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
