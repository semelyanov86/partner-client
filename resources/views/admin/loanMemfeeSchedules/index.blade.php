@extends('layouts.admin')
@section('content')
@can('loan_memfee_schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.loan-memfee-schedules.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.loanMemfeeSchedule.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.loanMemfeeSchedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-LoanMemfeeSchedule">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.loanMemfeeSchedule.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMemfeeSchedule.fields.shareholder') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMemfeeSchedule.fields.loan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMemfeeSchedule.fields.date_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.loanMemfeeSchedule.fields.mem_fee_fact') }}
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
@can('loan_memfee_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-memfee-schedules.massDestroy') }}",
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
    ajax: "{{ route('admin.loan-memfee-schedules.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'shareholder_fio', name: 'shareholder.fio' },
{ data: 'loan_agreement', name: 'loan.agreement' },
{ data: 'date_plan', name: 'date_plan' },
{ data: 'mem_fee_plan', name: 'mem_fee_plan' },
{ data: 'mem_fee_fact', name: 'mem_fee_fact' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 50,
  };
  let table = $('.datatable-LoanMemfeeSchedule').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection