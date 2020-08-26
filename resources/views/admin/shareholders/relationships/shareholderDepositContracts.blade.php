<div class="m-3">
    @can('deposit_contract_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.deposit-contracts.create') }}">
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
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-shareholderDepositContracts">
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
                    <tbody>
                        @foreach($depositContracts as $key => $depositContract)
                            <tr data-entry-id="{{ $depositContract->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $depositContract->id ?? '' }}
                                </td>
                                <td>
                                    {{ $depositContract->shareholder->fio ?? '' }}
                                </td>
                                <td>
                                    {{ $depositContract->date_calculate ?? '' }}
                                </td>
                                <td>
                                    {{ $depositContract->agreement ?? '' }}
                                </td>
                                <td>
                                    {{ $depositContract->date_start ?? '' }}
                                </td>
                                <td>
                                    {{ $depositContract->date_end ?? '' }}
                                </td>
                                <td>
                                    {{ $depositContract->percent ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $depositContract->is_open ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $depositContract->is_open ? 'checked' : '' }}>
                                </td>
                                <td>
                                    @can('deposit_contract_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.deposit-contracts.show', $depositContract->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('deposit_contract_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.deposit-contracts.edit', $depositContract->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('deposit_contract_delete')
                                        <form action="{{ route('admin.deposit-contracts.destroy', $depositContract->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            @method('DELETE')
                                            @csrf
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
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('deposit_contract_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.deposit-contracts.massDestroy') }}",
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
  let table = $('.datatable-shareholderDepositContracts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection