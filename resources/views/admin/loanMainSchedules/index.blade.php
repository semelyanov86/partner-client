@extends('layouts.admin')
@section('content')
@can('loan_main_schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.loan-main-schedules.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.loanMainSchedule.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.loanMainSchedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-LoanMainSchedule">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.shareholder') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.loan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.date_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.date_fact') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.period') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.days') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.main_amt_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.main_amt_fact') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.main_amt_debt_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.main_amt_debt_fact') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.percent_amt_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.percent_amt_fact') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.fee_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMainSchedule.fields.fee_fact') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('loan_main_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-main-schedules.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.loan-main-schedules.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'shareholder_fio', name: 'shareholder.fio' },
{ data: 'loan_agreement', name: 'loan.agreement' },
{ data: 'date_plan', name: 'date_plan' },
{ data: 'date_fact', name: 'date_fact' },
{ data: 'period', name: 'period' },
{ data: 'days', name: 'days' },
{ data: 'main_amt_plan', name: 'main_amt_plan' },
{ data: 'main_amt_fact', name: 'main_amt_fact' },
{ data: 'main_amt_debt_plan', name: 'main_amt_debt_plan' },
{ data: 'main_amt_debt_fact', name: 'main_amt_debt_fact' },
{ data: 'percent_amt_plan', name: 'percent_amt_plan' },
{ data: 'percent_amt_fact', name: 'percent_amt_fact' },
{ data: 'fee_plan', name: 'fee_plan' },
{ data: 'fee_fact', name: 'fee_fact' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 50,
  };
  let table = $('.datatable-LoanMainSchedule').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection