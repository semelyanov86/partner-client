@extends('layouts.admin')
@section('content')
@can('loan_memfee_schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.loan-memfee-schedules.create") }}">
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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LoanMemfeeSchedule">
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
                <tbody>
                    @foreach($loanMemfeeSchedules as $key => $loanMemfeeSchedule)
                        <tr data-entry-id="{{ $loanMemfeeSchedule->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $loanMemfeeSchedule->id ?? '' }}
                            </td>
                            <td>
                                {{ $loanMemfeeSchedule->shareholder->fio ?? '' }}
                            </td>
                            <td>
                                {{ $loanMemfeeSchedule->loan->agreement ?? '' }}
                            </td>
                            <td>
                                {{ $loanMemfeeSchedule->date_plan ?? '' }}
                            </td>
                            <td>
                                {{ $loanMemfeeSchedule->mem_fee_plan ?? '' }}
                            </td>
                            <td>
                                {{ $loanMemfeeSchedule->mem_fee_fact ?? '' }}
                            </td>
                            <td>
                                @can('loan_memfee_schedule_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-memfee-schedules.show', $loanMemfeeSchedule->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('loan_memfee_schedule_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.loan-memfee-schedules.edit', $loanMemfeeSchedule->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('loan_memfee_schedule_delete')
                                    <form action="{{ route('admin.loan-memfee-schedules.destroy', $loanMemfeeSchedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('loan_memfee_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-memfee-schedules.massDestroy') }}",
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
  $('.datatable-LoanMemfeeSchedule:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection