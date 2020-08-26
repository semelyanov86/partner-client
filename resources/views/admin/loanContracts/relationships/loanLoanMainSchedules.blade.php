<div class="m-3">
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
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-loanLoanMainSchedules">
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
                    <tbody>
                        @foreach($loanMainSchedules as $key => $loanMainSchedule)
                            <tr data-entry-id="{{ $loanMainSchedule->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $loanMainSchedule->id ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->shareholder->fio ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->loan->agreement ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->date_plan ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->date_fact ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->period ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->days ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->main_amt_plan ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->main_amt_fact ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->main_amt_debt_plan ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->main_amt_debt_fact ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->percent_amt_plan ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->percent_amt_fact ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->fee_plan ?? '' }}
                                </td>
                                <td>
                                    {{ $loanMainSchedule->fee_fact ?? '' }}
                                </td>
                                <td>
                                    @can('loan_main_schedule_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-main-schedules.show', $loanMainSchedule->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('loan_main_schedule_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.loan-main-schedules.edit', $loanMainSchedule->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('loan_main_schedule_delete')
                                        <form action="{{ route('admin.loan-main-schedules.destroy', $loanMainSchedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('loan_main_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-main-schedules.massDestroy') }}",
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
    pageLength: 50,
  });
  let table = $('.datatable-loanLoanMainSchedules:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection