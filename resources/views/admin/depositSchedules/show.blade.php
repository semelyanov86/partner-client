@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.depositSchedule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deposit-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.id') }}
                        </th>
                        <td>
                            {{ $depositSchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.deposit') }}
                        </th>
                        <td>
                            {{ $depositSchedule->deposit->agreement ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.shareholder') }}
                        </th>
                        <td>
                            {{ $depositSchedule->shareholder->fio ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.date_plan') }}
                        </th>
                        <td>
                            {{ $depositSchedule->date_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.date_fact') }}
                        </th>
                        <td>
                            {{ $depositSchedule->date_fact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.period') }}
                        </th>
                        <td>
                            {{ $depositSchedule->period }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.days') }}
                        </th>
                        <td>
                            {{ $depositSchedule->days }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.main_amt_debt') }}
                        </th>
                        <td>
                            {{ $depositSchedule->main_amt_debt }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.main_amt_fact') }}
                        </th>
                        <td>
                            {{ $depositSchedule->main_amt_fact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.ndfl_amt') }}
                        </th>
                        <td>
                            {{ $depositSchedule->ndfl_amt }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.depositSchedule.fields.percent_available') }}
                        </th>
                        <td>
                            {{ $depositSchedule->percent_available }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deposit-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection