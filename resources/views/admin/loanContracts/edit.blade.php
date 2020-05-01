@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.loanContract.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loan-contracts.update", [$loanContract->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shareholder_id">{{ trans('cruds.loanContract.fields.shareholder') }}</label>
                <select class="form-control select2 {{ $errors->has('shareholder') ? 'is-invalid' : '' }}" name="shareholder_id" id="shareholder_id" required>
                    @foreach($shareholders as $id => $shareholder)
                        <option value="{{ $id }}" {{ ($loanContract->shareholder ? $loanContract->shareholder->id : old('shareholder_id')) == $id ? 'selected' : '' }}>{{ $shareholder }}</option>
                    @endforeach
                </select>
                @if($errors->has('shareholder'))
                    <span class="text-danger">{{ $errors->first('shareholder') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.shareholder_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_calculate">{{ trans('cruds.loanContract.fields.date_calculate') }}</label>
                <input class="form-control date {{ $errors->has('date_calculate') ? 'is-invalid' : '' }}" type="text" name="date_calculate" id="date_calculate" value="{{ old('date_calculate', $loanContract->date_calculate) }}" required>
                @if($errors->has('date_calculate'))
                    <span class="text-danger">{{ $errors->first('date_calculate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.date_calculate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="agreement">{{ trans('cruds.loanContract.fields.agreement') }}</label>
                <input class="form-control {{ $errors->has('agreement') ? 'is-invalid' : '' }}" type="text" name="agreement" id="agreement" value="{{ old('agreement', $loanContract->agreement) }}" required>
                @if($errors->has('agreement'))
                    <span class="text-danger">{{ $errors->first('agreement') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.agreement_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_start">{{ trans('cruds.loanContract.fields.date_start') }}</label>
                <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start', $loanContract->date_start) }}" required>
                @if($errors->has('date_start'))
                    <span class="text-danger">{{ $errors->first('date_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.date_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_end">{{ trans('cruds.loanContract.fields.date_end') }}</label>
                <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end', $loanContract->date_end) }}" required>
                @if($errors->has('date_end'))
                    <span class="text-danger">{{ $errors->first('date_end') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.date_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.loanContract.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $loanContract->amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="percent">{{ trans('cruds.loanContract.fields.percent') }}</label>
                <input class="form-control {{ $errors->has('percent') ? 'is-invalid' : '' }}" type="number" name="percent" id="percent" value="{{ old('percent', $loanContract->percent) }}" step="0.01" required min="1" max="90">
                @if($errors->has('percent'))
                    <span class="text-danger">{{ $errors->first('percent') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.percent_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mem_fee">{{ trans('cruds.loanContract.fields.mem_fee') }}</label>
                <input class="form-control {{ $errors->has('mem_fee') ? 'is-invalid' : '' }}" type="number" name="mem_fee" id="mem_fee" value="{{ old('mem_fee', $loanContract->mem_fee) }}" step="0.01" required>
                @if($errors->has('mem_fee'))
                    <span class="text-danger">{{ $errors->first('mem_fee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.mem_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="actual_debt">{{ trans('cruds.loanContract.fields.actual_debt') }}</label>
                <input class="form-control {{ $errors->has('actual_debt') ? 'is-invalid' : '' }}" type="number" name="actual_debt" id="actual_debt" value="{{ old('actual_debt', $loanContract->actual_debt) }}" step="0.01">
                @if($errors->has('actual_debt'))
                    <span class="text-danger">{{ $errors->first('actual_debt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.actual_debt_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="full_debt">{{ trans('cruds.loanContract.fields.full_debt') }}</label>
                <input class="form-control {{ $errors->has('full_debt') ? 'is-invalid' : '' }}" type="number" name="full_debt" id="full_debt" value="{{ old('full_debt', $loanContract->full_debt) }}" step="0.01">
                @if($errors->has('full_debt'))
                    <span class="text-danger">{{ $errors->first('full_debt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.full_debt_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_open') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_open" value="0">
                    <input class="form-check-input" type="checkbox" name="is_open" id="is_open" value="1" {{ $loanContract->is_open || old('is_open', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_open">{{ trans('cruds.loanContract.fields.is_open') }}</label>
                </div>
                @if($errors->has('is_open'))
                    <span class="text-danger">{{ $errors->first('is_open') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanContract.fields.is_open_helper') }}</span>
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