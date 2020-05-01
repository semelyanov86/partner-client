@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.loanMemfeeSchedule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-memfee-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMemfeeSchedule.fields.id') }}
                        </th>
                        <td>
                            {{ $loanMemfeeSchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMemfeeSchedule.fields.shareholder') }}
                        </th>
                        <td>
                            {{ $loanMemfeeSchedule->shareholder->fio ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMemfeeSchedule.fields.loan') }}
                        </th>
                        <td>
                            {{ $loanMemfeeSchedule->loan->agreement ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMemfeeSchedule.fields.date_plan') }}
                        </th>
                        <td>
                            {{ $loanMemfeeSchedule->date_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_plan') }}
                        </th>
                        <td>
                            {{ $loanMemfeeSchedule->mem_fee_plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_fact') }}
                        </th>
                        <td>
                            {{ $loanMemfeeSchedule->mem_fee_fact }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-memfee-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection