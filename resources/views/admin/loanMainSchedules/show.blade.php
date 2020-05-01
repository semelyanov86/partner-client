@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.loanMainSchedule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-main-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.id') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.shareholder') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->shareholder->fio ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.loan') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->loan->agreement ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.date_plan') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->date_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.date_fact') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->date_fact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.period') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->period }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.days') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->days }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.main_amt_plan') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->main_amt_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.main_amt_fact') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->main_amt_fact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.main_amt_debt_plan') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->main_amt_debt_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.main_amt_debt_fact') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->main_amt_debt_fact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.percent_amt_plan') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->percent_amt_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.percent_amt_fact') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->percent_amt_fact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.fee_plan') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->fee_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMainSchedule.fields.fee_fact') }}
                        </th>
                        <td>
                            {{ $loanMainSchedule->fee_fact }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-main-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection