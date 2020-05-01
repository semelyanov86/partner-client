@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.loanRequest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loan-requests.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="shareholder_id">{{ trans('cruds.loanRequest.fields.shareholder') }}</label>
                <select class="form-control select2 {{ $errors->has('shareholder') ? 'is-invalid' : '' }}" name="shareholder_id" id="shareholder_id">
                    @foreach($shareholders as $id => $shareholder)
                        <option value="{{ $id }}" {{ old('shareholder_id') == $id ? 'selected' : '' }}>{{ $shareholder }}</option>
                    @endforeach
                </select>
                @if($errors->has('shareholder'))
                    <span class="text-danger">{{ $errors->first('shareholder') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanRequest.fields.shareholder_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="request_no">{{ trans('cruds.loanRequest.fields.request_no') }}</label>
                <input class="form-control {{ $errors->has('request_no') ? 'is-invalid' : '' }}" type="text" name="request_no" id="request_no" value="{{ old('request_no', '') }}" required>
                @if($errors->has('request_no'))
                    <span class="text-danger">{{ $errors->first('request_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanRequest.fields.request_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.loanRequest.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanRequest.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.loanRequest.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}" required>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanRequest.fields.status_helper') }}</span>
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