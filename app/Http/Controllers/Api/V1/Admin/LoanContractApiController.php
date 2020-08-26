<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanContractRequest;
use App\Http\Requests\UpdateLoanContractRequest;
use App\Http\Resources\Admin\LoanContractResource;
use App\LoanContract;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanContractApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanContractResource(LoanContract::with(['shareholder'])->get());
    }

    public function store(StoreLoanContractRequest $request)
    {
        $loanContract = LoanContract::create($request->all());

        return (new LoanContractResource($loanContract))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LoanContract $loanContract)
    {
        abort_if(Gate::denies('loan_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanContractResource($loanContract->load(['shareholder']));
    }

    public function update(UpdateLoanContractRequest $request, LoanContract $loanContract)
    {
        $loanContract->update($request->all());

        return (new LoanContractResource($loanContract))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LoanContract $loanContract)
    {
        abort_if(Gate::denies('loan_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanContract->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
