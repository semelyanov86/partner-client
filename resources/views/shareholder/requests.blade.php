@extends('shareholder.layouts.main_app')
@section('page-title') Заявки @endsection
@section('page-content')
    <div class="row d-flex pb-4">
        <div class="col-12 col-md-auto pt-1">
            <a class="btn btn-primary w-100" href=""><i class="ti-pencil-alt"></i> Новая заявка</a>
        </div>

        <div class="col-12 col-md-auto pt-1 ml-md-auto">
            <div class="btn-group w-100" role="group" aria-label="Button group with nested dropdown">
                <button  class="btn btn-outline-primary" id="btnPrint"><i class="ti-printer"></i> Печать</button>
                <div class="btn-group " role="group">
                    <a id="btnGroupDropExport" class="btn btn-primary w-100 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="">
                        <i class="ti-save"></i> Экспорт <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDropExport">
                        <a class="btn dropdown-item" id="btnExport-pdf"> <i class="far fa-file-pdf text-danger"></i>  .PDF</a>
                        <div class="dropdown-divider"></div>
                        <a class="btn dropdown-item" id="btnExport-excel"><i class="far fa-file-excel text-success"></i>  .XLSX</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="form-search">
        <div class="row d-flex">
            <div class="col-md-4">
                <label for="dateToFilter">Дата от</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="mdi mdi-calendar-month"></i></div>
                    </div>
                    <input type="date" class="form-control" id="dateFromFilter" name="dateFromFilter" placeholder="Дата От">
                </div>
            </div>
            <div class="col-md-4">
                <label for="dateToFilter">Дата до</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="mdi mdi-calendar-month"></i></div>
                    </div>
                    <input type="date" class="form-control" id="dateToFilter" name="dateToFilter" placeholder="Дата До">
                </div>
            </div>
            <div class="col-12 col-md-auto ml-md-auto">
                <label for="btn-search" class="invisible">Фильтр</label>
                <div class="input-group mb-2">
                    <button class="btn btn-outline-primary w-100" id="btn-search" type="submit"><i class="mdi mdi-filter-outline"></i>Фильтр</button>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-12 content-table">
            <table class="table table-sm table-striped table-hover w-100" id="requests-table">
                <thead class="table">
                    <th>№</th>
                    <th>Номер заявки</th>
                    <th>Дата заявки</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>id</th>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('custom-scripts')
    @include('shareholder.partials.datatable-scripts')
    <script>
        $(document).ready(function() {
            let table = $('#requests-table').DataTable( {
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend : "pdf",
                        title: "Заявки",
                        pageSize: 'A4',
                        orientation: 'portret',
                        className: "d-none",
                        customize : function(doc){
                            doc.pageMargins = [20,20,20,20];
                            doc.styles.tableHeader.alignment = 'left';
                            doc.content[1].table.widths = ["*","*", "*", "*","*", "*"];
                        }
                    },
                    {
                        extend : "print",
                        title: "Заявки",
                        className: "d-none",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend : "excel",
                        sheetName: 'Лист',
                        title: "Заявки",
                        className: "d-none"
                    }
                ],
                "lengthChange": true,
                "lengthMenu": [[10, 25, 50, 100, 9999999], [10, 25, 50, 100, "Все"]],
                "ordering": false,
                "info":     false,
                "searching" : false,
                "serverSide": true,
                "processing" : true,
                "scrollX": true,
                "ajax": {
                    "url" : "{{route('client.requests.data')}}",
                    "timeout" : 10000,
                    "retries" : 3,
                    "retryInterval" : 1000,
                    "data": function (d) {
                        d.dateFromFilter = $("#dateFromFilter").val();
                        d.dateToFilter = $("#dateToFilter").val();
                    }
                },

                "columns": [
                    { "data": null,"sortable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { "data": "request_no",
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='{{route('client.requests')}}/" + oData.id + "'>"+oData.request_no+"</a>");
                        }
                    },
                    { "data": "request_date",
                        type: 'date',
                        render: function (data, type, row) { return data ? moment(data).format('DD-MM-YYYY') : ''; }
                    },
                    { "data": "amount" },
                    { "data": "status" },
                    {
                        "data": "id",
                        "visible" : false
                    }
                ],
                "language": {
                    "url" : "{{asset('/js/client/datatables/datatables-ru.json')}}"
                }
            } );

            $('#btn-search').on('click', function () {
                table.ajax.reload();
                table.draw();
                $('html, body').animate({
                    scrollTop: parseInt($("#requests-table").offset().top)
                }, 300);
            });

            $('#form-search').on('submit', function () {
                table.ajax.reload();
                table.draw();
                $('html, body').animate({
                    scrollTop: parseInt($("#requests-table").offset().top)
                }, 300);
                return false;
            });

            $('#btnPrint').on('click', function () {
                $('.buttons-print').click();
            });

            $('#btnExport-pdf').on('click', function () {
                $('.buttons-pdf').click();
            });

            $('#btnExport-excel').on('click', function () {
                $('.buttons-excel').click();
            });
        } );
    </script>
@endsection

