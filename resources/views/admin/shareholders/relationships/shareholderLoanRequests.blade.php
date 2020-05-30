<div class="m-3">
    @can('loan_request_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.loan-requests.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.loanRequest.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.loanRequest.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-shareholderLoanRequests">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.loanRequest.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanRequest.fields.shareholder') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanRequest.fields.request_no') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanRequest.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanRequest.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanRequest.fields.request_date') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loanRequests as $key => $loanRequest)
                            <tr data-entry-id="{{ $loanRequest->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $loanRequest->id ?? '' }}
                                </td>
                                <td>
                                    {{ $loanRequest->shareholder->fio ?? '' }}
                                </td>
                                <td>
                                    {{ $loanRequest->request_no ?? '' }}
                                </td>
                                <td>
                                    {{ $loanRequest->amount ?? '' }}
                                </td>
                                <td>
                                    {{ $loanRequest->status ?? '' }}
                                </td>
                                <td>
                                    {{ $loanRequest->request_date ?? '' }}
                                </td>
                                <td>
                                    @can('loan_request_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-requests.show', $loanRequest->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('loan_request_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.loan-requests.edit', $loanRequest->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('loan_request_delete')
                                        <form action="{{ route('admin.loan-requests.destroy', $loanRequest->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('loan_request_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-requests.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-shareholderLoanRequests:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection