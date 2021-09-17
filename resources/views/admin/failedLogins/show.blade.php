@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.failedLogin.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.failed-logins.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.failedLogin.fields.id') }}
                        </th>
                        <td>
                            {{ $failedLogin->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.failedLogin.fields.ip_address') }}
                        </th>
                        <td>
                            {{ $failedLogin->ip_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.failedLogin.fields.phone') }}
                        </th>
                        <td>
                            {{ $failedLogin->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.failedLogin.fields.sms') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $failedLogin->sms ? 'checked' : '' }}>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.failedLogin.fields.created_at') }}
                        </th>
                        <td>
                            {{ $failedLogin->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.failed-logins.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
