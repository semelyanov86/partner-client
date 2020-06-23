<div class="m-3">
    @can('loan_contract_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.loan-contracts.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.loanContract.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.loanContract.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-shareholderLoanContracts">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.shareholder') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.date_calculate') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.agreement') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.date_start') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.date_end') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.percent') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.mem_fee') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.actual_debt') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.full_debt') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanContract.fields.is_open') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loanContracts as $key => $loanContract)
                            <tr data-entry-id="{{ $loanContract->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $loanContract->id ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->shareholder->fio ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->date_calculate ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->agreement ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->date_start ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->date_end ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->amount ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->percent ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->mem_fee ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->actual_debt ?? '' }}
                                </td>
                                <td>
                                    {{ $loanContract->full_debt ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $loanContract->is_open ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $loanContract->is_open ? 'checked' : '' }}>
                                </td>
                                <td>
                                    @can('loan_contract_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-contracts.show', $loanContract->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('loan_contract_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.loan-contracts.edit', $loanContract->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('loan_contract_delete')
                                        <form action="{{ route('admin.loan-contracts.destroy', $loanContract->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('loan_contract_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-contracts.massDestroy') }}",
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
  let table = $('.datatable-shareholderLoanContracts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection