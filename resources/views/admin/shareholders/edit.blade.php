@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.shareholder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.shareholders.update", [$shareholder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.shareholder.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $shareholder->phone) }}" required>
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shareholder.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.shareholder.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="text" name="password" id="password" value="{{ old('password', $shareholder->password) }}" required>
                @if($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shareholder.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="code">{{ trans('cruds.shareholder.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="number" name="code" id="code" value="{{ old('code', $shareholder->code) }}" step="1">
                @if($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shareholder.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sms_sended_at">{{ trans('cruds.shareholder.fields.sms_sended_at') }}</label>
                <input class="form-control datetime {{ $errors->has('sms_sended_at') ? 'is-invalid' : '' }}" type="text" name="sms_sended_at" id="sms_sended_at" value="{{ old('sms_sended_at', $shareholder->sms_sended_at) }}">
                @if($errors->has('sms_sended_at'))
                    <span class="text-danger">{{ $errors->first('sms_sended_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shareholder.fields.sms_sended_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="doc">{{ trans('cruds.shareholder.fields.doc') }}</label>
                <input class="form-control {{ $errors->has('doc') ? 'is-invalid' : '' }}" type="text" name="doc" id="doc" value="{{ old('doc', $shareholder->doc) }}">
                @if($errors->has('doc'))
                    <span class="text-danger">{{ $errors->first('doc') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shareholder.fields.doc_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="fio">{{ trans('cruds.shareholder.fields.fio') }}</label>
                <input class="form-control {{ $errors->has('fio') ? 'is-invalid' : '' }}" type="text" name="fio" id="fio" value="{{ old('fio', $shareholder->fio) }}" required>
                @if($errors->has('fio'))
                    <span class="text-danger">{{ $errors->first('fio') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shareholder.fields.fio_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('allow_request') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="allow_request" value="0">
                    <input class="form-check-input" type="checkbox" name="allow_request" id="allow_request" value="1" {{ $shareholder->allow_request || old('allow_request', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="allow_request">{{ trans('cruds.shareholder.fields.allow_request') }}</label>
                </div>
                @if($errors->has('allow_request'))
                    <span class="text-danger">{{ $errors->first('allow_request') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.shareholder.fields.allow_request_helper') }}</span>
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