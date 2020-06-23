@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.requestField.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.request-fields.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="no">{{ trans('cruds.requestField.fields.no') }}</label>
                <input class="form-control {{ $errors->has('no') ? 'is-invalid' : '' }}" type="number" name="no" id="no" value="{{ old('no', '1') }}" step="1" required>
                @if($errors->has('no'))
                    <span class="text-danger">{{ $errors->first('no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.requestField.fields.no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="key">{{ trans('cruds.requestField.fields.key') }}</label>
                <input class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}" type="text" name="key" id="key" value="{{ old('key', '') }}" required>
                @if($errors->has('key'))
                    <span class="text-danger">{{ $errors->first('key') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.requestField.fields.key_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.requestField.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\RequestField::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', 'string') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.requestField.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.requestField.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.requestField.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="placeholder">{{ trans('cruds.requestField.fields.placeholder') }}</label>
                <input class="form-control {{ $errors->has('placeholder') ? 'is-invalid' : '' }}" type="text" name="placeholder" id="placeholder" value="{{ old('placeholder', '') }}">
                @if($errors->has('placeholder'))
                    <span class="text-danger">{{ $errors->first('placeholder') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.requestField.fields.placeholder_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('required') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="required" value="0">
                    <input class="form-check-input" type="checkbox" name="required" id="required" value="1" {{ old('required', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="required">{{ trans('cruds.requestField.fields.required') }}</label>
                </div>
                @if($errors->has('required'))
                    <span class="text-danger">{{ $errors->first('required') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.requestField.fields.required_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection