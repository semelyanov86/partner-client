<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequestRequest;
use App\Http\Requests\UpdateLoanRequestRequest;
use App\Http\Resources\Admin\LoanRequestResource;
use App\LoanRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanRequestApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanRequestResource(LoanRequest::with(['shareholder'])->get());

    }

    public function store(StoreLoanRequestRequest $request)
    {
        $loanRequest = LoanRequest::create($request->all());

        return (new LoanRequestResource($loanRequest))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(LoanRequest $loanRequest)
    {
        abort_if(Gate::denies('loan_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LoanRequestResource($loanRequest->load(['shareholder']));

    }

    public function update(UpdateLoanRequestRequest $request, LoanRequest $loanRequest)
    {
        $loanRequest->update($request->all());

        return (new LoanRequestResource($loanRequest))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(LoanRequest $loanRequest)
    {
        abort_if(Gate::denies('loan_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanRequest->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
