@extends('layouts.admin')
@section('content')
@can('deposit_contract_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.deposit-contracts.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.depositContract.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.depositContract.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-DepositContract">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.shareholder') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.date_calculate') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.agreement') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.date_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.date_end') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.percent') }}
                    </th>
                    <th>
                        {{ trans('cruds.depositContract.fields.is_open') }}
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
@can('deposit_contract_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.deposit-contracts.massDestroy') }}",
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
    ajax: "{{ route('admin.deposit-contracts.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'shareholder_fio', name: 'shareholder.fio' },
{ data: 'date_calculate', name: 'date_calculate' },
{ data: 'agreement', name: 'agreement' },
{ data: 'date_start', name: 'date_start' },
{ data: 'date_end', name: 'date_end' },
{ data: 'percent', name: 'percent' },
{ data: 'is_open', name: 'is_open' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  $('.datatable-DepositContract').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection