@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.shareholder.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shareholders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.id') }}
                        </th>
                        <td>
                            {{ $shareholder->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.phone') }}
                        </th>
                        <td>
                            {{ $shareholder->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.password') }}
                        </th>
                        <td>
                            {{ $shareholder->password }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.code') }}
                        </th>
                        <td>
                            {{ $shareholder->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.sms_sended_at') }}
                        </th>
                        <td>
                            {{ $shareholder->sms_sended_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.doc') }}
                        </th>
                        <td>
                            {{ $shareholder->doc }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.fio') }}
                        </th>
                        <td>
                            {{ $shareholder->fio }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.allow_request') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $shareholder->allow_request ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shareholder.fields.code_expires_at') }}
                        </th>
                        <td>
                            {{ $shareholder->code_expires_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shareholders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#shareholder_loan_requests" role="tab" data-toggle="tab">
                {{ trans('cruds.loanRequest.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#shareholder_deposit_contracts" role="tab" data-toggle="tab">
                {{ trans('cruds.depositContract.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#shareholder_loan_contracts" role="tab" data-toggle="tab">
                {{ trans('cruds.loanContract.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="shareholder_loan_requests">
            @includeIf('admin.shareholders.relationships.shareholderLoanRequests', ['loanRequests' => $shareholder->shareholderLoanRequests])
        </div>
        <div class="tab-pane" role="tabpanel" id="shareholder_deposit_contracts">
            @includeIf('admin.shareholders.relationships.shareholderDepositContracts', ['depositContracts' => $shareholder->shareholderDepositContracts])
        </div>
        <div class="tab-pane" role="tabpanel" id="shareholder_loan_contracts">
            @includeIf('admin.shareholders.relationships.shareholderLoanContracts', ['loanContracts' => $shareholder->shareholderLoanContracts])
        </div>
    </div>
</div>

@endsection