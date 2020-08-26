<div class="m-3">
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
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-depositDepositSchedules">
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
                    <tbody>
                        @foreach($depositSchedules as $key => $depositSchedule)
                            <tr data-entry-id="{{ $depositSchedule->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $depositSchedule->id ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->deposit->agreement ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->shareholder->fio ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->date_plan ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->date_fact ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->days ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->main_amt_debt ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->main_amt_fact ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->ndfl_amt ?? '' }}
                                </td>
                                <td>
                                    {{ $depositSchedule->percent_available ?? '' }}
                                </td>
                                <td>
                                    @can('deposit_schedule_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.deposit-schedules.show', $depositSchedule->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('deposit_schedule_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.deposit-schedules.edit', $depositSchedule->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('deposit_schedule_delete')
                                        <form action="{{ route('admin.deposit-schedules.destroy', $depositSchedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('deposit_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.deposit-schedules.massDestroy') }}",
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
  $('.datatable-depositDepositSchedules:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection