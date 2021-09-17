@extends('shareholder.layouts.main_app')
@section('page-title')Договор займа №{{ $loanContract->agreement}} от {{ \Carbon\Carbon::parse($loanContract->date_start)->format('d-m-Y')}}г.@endsection
@section('page-content')
    <div id="item-content">
        @if($errors->has('error_msg'))
           <div class="row non-print">
               <div class="col-12">
                   <p class="alert alert-danger w-100">
                       {{ $errors->first('error_msg') }}
                   </p>
               </div>
           </div>
        @endif
        @if( $loanContract->is_open == "1")
            <div class="row pb-1">
                <div class="col-12 col-md-auto">
                    @if( $loanContract->date_calculate)
                        <p><em>Данные актуальны на {{\Carbon\Carbon::parse($loanContract->date_calculate)->format('d-m-Y')}}г. Если данные не актуальны, нажмите "Обновить". </em></p>
                    @else
                        <p><em>Данные не актуальны, нажмите "Обновить". </em></p>
                    @endif
                </div>
                <div class="col-12 col-md-auto ml-md-auto non-print">
                    <form action="{{route('client.loans')}}/{{$loanContract->id}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100"><i class="mdi mdi-refresh"></i> Обновить</button>
                    </form>
                </div>
            </div>
        @endif
       <div class="row">
           <div class="col-6 col-md-3">
               <p>
                    <b> Сумма займа: </b>
               </p>
           </div>
           <div class="col-6 col-md-4">
               <p>
                   {{$loanContract->amount }} р.
               </p>
           </div>
       </div>

        <div class="row">
            <div class="col-6 col-md-3">
                <p>
                    <b>Срок займа: </b>
                </p>
            </div>
            <div class="col-6 col-md-4">
                <p>
                   с {{ \Carbon\Carbon::parse($loanContract->date_start)->format('d-m-Y')}} по {{ \Carbon\Carbon::parse($loanContract->date_end)->format('d-m-Y')}}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-md-3">
                <p>
                    <b>Процентная ставка: </b>
                </p>
            </div>
            <div class="col-6 col-md-4">
                <p>
                    {{$loanContract->percent }}%
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-md-3">
                <p>
                    <b>Процент неустойки: </b>
                </p>
            </div>
            <div class="col-6 col-md-4">
                <p>
                    {{$loanContract->mem_fee}}%
                </p>
            </div>
        </div>

        @if( $loanContract->is_open == "1")
            <hr>
            <div class="row">
                <div class="col-6 col-md-3">
                    <p>
                        <b>Сумма к уплате по графику: </b>
                    </p>
                </div>
                <div class="col-6 col-md-4">
                    <p>
                        {{$loanContract->actual_debt}} р.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3">
                    <p>
                        <b>Общий остаток по договору: </b>
                    </p>
                </div>
                <div class="col-6 col-md-4">
                    <p>
                        {{$loanContract->full_debt}} р.
                    </p>
                </div>
            </div>
            <hr>
            <div class="col-12 col-lg-auto non-print">
                <div class="btn-group w-100" role="group">
                    <button type="button" class="btn btn-outline-secondary"><i class="mdi mdi-currency-rub"></i> Оплатить онлайн</button>
                    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#qrPaymentModal"><i class="fas fa-qrcode"></i> Оплатить по QR-коду</button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#qrSbpPaymentModal"><span><img src="{{asset('/images/sbp-logo.svg')}}" alt="" height="24"></span> Оплатить по QR-коду СБП</button>
                </div>
            </div>
        @endif
        <hr>

        <h5>График погашения</h5>
        <div class="row" >
            <div class="col-12 table-responsive">
                <table class="table table-sm table-striped table-bordered table-hover w-100" id="main-schedule-table">
                    <thead class="table">
                        <tr>
                            <th colspan="6" class="text-center">По плану</th>
                            <th colspan="4" class="text-center">По факту</th>
                            <th colspan="4" class="text-center">Неустойка расчетная</th>
                        </tr>
                        <tr>
                            <th>Дата</th>
                            <th>Остаток</th>
                            <th>Период</th>
                            <th>Кол-во дней</th>
                            <th>Проценты</th>
                            <th>Займ</th>
                            <th>Дата</th>
                            <th>Проценты</th>
                            <th>Сумма займа</th>
                            <th>Неустойка</th>
                            <th>Сумма долга</th>
                            <th>Период неустойки</th>
                            <th>Кол-во дней</th>
                            <th>Сумма неустойки</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($mainSchedule as $line)
                        <tr>
                            <td nowrap>{{$line['date_plan'] ? \Carbon\Carbon::parse($line['date_plan'])->format('d-m-Y') : ""}}</td>
                            <td nowrap>{{ $line['main_amt_debt_plan'] == 0 ? '' : $line['main_amt_debt_plan'] }}</td>
                            <td nowrap>{{$line['period']}}</td>
                            <td nowrap>{{$line['days'] == 0 ? '' :  $line['days']}}</td>
                            <td nowrap>{{$line['percent_amt_plan'] == 0 ? '' : $line['percent_amt_plan']}}</td>
                            <td nowrap>{{$line['main_amt_plan'] == 0 ? '' : $line['main_amt_plan']}}</td>
                            <td nowrap>{{$line['date_fact'] ? \Carbon\Carbon::parse($line['date_fact'])->format('d-m-Y') : ""}}</td>
                            <td nowrap>{{$line['percent_amt_fact'] == 0 ? '' : $line['percent_amt_fact']}}</td>
                            <td nowrap>{{$line['main_amt_fact'] == 0 ? '' : $line['main_amt_fact']}}</td>
                            <td nowrap>{{$line['fee_amt_fact'] == 0 ? '' :  $line['fee_amt_fact'] }}</td>
                            <td nowrap>{{$line['main_amt_debt_fact'] == 0 ? '' : $line['main_amt_debt_fact']}}</td>
                            <td nowrap>{{$line['fee_period']}}</td>
                            <td nowrap>{{$line['fee_days'] == 0 ? '' : $line['fee_days']}}</td>
                            <td nowrap>{{$line['fee_plan'] == 0 ? '' : $line['fee_plan']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <h5>График погашения членских взносов</h5>
        <div class="row" >
            <div class="col-12 table-responsive">
                <table class="table table-sm table-striped table-bordered table-hover w-100" id="memfee-schedule-table">
                    <thead class="table">
                        <tr>
                            <th colspan="2" class="text-center">По плану</th>
                            <th colspan="2" class="text-center">По факту</th>
                        </tr>
                        <tr>
                            <th>Дата </th>
                            <th>Сумма чл.взноса</th>
                            <th>Дата</th>
                            <th>Сумма чл. взноса</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($memfeeSchedule as $line)
                        <tr>
                            <td nowrap>{{$line['date_plan'] ? \Carbon\Carbon::parse($line['date_plan'])->format('d-m-Y') : ""}}</td>
                            <td nowrap>{{$line['mem_fee_plan'] == 0 ? '' : $line['mem_fee_plan'] }}</td>
                            <td nowrap>{{$line['date_fact'] ? \Carbon\Carbon::parse($line['date_fact'])->format('d-m-Y') : ""}}</td>
                            <td nowrap>{{$line['mem_fee_fact'] == 0 ? '' : $line['mem_fee_fact']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="row d-flex pb-5">
        <div class="col-12 col-md-auto pt-1">
        </div>
        <div class="col-12 col-md-auto pt-1 ml-md-auto non-print">
            <div class="btn-group w-100" role="group">
                <a class="btn btn-outline-secondary" href="{{route('client.loans')}}"><i class="ti-back-left"></i> Назад</a>
                <button class="btn btn-primary mr-1 print-page"><i class="ti-printer"></i> Печать</button>
            </div>
        </div>
    </div>

    @if( $loanContract->is_open == "1")
        <!-- Modal QR -->
        <div class="modal fade" id="qrPaymentModal" tabindex="-1" role="dialog" aria-labelledby="qrPaymentModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrPaymentModalLongTitle">QR-код</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" id="qr-payment-amount-block">
                            <label for="qr-payment-amount">Введите сумму</label>
                            <div class="input-group mt-3">
                                <input type="number" id="qr-payment-amount" name="qr-payment-amount" class="form-control" min="0" max="{{$loanContract->full_debt}}" value="{{$loanContract->actual_debt}}" placeholder="Введите сумму">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="qr-payment-generate"><i class="mdi mdi-qrcode-plus"></i>  Сгенерировать</button>
                                </span>
                            </div>
                        </div>
                        <div id="qr-code" class="text-center">
                            <div class="spinner-border text-primary m-2 loader" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row d-flex">
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary mb-1 " id="qr-save"><i class="ti-save"></i> Сохранить</button>
                                <button type="button" class="btn btn-primary mb-1 " id="qr-print"><i class="ti-printer"></i><span class="d-sm-inline d-none"> Печать</span></button>
                            </div>
                            <div class=" col-auto ml-sm-auto">
                                <button type="button" class="btn btn-danger mb-1" data-dismiss="modal"><i class="ti-close"></i><span class="d-sm-inline d-none"> Закрыть</span></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal QR -->

        <!-- Modal SBP QR -->
        <div class="modal fade" id="qrSbpPaymentModal" tabindex="-1" role="dialog" aria-labelledby="qrSbpPaymentModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrPaymentModalLongTitle">QR-код СБП</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" id="qr-sbp-payment-amount-block">
                            <label for="qr-sbp-payment-amount">Введите сумму</label>
                            <div class="input-group mt-3">
                                <input type="number" id="qr-sbp-payment-amount" name="qr-sbp-payment-amount" class="form-control" min="0" max="{{$loanContract->full_debt}}" value="{{$loanContract->actual_debt}}" placeholder="Введите сумму">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="qr-sbp-payment-generate"><i class="mdi mdi-qrcode-plus"></i>  Сгенерировать</button>
                                </span>
                            </div>
                        </div>
                        <div id="qr-sbp-code" class="text-center">
                            <div class="spinner-border text-primary m-2 loader" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row d-flex">
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary mb-1 " id="qr-sbp-save"><i class="ti-save"></i> Сохранить</button>
                                <button type="button" class="btn btn-primary mb-1 " id="qr-sbp-print"><i class="ti-printer"></i><span class="d-sm-inline d-none"> Печать</span></button>
                            </div>
                            <div class=" col-auto ml-sm-auto">
                                <button type="button" class="btn btn-danger mb-1" data-dismiss="modal"><i class="ti-close"></i><span class="d-sm-inline d-none"> Закрыть</span></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal SBP QR -->

    @endif

@endsection
@section('custom-scripts')
        <script>
            $(document).ready(function() {
                $('.loader').hide();
                @if( $loanContract->is_open == "1")

                    //qr-code
                    var qrCodeText = '{!!$qrCodeText!!}';
                    $('#qr-payment-generate').on ('click', function () {
                        $.ajax({
                            url: '{{route('client.qr')}}&text='
                                + qrCodeText.replace('#PayAmt#', parseInt(($('#qr-payment-amount').val()*100).toFixed(2), 10) ),
                            method: 'GET',
                            beforeSend: function (request)
                            {
                                request.setRequestHeader("X-CSRF-TOKEN",  $('meta[name="csrf-token"]').attr('content'));

                            },
                            success: function (server_response) {
                                if (server_response == null || server_response == '')
                                    $('#qr-code').append("<p class='text-danger text-center'>Не удалось получить данные! Повторите попытку или свяжитесь с тех. поддержкой.</p>");
                                else
                                {
                                    $('#qr-code').empty();
                                    $('#qr-code').append("<img src='data:image/png;base64, " + server_response + "'>");
                                }
                            },
                            error: function() {
                                $('#qr-code').append("<p class='text-danger text-center'>Не удалось получить данные! Повторите попытку или свяжитесь с тех. поддержкой.</p>");
                            }
                        });
                    });

                    $('#qr-save').on ('click', function () {
                        if ($('#qr-code img').length)
                        {
                            let a = document.createElement("a");
                            a.href = $('#qr-code img').attr('src');
                            a.download = "qr-code_{{$loanContract->agreement}}_{{$loanContract->date_calculate}}.png";
                            a.click();
                        }
                    });

                    $('#qr-print').on ('click', function () {
                        if ($('#qr-code img').length)
                        {
                            var win = window.open('about:blank', "_new");
                            win.document.open();
                            win.document.write([
                                '<html>',
                                '   <head>',
                                '   </head>',
                                '   <body onload="window.print()" onafterprint="window.close()">',
                                '       <img src="' + $('#qr-code img').attr('src') + '"/>',
                                '   </body>',
                                '</html>'
                            ].join(''));
                            win.document.close();
                        }
                    });

                    //sbp-qr-code
                    var qrSbpPurpose = '{!!$qrSbpPurpose!!}';
                    $('#qr-sbp-payment-generate').on ('click', function () {
                    $.ajax({
                        url: '{{route('client.sbp-qr')}}&purpose=' + qrSbpPurpose
                            + '&amount=' + parseInt(($('#qr-sbp-payment-amount').val()*100).toFixed(2), 10),
                        method: 'GET',
                        beforeSend: function (request)
                        {
                            $('.loader').show();
                            request.setRequestHeader("X-CSRF-TOKEN",  $('meta[name="csrf-token"]').attr('content'));
                        },
                        success: function (server_response) {
                            if (server_response == null || server_response == '')
                                $('#qr-sbp-code').append("<p class='text-danger text-center'>Не удалось получить данные! Повторите попытку или свяжитесь с тех. поддержкой.</p>");
                            else
                            {
                                $('#qr-sbp-code').empty();
                                $('#qr-sbp-code').append("<img src='data:image/png;base64, " + server_response + "'>");
                            }
                        },
                        error: function() {
                            $('#qr-sbp-code').append("<p class='text-danger text-center'>Не удалось получить данные! Повторите попытку или свяжитесь с тех. поддержкой.</p>");
                        },
                        complete: function () {
                            $('.loader').hide();
                        }
                    });
                });

                $('#qr-sbp-save').on ('click', function () {
                    if ($('#qr-sbp-code img').length)
                    {
                        let a = document.createElement("a");
                        a.href = $('#qr-sbp-code img').attr('src');
                        a.download = "qr-code_{{$loanContract->agreement}}_{{$loanContract->date_calculate}}.png";
                        a.click();
                    }
                });

                $('#qr-sbp-print').on ('click', function () {
                    if ($('#qr-sbp-code img').length)
                    {
                        var win = window.open('about:blank', "_new");
                        win.document.open();
                        win.document.write([
                            '<html>',
                            '   <head>',
                            '   </head>',
                            '   <body onload="window.print()" onafterprint="window.close()">',
                            '       <img src="' + $('#qr-sbp-code img').attr('src') + '"/>',
                            '   </body>',
                            '</html>'
                        ].join(''));
                        win.document.close();
                    }
                });

                @endif

                $('.print-page').on ('click', function () {
                    var win = window.open('about:blank', "_new");
                    win.document.open();
                    win.document.write([
                        '<html>',
                        '   <head>',
                        ' '+ $('head').html() + '',
                        '   </head>',
                        '   <body onload="window.print()" onafterprint="window.close()">',
                        '       ' + $('.content').html().replace(new RegExp('table-responsive', 'g') ,'') + '',
                        '   </body>',
                        '</html>'
                    ].join(''));
                    win.document.close();
                });

            } );
        </script>
@endsection
