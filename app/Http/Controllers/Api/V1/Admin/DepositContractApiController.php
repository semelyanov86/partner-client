<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DepositContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositContractRequest;
use App\Http\Requests\UpdateDepositContractRequest;
use App\Http\Resources\Admin\DepositContractResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepositContractApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deposit_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DepositContractResource(DepositContract::with(['shareholder'])->get());
    }

    public function store(StoreDepositContractRequest $request)
    {
        $depositContract = DepositContract::create($request->all());

        return (new DepositContractResource($depositContract))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DepositContract $depositContract)
    {
        abort_if(Gate::denies('deposit_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DepositContractResource($depositContract->load(['shareholder']));
    }

    public function update(UpdateDepositContractRequest $request, DepositContract $depositContract)
    {
        $depositContract->update($request->all());

        return (new DepositContractResource($depositContract))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DepositContract $depositContract)
    {
        abort_if(Gate::denies('deposit_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depositContract->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
