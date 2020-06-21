@extends('shareholder.layouts.main_app')
@section('page-title') Договора сбережений @endsection
@section('page-content')

    <div class="row d-flex pb-4">
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
            <div class="col-md-3">
                <label for="dateToFilter">Дата от</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="mdi mdi-calendar-month"></i></div>
                    </div>
                    <input type="date" class="form-control" id="dateFromFilter" name="dateFromFilter" placeholder="Дата От">
                </div>
            </div>
            <div class="col-md-3">
                <label for="dateToFilter">Дата до</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="mdi mdi-calendar-month"></i></div>
                    </div>
                    <input type="date" class="form-control" id="dateToFilter" name="dateToFilter" placeholder="Дата До">
                </div>
            </div>
            <div class="col-12 col-md-auto text-center text-md-right">
                <label for="isOpen" >Только открытые</label>
                <div class="checkbox checkbox-primary">
                    <input id="isOpen" name="isOpen" type="checkbox" unchecked>
                    <label for="isOpen"></label>
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
            <table class="table table-sm table-striped table-hover w-100" id="loans-table">
                <thead class="table">
                    <th>№</th>
                    <th>Номер договора</th>
                    <th>Дата договора</th>
                    <th>Сумма</th>
                    <th>Договор открыт</th>
                    <th>id</th>
                    <th></th>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('custom-scripts')
    @include('shareholder.partials.datatable-scripts')
    <script>
        $(document).ready(function() {
            let table = $('#loans-table').DataTable( {
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend : "pdf",
                        title: "Договора сбережений",
                        pageSize: 'A4',
                        orientation: 'portret',
                        className: "d-none",
                        customize : function(doc){
                            doc.pageMargins = [20,20,20,20];
                            doc.styles.tableHeader.alignment = 'left';
                            doc.content[1].table.widths = ["*","*", "*", "*","*", "*"];
                        },
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4],
                            orthogonal: "myExport"
                        }
                    },
                    {
                        extend : "print",
                        title: "Договора сбережений",
                        className: "d-none",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4],
                            orthogonal: "myExport"
                        }
                    },
                    {
                        extend : "excel",
                        sheetName: 'Лист',
                        title: "Договора сбережений",
                        className: "d-none",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4],
                            orthogonal: "myExport"
                        }

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
                    "url" : "{{route('client.deposits.data')}}",
                    "timeout" : 10000,
                    "retries" : 3,
                    "retryInterval" : 1000,
                    "data": function (d) {
                        d.dateFromFilter = $("#dateFromFilter").val();
                        d.dateToFilter = $("#dateToFilter").val();
                        d.isOpen = $("#isOpen").prop('checked');
                    }
                },

                "columns": [
                    { "data": null,"sortable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { "data": "agreement",
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='{{route('client.deposits')}}/" + oData.id + "'>"+oData.agreement+"</a>");
                        }
                    },
                    { "data": "date_start",
                        type: 'date',
                        render: function (data, type, row) { return data ? moment(data).format('DD-MM-YYYY') : ''; }
                    },
                    { "data": "amount" },
                    {
                        "data": "is_open",
                        render: function ( data, type, row ) {
                            if (type === 'myExport') {
                                return data === 1 ? "Да" : "Нет";
                            }
                            if ( type === 'display' ) {
                                let checked = 'unchecked';
                                if (data === 1)
                                    checked = 'checked';
                                else
                                    checked = 'unchecked';
                                return '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" disabled '+checked+'> <label></label></div>';
                            }
                            return data;
                        },
                        className: "dt-body-center text-center"
                    },
                    {
                        "data": "id",
                        "visible" : false
                    },
                    {
                        "data": null,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a class='btn btn-icon btn-teal px-2 py-1' href='{{route('client.deposits')}}/" + oData.id + "'><i class='ti-search'></i></a>");
                        }
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
                    scrollTop: parseInt($("#loans-table").offset().top)
                }, 300);
            });

            $('#form-search').on('submit', function () {
                table.ajax.reload();
                table.draw();
                $('html, body').animate({
                    scrollTop: parseInt($("#loans-table").offset().top)
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

