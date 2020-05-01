@extends('layouts.admin')
@section('content')
@can('deposit_schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.deposit-schedules.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.depositSchedule.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.depositSchedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-DepositSchedule">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.deposit') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.shareholder') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.date_plan') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.date_fact') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.days') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.main_amt_debt') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.main_amt_fact') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.ndfl_amt') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositSchedule.fields.percent_available') }}
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
@can('deposit_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.deposit-schedules.massDestroy') }}",
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
    ajax: "{{ route('admin.deposit-schedules.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'deposit_agreement', name: 'deposit.agreement' },
{ data: 'shareholder_fio', name: 'shareholder.fio' },
{ data: 'date_plan', name: 'date_plan' },
{ data: 'date_fact', name: 'date_fact' },
{ data: 'days', name: 'days' },
{ data: 'main_amt_debt', name: 'main_amt_debt' },
{ data: 'main_amt_fact', name: 'main_amt_fact' },
{ data: 'ndfl_amt', name: 'ndfl_amt' },
{ data: 'percent_available', name: 'percent_available' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  $('.datatable-DepositSchedule').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection