@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.loanRequest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.loanRequest.fields.id') }}
                        </th>
                        <td>
                            {{ $loanRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanRequest.fields.shareholder') }}
                        </th>
                        <td>
                            {{ $loanRequest->shareholder->fio ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanRequest.fields.request_no') }}
                        </th>
                        <td>
                            {{ $loanRequest->request_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanRequest.fields.amount') }}
                        </th>
                        <td>
                            {{ $loanRequest->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanRequest.fields.status') }}
                        </th>
                        <td>
                            {{ $loanRequest->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection