@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.depositContract.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.deposit-contracts.update", [$depositContract->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shareholder_id">{{ trans('cruds.depositContract.fields.shareholder') }}</label>
                <select class="form-control select2 {{ $errors->has('shareholder') ? 'is-invalid' : '' }}" name="shareholder_id" id="shareholder_id" required>
                    @foreach($shareholders as $id => $shareholder)
                        <option value="{{ $id }}" {{ ($depositContract->shareholder ? $depositContract->shareholder->id : old('shareholder_id')) == $id ? 'selected' : '' }}>{{ $shareholder }}</option>
                    @endforeach
                </select>
                @if($errors->has('shareholder'))
                    <span class="text-danger">{{ $errors->first('shareholder') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositContract.fields.shareholder_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_calculate">{{ trans('cruds.depositContract.fields.date_calculate') }}</label>
                <input class="form-control date {{ $errors->has('date_calculate') ? 'is-invalid' : '' }}" type="text" name="date_calculate" id="date_calculate" value="{{ old('date_calculate', $depositContract->date_calculate) }}" required>
                @if($errors->has('date_calculate'))
                    <span class="text-danger">{{ $errors->first('date_calculate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositContract.fields.date_calculate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="agreement">{{ trans('cruds.depositContract.fields.agreement') }}</label>
                <input class="form-control {{ $errors->has('agreement') ? 'is-invalid' : '' }}" type="text" name="agreement" id="agreement" value="{{ old('agreement', $depositContract->agreement) }}" required>
                @if($errors->has('agreement'))
                    <span class="text-danger">{{ $errors->first('agreement') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositContract.fields.agreement_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_start">{{ trans('cruds.depositContract.fields.date_start') }}</label>
                <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start', $depositContract->date_start) }}" required>
                @if($errors->has('date_start'))
                    <span class="text-danger">{{ $errors->first('date_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositContract.fields.date_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_end">{{ trans('cruds.depositContract.fields.date_end') }}</label>
                <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end', $depositContract->date_end) }}" required>
                @if($errors->has('date_end'))
                    <span class="text-danger">{{ $errors->first('date_end') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositContract.fields.date_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="percent">{{ trans('cruds.depositContract.fields.percent') }}</label>
                <input class="form-control {{ $errors->has('percent') ? 'is-invalid' : '' }}" type="number" name="percent" id="percent" value="{{ old('percent', $depositContract->percent) }}" step="0.01" required max="100">
                @if($errors->has('percent'))
                    <span class="text-danger">{{ $errors->first('percent') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositContract.fields.percent_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_open') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_open" value="0">
                    <input class="form-check-input" type="checkbox" name="is_open" id="is_open" value="1" {{ $depositContract->is_open || old('is_open', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_open">{{ trans('cruds.depositContract.fields.is_open') }}</label>
                </div>
                @if($errors->has('is_open'))
                    <span class="text-danger">{{ $errors->first('is_open') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositContract.fields.is_open_helper') }}</span>
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