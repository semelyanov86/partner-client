@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.loanContract.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-contracts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.id') }}
                        </th>
                        <td>
                            {{ $loanContract->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.shareholder') }}
                        </th>
                        <td>
                            {{ $loanContract->shareholder->fio ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.date_calculate') }}
                        </th>
                        <td>
                            {{ $loanContract->date_calculate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.agreement') }}
                        </th>
                        <td>
                            {{ $loanContract->agreement }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.date_start') }}
                        </th>
                        <td>
                            {{ $loanContract->date_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.date_end') }}
                        </th>
                        <td>
                            {{ $loanContract->date_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.amount') }}
                        </th>
                        <td>
                            {{ $loanContract->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.percent') }}
                        </th>
                        <td>
                            {{ $loanContract->percent }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.mem_fee') }}
                        </th>
                        <td>
                            {{ $loanContract->mem_fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.actual_debt') }}
                        </th>
                        <td>
                            {{ $loanContract->actual_debt }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.full_debt') }}
                        </th>
                        <td>
                            {{ $loanContract->full_debt }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanContract.fields.is_open') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $loanContract->is_open ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-contracts.index') }}">
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
            <a class="nav-link" href="#loan_loan_main_schedules" role="tab" data-toggle="tab">
                {{ trans('cruds.loanMainSchedule.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#loan_loan_memfee_schedules" role="tab" data-toggle="tab">
                {{ trans('cruds.loanMemfeeSchedule.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="loan_loan_main_schedules">
            @includeIf('admin.loanContracts.relationships.loanLoanMainSchedules', ['loanMainSchedules' => $loanContract->loanLoanMainSchedules])
        </div>
        <div class="tab-pane" role="tabpanel" id="loan_loan_memfee_schedules">
            @includeIf('admin.loanContracts.relationships.loanLoanMemfeeSchedules', ['loanMemfeeSchedules' => $loanContract->loanLoanMemfeeSchedules])
        </div>
    </div>
</div>

@endsection