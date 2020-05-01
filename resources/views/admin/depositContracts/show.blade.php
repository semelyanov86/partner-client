@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.depositContract.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deposit-contracts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.id') }}
                        </th>
                        <td>
                            {{ $depositContract->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.shareholder') }}
                        </th>
                        <td>
                            {{ $depositContract->shareholder->fio ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.date_calculate') }}
                        </th>
                        <td>
                            {{ $depositContract->date_calculate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.agreement') }}
                        </th>
                        <td>
                            {{ $depositContract->agreement }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.date_start') }}
                        </th>
                        <td>
                            {{ $depositContract->date_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.date_end') }}
                        </th>
                        <td>
                            {{ $depositContract->date_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.percent') }}
                        </th>
                        <td>
                            {{ $depositContract->percent }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositContract.fields.is_open') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $depositContract->is_open ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deposit-contracts.index') }}">
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
            <a class="nav-link" href="#deposit_deposit_schedules" role="tab" data-toggle="tab">
                {{ trans('cruds.depositSchedule.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="deposit_deposit_schedules">
            @includeIf('admin.depositContracts.relationships.depositDepositSchedules', ['depositSchedules' => $depositContract->depositDepositSchedules])
        </div>
    </div>
</div>

@endsection