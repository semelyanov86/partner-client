@extends('shareholder.layouts.main_app')
@section('page-title') Кредитный калькулятор @endsection
@section('page-content')
    <div>
        <p><b>Сумма займа:</b> от 1 000 до 30 000 рублей</p>
        <p><b>Срок займа:</b> от 2 до 10 месяцев</p>
        <p><b>Процентная ставка:</b> от 39,2% до 44% годовых от остатка суммы займа.</p>
        <p> *Членский взнос оплачивается ежемесячно от вида договора (1,1% от суммы займа в месяц за время пользования), при получении займа оплачивается единовременный членский взнос  в фонд развития (0,15% от суммы займа умноженное на кол-во месяцев займа).</p>
    </div>
    <form id="form-calc">
        <div class="row d-flex justify-content-between">
            <div class="col-md-auto col-xl-4 col-12">
                <label for="calcAmount">Введите сумму займа, руб.</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="mdi mdi-currency-rub"></i></div>
                    </div>
                    <input type="number" class="form-control" id="calcAmount" name="calcAmount" placeholder="Сумма займа" value="10000">
                </div>
            </div>

            <div class="col-md-auto col-xl-4 col-12">
                <label for="calcDuration">Введите срок договора, мес.</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"> <i class="mdi mdi-calendar-month"></i></div>
                    </div>
                    <input type="number" class="form-control" id="calcDuration" name="calcDuration" placeholder="Срок" value="10">
                </div>
            </div>

            <div class="col-md-auto col-xl-4 col-12">
                <label for="calcPercent">Ставка % в год + Членский взнос</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="mdi mdi mdi-percent"></i></div>
                    </div>
                    <input type="number" class="form-control" id="calcPercent" name="calcPercent" placeholder="%" value="44">
                </div>
            </div>
        </div>
        <div class="row d-flex pb-4">
            <div class="col-12 col-md-auto">
                <div class="input-group mb-2">
                    <button class="btn btn-outline-primary w-100" id="btn-calc" type="submit"><i class="mdi mdi-calculator"></i>Рассчитать</button>
                </div>
            </div>

            <div class="col-12 col-md-auto ml-md-auto">
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
    </form>

    <div class="row">
        <div class="col-12 content-table">
            <table class="table table-sm table-striped table-hover w-100" id="calc-table">
                <thead class="table">
                    <th>№</th>
                    <th>Дата платежа</th>
                    <th>Остаток займа</th>
                    <th>Сумма займа</th>
                    <th>Процент</th>
                    <th>Членский взнос</th>
                    <th>Сумма платежа</th>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th colspan="6" style="text-align:left"  class="calc-total-payment">Всего к оплате: 0 руб.</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th  colspan="6" style="text-align:left" class="calc-total-overpayment">Переплата: 0 руб.</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('custom-scripts')
    @include('shareholder.partials.datatable-scripts')
    <script>
        $(document).ready(function() {
            function getCalcData(amount, duration, percentRate, memFeeRate) {
                let scheduleArray = [];
                let mainAmtDebt =  amount;
                let mainAmtPerMonth = Number (Math.ceil( (amount/duration) +'e2') + 'e-2');
                let memFeePerMonth = Number (Math.round( (amount * memFeeRate / 100) + 'e2') + 'e-2');
                let dateStart = new moment();
                let paymentDate = dateStart;
                let prevDate = paymentDate;
                let daysInMonth = 0;
                let percentPerMonth = 0;

                for (let i = 1; i <= duration; i++) {
                    prevDate = moment(paymentDate);
                    paymentDate = moment(dateStart).add(i, 'M');

                    if (mainAmtDebt < mainAmtPerMonth) {
                        mainAmtPerMonth = mainAmtDebt;
                    }
                    //daysInMonth = paymentDate.diff(prevDate, 'days');
                    daysInMonth = 31;
                    percentPerMonth = Number (Math.round( ( (percentRate/365/100) * daysInMonth * mainAmtDebt ) + 'e2') + 'e-2');
                    let totalPayment = mainAmtPerMonth + memFeePerMonth + percentPerMonth;

                    let line = new Object();
                    line.no = i;
                    line.payment_date = paymentDate;
                    line.debt = mainAmtDebt.toFixed(2);
                    line.main_amt = mainAmtPerMonth.toFixed(2);
                    line.percent_amt = percentPerMonth.toFixed(2);
                    line.mem_fee = memFeePerMonth.toFixed(2);
                    line.payment_amt = totalPayment.toFixed(2);

                    mainAmtDebt = mainAmtDebt.toFixed(2) - mainAmtPerMonth.toFixed(2);

                    scheduleArray.push(line);
                }
                return scheduleArray;
            };

            function getCalcDataWithInputs() {
                return getCalcData( Number ($('#calcAmount').val()), Number ($('#calcDuration').val()), Number ($('#calcPercent').val()), 1.1);
            };

            let table = $('#calc-table').DataTable( {
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend : "pdf",
                        title: "Кредитный калькулятор",
                        pageSize: 'A4',
                        orientation: 'portret',
                        className: "d-none",
                        footer: false,
                        messageTop: function () {
                            return "Сумма: " + $('#calcAmount').val() + " руб. \n"
                                + "Срок: " + $('#calcDuration').val() + " мес. \n"
                                +"Процентная ставка: " + $('#calcPercent').val() + "% в год + ЧВ (Членский взнос)" +"\n";
                        },
                        messageBottom : function () {
                            return $('.dataTables_scrollFoot .calc-total-payment').html() + "\n"
                                + $('.dataTables_scrollFoot .calc-total-overpayment').html();
                        },
                    },
                    {
                        extend : "print",
                        title: "Кредитный калькулятор",
                        className: "d-none",
                        footer: false,
                        messageTop: function () {
                            return "<b>Сумма: </b>" + $('#calcAmount').val() + " руб. <br>"
                                + "<b>Срок: </b>" + $('#calcDuration').val() + "мес. <br>"
                                +"<b>Процентная ставка: </b>" + $('#calcPercent').val() + "% в год + ЧВ (Членский взнос)" +"<br>";
                        },
                        messageBottom : function () {
                            return "<b>" + $('.dataTables_scrollFoot .calc-total-payment').html() + "<br>"
                                + $('.dataTables_scrollFoot .calc-total-overpayment').html() + "</b>";
                        },
                    },
                    {
                        extend : "excel",
                        sheetName: 'Лист',
                        title: "Кредитный калькулятор",
                        className: "d-none",
                        footer: false,
                        messageTop: function () {
                            return "Сумма: " + $('#calcAmount').val() + " руб.; "
                                + "Срок: " + $('#calcDuration').val() + " мес.; "
                                +"Процентная ставка: " + $('#calcPercent').val() + "% в год + ЧВ (Членский взнос)";
                        },
                        messageBottom : function () {
                            return $('.dataTables_scrollFoot .calc-total-payment').html() +  " "
                                + $('.dataTables_scrollFoot .calc-total-overpayment').html();
                        },
                    }
                ],
                "order": [[ 0, "asc" ]],
                'iDisplayLength': -1,
                "paging": false,
                "ordering": true,
                "info":     false,
                "searching" : false,
                "processing" : true,
                "scrollX": true,
                "data" : getCalcDataWithInputs(),
                "columns": [
                    { "data": "no", "orderable" : false, "width" : "20px"},
                    { "data": "payment_date",
                        "orderable" : false,
                         type: 'date',
                         render: function (data, type, row) { return data ? moment(data).format('DD MMMM YYYY') : ''; }
                    },
                    { "data": "debt", "orderable" : false },
                    { "data": "main_amt", "orderable" : false, className : "paymentMainAmt" },
                    { "data": "percent_amt", "orderable" : false },
                    { "data": "mem_fee", "orderable" : false },
                    { "data": "payment_amt", "orderable" : false , className : "paymentAmt"},
                ],
                "language": {
                    "url" : "{{asset('/js/client/datatables/datatables-ru.json')}}"
                },
                "drawCallback": function( settings ) {
                    let sum = 0;
                    let mainSum = 0;
                    let overpayment = 0;

                    $('td.paymentAmt').each(function(){
                        if (!isNaN(parseFloat ($(this).text())))
                        {
                            sum += parseFloat ($(this).text());
                        }
                    });

                    $('td.paymentMainAmt').each(function(){
                        if (!isNaN(parseFloat ($(this).text())))
                        {
                            mainSum += parseFloat ($(this).text());
                        }
                    });

                    overpayment = sum - mainSum;

                    $(function(){
                        $('.dataTables_scrollFoot .calc-total-payment').first().html("Всего к оплате: " + sum.toFixed(2) + " руб.");
                    });

                    $(function(){
                        $('.dataTables_scrollFoot .calc-total-overpayment').first().html("Переплата: " + overpayment.toFixed(2) + " руб.");
                    });
                }
            } );

            $('#btn-calc').on('click', function () {
               table.clear().rows.add(getCalcDataWithInputs()).draw();
            });

            $('#form-calc').on('submit', function () {
                table.clear().rows.add(getCalcDataWithInputs()).draw(); ;
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

