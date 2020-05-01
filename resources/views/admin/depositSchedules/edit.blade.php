@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.depositSchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.deposit-schedules.update", [$depositSchedule->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="deposit_id">{{ trans('cruds.depositSchedule.fields.deposit') }}</label>
                <select class="form-control select2 {{ $errors->has('deposit') ? 'is-invalid' : '' }}" name="deposit_id" id="deposit_id" required>
                    @foreach($deposits as $id => $deposit)
                        <option value="{{ $id }}" {{ ($depositSchedule->deposit ? $depositSchedule->deposit->id : old('deposit_id')) == $id ? 'selected' : '' }}>{{ $deposit }}</option>
                    @endforeach
                </select>
                @if($errors->has('deposit'))
                    <span class="text-danger">{{ $errors->first('deposit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.deposit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="shareholder_id">{{ trans('cruds.depositSchedule.fields.shareholder') }}</label>
                <select class="form-control select2 {{ $errors->has('shareholder') ? 'is-invalid' : '' }}" name="shareholder_id" id="shareholder_id">
                    @foreach($shareholders as $id => $shareholder)
                        <option value="{{ $id }}" {{ ($depositSchedule->shareholder ? $depositSchedule->shareholder->id : old('shareholder_id')) == $id ? 'selected' : '' }}>{{ $shareholder }}</option>
                    @endforeach
                </select>
                @if($errors->has('shareholder'))
                    <span class="text-danger">{{ $errors->first('shareholder') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.shareholder_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_plan">{{ trans('cruds.depositSchedule.fields.date_plan') }}</label>
                <input class="form-control date {{ $errors->has('date_plan') ? 'is-invalid' : '' }}" type="text" name="date_plan" id="date_plan" value="{{ old('date_plan', $depositSchedule->date_plan) }}" required>
                @if($errors->has('date_plan'))
                    <span class="text-danger">{{ $errors->first('date_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.date_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_fact">{{ trans('cruds.depositSchedule.fields.date_fact') }}</label>
                <input class="form-control date {{ $errors->has('date_fact') ? 'is-invalid' : '' }}" type="text" name="date_fact" id="date_fact" value="{{ old('date_fact', $depositSchedule->date_fact) }}">
                @if($errors->has('date_fact'))
                    <span class="text-danger">{{ $errors->first('date_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.date_fact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="period">{{ trans('cruds.depositSchedule.fields.period') }}</label>
                <input class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" type="text" name="period" id="period" value="{{ old('period', $depositSchedule->period) }}">
                @if($errors->has('period'))
                    <span class="text-danger">{{ $errors->first('period') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.period_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="days">{{ trans('cruds.depositSchedule.fields.days') }}</label>
                <input class="form-control {{ $errors->has('days') ? 'is-invalid' : '' }}" type="number" name="days" id="days" value="{{ old('days', $depositSchedule->days) }}" step="1">
                @if($errors->has('days'))
                    <span class="text-danger">{{ $errors->first('days') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.days_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="main_amt_debt">{{ trans('cruds.depositSchedule.fields.main_amt_debt') }}</label>
                <input class="form-control {{ $errors->has('main_amt_debt') ? 'is-invalid' : '' }}" type="number" name="main_amt_debt" id="main_amt_debt" value="{{ old('main_amt_debt', $depositSchedule->main_amt_debt) }}" step="0.01" required>
                @if($errors->has('main_amt_debt'))
                    <span class="text-danger">{{ $errors->first('main_amt_debt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.main_amt_debt_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="main_amt_fact">{{ trans('cruds.depositSchedule.fields.main_amt_fact') }}</label>
                <input class="form-control {{ $errors->has('main_amt_fact') ? 'is-invalid' : '' }}" type="text" name="main_amt_fact" id="main_amt_fact" value="{{ old('main_amt_fact', $depositSchedule->main_amt_fact) }}" required>
                @if($errors->has('main_amt_fact'))
                    <span class="text-danger">{{ $errors->first('main_amt_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.main_amt_fact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ndfl_amt">{{ trans('cruds.depositSchedule.fields.ndfl_amt') }}</label>
                <input class="form-control {{ $errors->has('ndfl_amt') ? 'is-invalid' : '' }}" type="number" name="ndfl_amt" id="ndfl_amt" value="{{ old('ndfl_amt', $depositSchedule->ndfl_amt) }}" step="0.01">
                @if($errors->has('ndfl_amt'))
                    <span class="text-danger">{{ $errors->first('ndfl_amt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.ndfl_amt_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="percent_available">{{ trans('cruds.depositSchedule.fields.percent_available') }}</label>
                <input class="form-control {{ $errors->has('percent_available') ? 'is-invalid' : '' }}" type="number" name="percent_available" id="percent_available" value="{{ old('percent_available', $depositSchedule->percent_available) }}" step="0.01">
                @if($errors->has('percent_available'))
                    <span class="text-danger">{{ $errors->first('percent_available') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.depositSchedule.fields.percent_available_helper') }}</span>
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