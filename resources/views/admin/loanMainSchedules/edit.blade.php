@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.loanMainSchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loan-main-schedules.update", [$loanMainSchedule->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="shareholder_id">{{ trans('cruds.loanMainSchedule.fields.shareholder') }}</label>
                <select class="form-control select2 {{ $errors->has('shareholder') ? 'is-invalid' : '' }}" name="shareholder_id" id="shareholder_id" required>
                    @foreach($shareholders as $id => $shareholder)
                        <option value="{{ $id }}" {{ ($loanMainSchedule->shareholder ? $loanMainSchedule->shareholder->id : old('shareholder_id')) == $id ? 'selected' : '' }}>{{ $shareholder }}</option>
                    @endforeach
                </select>
                @if($errors->has('shareholder'))
                    <span class="text-danger">{{ $errors->first('shareholder') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.shareholder_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="loan_id">{{ trans('cruds.loanMainSchedule.fields.loan') }}</label>
                <select class="form-control select2 {{ $errors->has('loan') ? 'is-invalid' : '' }}" name="loan_id" id="loan_id" required>
                    @foreach($loans as $id => $loan)
                        <option value="{{ $id }}" {{ ($loanMainSchedule->loan ? $loanMainSchedule->loan->id : old('loan_id')) == $id ? 'selected' : '' }}>{{ $loan }}</option>
                    @endforeach
                </select>
                @if($errors->has('loan'))
                    <span class="text-danger">{{ $errors->first('loan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.loan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_plan">{{ trans('cruds.loanMainSchedule.fields.date_plan') }}</label>
                <input class="form-control date {{ $errors->has('date_plan') ? 'is-invalid' : '' }}" type="text" name="date_plan" id="date_plan" value="{{ old('date_plan', $loanMainSchedule->date_plan) }}" required>
                @if($errors->has('date_plan'))
                    <span class="text-danger">{{ $errors->first('date_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.date_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_fact">{{ trans('cruds.loanMainSchedule.fields.date_fact') }}</label>
                <input class="form-control date {{ $errors->has('date_fact') ? 'is-invalid' : '' }}" type="text" name="date_fact" id="date_fact" value="{{ old('date_fact', $loanMainSchedule->date_fact) }}" required>
                @if($errors->has('date_fact'))
                    <span class="text-danger">{{ $errors->first('date_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.date_fact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="period">{{ trans('cruds.loanMainSchedule.fields.period') }}</label>
                <input class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" type="text" name="period" id="period" value="{{ old('period', $loanMainSchedule->period) }}">
                @if($errors->has('period'))
                    <span class="text-danger">{{ $errors->first('period') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.period_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="days">{{ trans('cruds.loanMainSchedule.fields.days') }}</label>
                <input class="form-control {{ $errors->has('days') ? 'is-invalid' : '' }}" type="number" name="days" id="days" value="{{ old('days', $loanMainSchedule->days) }}" step="1">
                @if($errors->has('days'))
                    <span class="text-danger">{{ $errors->first('days') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.days_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="main_amt_plan">{{ trans('cruds.loanMainSchedule.fields.main_amt_plan') }}</label>
                <input class="form-control {{ $errors->has('main_amt_plan') ? 'is-invalid' : '' }}" type="number" name="main_amt_plan" id="main_amt_plan" value="{{ old('main_amt_plan', $loanMainSchedule->main_amt_plan) }}" step="0.01">
                @if($errors->has('main_amt_plan'))
                    <span class="text-danger">{{ $errors->first('main_amt_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.main_amt_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="main_amt_fact">{{ trans('cruds.loanMainSchedule.fields.main_amt_fact') }}</label>
                <input class="form-control {{ $errors->has('main_amt_fact') ? 'is-invalid' : '' }}" type="number" name="main_amt_fact" id="main_amt_fact" value="{{ old('main_amt_fact', $loanMainSchedule->main_amt_fact) }}" step="0.01">
                @if($errors->has('main_amt_fact'))
                    <span class="text-danger">{{ $errors->first('main_amt_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.main_amt_fact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="main_amt_debt_plan">{{ trans('cruds.loanMainSchedule.fields.main_amt_debt_plan') }}</label>
                <input class="form-control {{ $errors->has('main_amt_debt_plan') ? 'is-invalid' : '' }}" type="number" name="main_amt_debt_plan" id="main_amt_debt_plan" value="{{ old('main_amt_debt_plan', $loanMainSchedule->main_amt_debt_plan) }}" step="0.01">
                @if($errors->has('main_amt_debt_plan'))
                    <span class="text-danger">{{ $errors->first('main_amt_debt_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.main_amt_debt_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="main_amt_debt_fact">{{ trans('cruds.loanMainSchedule.fields.main_amt_debt_fact') }}</label>
                <input class="form-control {{ $errors->has('main_amt_debt_fact') ? 'is-invalid' : '' }}" type="number" name="main_amt_debt_fact" id="main_amt_debt_fact" value="{{ old('main_amt_debt_fact', $loanMainSchedule->main_amt_debt_fact) }}" step="0.01">
                @if($errors->has('main_amt_debt_fact'))
                    <span class="text-danger">{{ $errors->first('main_amt_debt_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.main_amt_debt_fact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="percent_amt_plan">{{ trans('cruds.loanMainSchedule.fields.percent_amt_plan') }}</label>
                <input class="form-control {{ $errors->has('percent_amt_plan') ? 'is-invalid' : '' }}" type="number" name="percent_amt_plan" id="percent_amt_plan" value="{{ old('percent_amt_plan', $loanMainSchedule->percent_amt_plan) }}" step="0.01">
                @if($errors->has('percent_amt_plan'))
                    <span class="text-danger">{{ $errors->first('percent_amt_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.percent_amt_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="percent_amt_fact">{{ trans('cruds.loanMainSchedule.fields.percent_amt_fact') }}</label>
                <input class="form-control {{ $errors->has('percent_amt_fact') ? 'is-invalid' : '' }}" type="number" name="percent_amt_fact" id="percent_amt_fact" value="{{ old('percent_amt_fact', $loanMainSchedule->percent_amt_fact) }}" step="0.01">
                @if($errors->has('percent_amt_fact'))
                    <span class="text-danger">{{ $errors->first('percent_amt_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.percent_amt_fact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fee_plan">{{ trans('cruds.loanMainSchedule.fields.fee_plan') }}</label>
                <input class="form-control {{ $errors->has('fee_plan') ? 'is-invalid' : '' }}" type="number" name="fee_plan" id="fee_plan" value="{{ old('fee_plan', $loanMainSchedule->fee_plan) }}" step="0.01">
                @if($errors->has('fee_plan'))
                    <span class="text-danger">{{ $errors->first('fee_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.fee_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fee_fact">{{ trans('cruds.loanMainSchedule.fields.fee_fact') }}</label>
                <input class="form-control {{ $errors->has('fee_fact') ? 'is-invalid' : '' }}" type="number" name="fee_fact" id="fee_fact" value="{{ old('fee_fact', $loanMainSchedule->fee_fact) }}" step="0.01">
                @if($errors->has('fee_fact'))
                    <span class="text-danger">{{ $errors->first('fee_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMainSchedule.fields.fee_fact_helper') }}</span>
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