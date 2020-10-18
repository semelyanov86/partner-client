@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.requestField.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.request-fields.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.id') }}
                        </th>
                        <td>
                            {{ $requestField->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.no') }}
                        </th>
                        <td>
                            {{ $requestField->no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.key') }}
                        </th>
                        <td>
                            {{ $requestField->key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.type') }}
                        </th>
                        <td>
                            {{ App\RequestField::TYPE_SELECT[$requestField->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.title') }}
                        </th>
                        <td>
                            {{ $requestField->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.placeholder') }}
                        </th>
                        <td>
                            {{ $requestField->placeholder }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.required') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $requestField->required ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.personal_data') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $requestField->personal_data ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.requestField.fields.read_only') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $requestField->read_only ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.request-fields.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection