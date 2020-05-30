@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.failedLogin.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.failed-logins.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="ip_address">{{ trans('cruds.failedLogin.fields.ip_address') }}</label>
                <input class="form-control {{ $errors->has('ip_address') ? 'is-invalid' : '' }}" type="text" name="ip_address" id="ip_address" value="{{ old('ip_address', '') }}" required>
                @if($errors->has('ip_address'))
                    <span class="text-danger">{{ $errors->first('ip_address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.failedLogin.fields.ip_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.failedLogin.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.failedLogin.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('sms') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="sms" value="0">
                    <input class="form-check-input" type="checkbox" name="sms" id="sms" value="1" {{ old('sms', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="sms">{{ trans('cruds.failedLogin.fields.sms') }}</label>
                </div>
                @if($errors->has('sms'))
                    <span class="text-danger">{{ $errors->first('sms') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.failedLogin.fields.sms_helper') }}</span>
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