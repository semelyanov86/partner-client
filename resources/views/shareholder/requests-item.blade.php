@extends('shareholder.layouts.main_app')
@section('page-title')Заявка № {{ $loanRequest->request_no}}@endsection
@section('page-content')
    <div id="item-content">
       <div class="row">
           <div class="col-6 col-md-3">
               <p>
                    <b>Дата заявки: </b>
               </p>
           </div>
           <div class="col-6 col-md-4">
               <p>
                   {{ \Carbon\Carbon::parse($loanRequest->request_date)->format('d-m-Y')}}
               </p>
           </div>
       </div>

        <div class="row">
            <div class="col-6 col-md-3">
                <p>
                    <b>Сумма заявки: </b>
                </p>
            </div>
            <div class="col-6 col-md-4">
                <p>
                   {{$loanRequest->amount }} р.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-md-3">
                <p>
                    <b>Статус заявки: </b>
                </p>
            </div>
            <div class="col-6 col-md-4">
                <p>
                    {{$loanRequest->status }}
                </p>
            </div>
        </div>


        @if($loanRequest->data)
            @foreach(json_decode($loanRequest->data, true) as $field)
                <div class="row">
                    <div class="col-6 col-md-3">
                        <p>
                            <b>{{$field['title']}}: </b>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            {{$field['value']}}
                        </p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="row d-flex pb-5">
        <div class="col-12 col-md-auto pt-1">
        </div>
        <div class="col-12 col-md-auto pt-1 ml-md-auto non-print">
            <div class="btn-group w-100" role="group">
                <a class="btn btn-outline-secondary" href="{{route('client.requests')}}"><i class="ti-back-left"></i> Назад</a>
                <a href="javascript:window.print();" class="btn btn-primary mr-1"><i class="ti-printer"></i> Печать</a>
            </div>
        </div>
    </div>
@endsection
