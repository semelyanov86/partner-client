@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.loanMemfeeSchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loan-memfee-schedules.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="shareholder_id">{{ trans('cruds.loanMemfeeSchedule.fields.shareholder') }}</label>
                <select class="form-control select2 {{ $errors->has('shareholder') ? 'is-invalid' : '' }}" name="shareholder_id" id="shareholder_id" required>
                    @foreach($shareholders as $id => $shareholder)
                        <option value="{{ $id }}" {{ old('shareholder_id') == $id ? 'selected' : '' }}>{{ $shareholder }}</option>
                    @endforeach
                </select>
                @if($errors->has('shareholder'))
                    <span class="text-danger">{{ $errors->first('shareholder') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMemfeeSchedule.fields.shareholder_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="loan_id">{{ trans('cruds.loanMemfeeSchedule.fields.loan') }}</label>
                <select class="form-control select2 {{ $errors->has('loan') ? 'is-invalid' : '' }}" name="loan_id" id="loan_id" required>
                    @foreach($loans as $id => $loan)
                        <option value="{{ $id }}" {{ old('loan_id') == $id ? 'selected' : '' }}>{{ $loan }}</option>
                    @endforeach
                </select>
                @if($errors->has('loan'))
                    <span class="text-danger">{{ $errors->first('loan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMemfeeSchedule.fields.loan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_plan">{{ trans('cruds.loanMemfeeSchedule.fields.date_plan') }}</label>
                <input class="form-control date {{ $errors->has('date_plan') ? 'is-invalid' : '' }}" type="text" name="date_plan" id="date_plan" value="{{ old('date_plan') }}" required>
                @if($errors->has('date_plan'))
                    <span class="text-danger">{{ $errors->first('date_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMemfeeSchedule.fields.date_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mem_fee_plan">{{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_plan') }}</label>
                <input class="form-control {{ $errors->has('mem_fee_plan') ? 'is-invalid' : '' }}" type="number" name="mem_fee_plan" id="mem_fee_plan" value="{{ old('mem_fee_plan', '') }}" step="0.01" required>
                @if($errors->has('mem_fee_plan'))
                    <span class="text-danger">{{ $errors->first('mem_fee_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mem_fee_fact">{{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_fact') }}</label>
                <input class="form-control {{ $errors->has('mem_fee_fact') ? 'is-invalid' : '' }}" type="number" name="mem_fee_fact" id="mem_fee_fact" value="{{ old('mem_fee_fact', '') }}" step="0.01" required>
                @if($errors->has('mem_fee_fact'))
                    <span class="text-danger">{{ $errors->first('mem_fee_fact') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_fact_helper') }}</span>
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