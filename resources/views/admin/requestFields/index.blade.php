@extends('layouts.admin')
@section('content')
@can('request_field_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.request-fields.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.requestField.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.requestField.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-RequestField">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.no') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.key') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.placeholder') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.required') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.personal_data') }}
                    </th>
                    <th>
                        {{ trans('cruds.requestField.fields.read_only') }}
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
@can('request_field_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.request-fields.massDestroy') }}",
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
    ajax: "{{ route('admin.request-fields.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder', "visible" : false },
{ data: 'id', name: 'id' },
{ data: 'no', name: 'no' },
{ data: 'key', name: 'key' },
{ data: 'type', name: 'type' },
{ data: 'title', name: 'title' },
{ data: 'placeholder', name: 'placeholder' },
{ data: 'required', name: 'required' },
{ data: 'personal_data', name: 'personal_data' },
{ data: 'read_only', name: 'read_only' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 2, 'asc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-RequestField').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
