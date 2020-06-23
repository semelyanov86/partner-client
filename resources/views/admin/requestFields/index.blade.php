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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-RequestField">
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
                            {{ trans('cruds.requestField.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.requestField.fields.placeholder') }}
                        </th>
                        <th>
                            {{ trans('cruds.requestField.fields.required') }}
                        </th>
                        <th>
                            {{ trans('cruds.requestField.fields.type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requestFields as $key => $requestField)
                        <tr data-entry-id="{{ $requestField->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $requestField->id ?? '' }}
                            </td>
                            <td>
                                {{ $requestField->no ?? '' }}
                            </td>
                            <td>
                                {{ $requestField->key ?? '' }}
                            </td>
                            <td>
                                {{ $requestField->title ?? '' }}
                            </td>
                            <td>
                                {{ $requestField->placeholder ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $requestField->required ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $requestField->required ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ App\RequestField::TYPE_SELECT[$requestField->type] ?? '' }}
                            </td>
                            <td>
                                @can('request_field_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.request-fields.show', $requestField->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('request_field_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.request-fields.edit', $requestField->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('request_field_delete')
                                    <form action="{{ route('admin.request-fields.destroy', $requestField->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('request_field_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.request-fields.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-RequestField:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection