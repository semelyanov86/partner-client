@extends('shareholder.layouts.def_app')
@section('style')
@endsection

@section('content')
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4 mt-3">
                                <a href="/">
                                    <span><img src="{{asset('/images/logo.png')}}" alt="" height="70"></span>
                                </a>
                            </div>
                            @if(session()->has('message'))
                                <p class="alert alert-info">
                                    {{ session()->get('message') }}
                                </p>
                            @endif
                            @if($errors->has('error_msg'))
                                <p class="alert alert-danger">
                                    {{ $errors->first('error_msg') }}
                                </p>
                            @endif
                            <div class="p-2">
                                На ваш номер телефона был отправлен код подтверждения. Если вы не получили код, нажмите
                                <a class="" href="javascript:;" onclick="document.getElementById('resend-form').submit();"> сюда</a>.
                            </div>
                            <form action="{{ route('client.verify.submit') }}" method="POST"  class="p-2">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" type="number" required="" id="code" name="code" placeholder="Код из СМС">
                                    @if($errors->has('code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('code') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="row d-flex">
                                    <div class="col-auto pb-2">
                                        <button class="btn btn-primary btn-block " type="submit"> Проверить </button>
                                    </div>
                                    <div class="col-auto ml-auto">
                                        <a class="btn btn-danger btn-block"  href="javascript:;" onclick="document.getElementById('logout-form').submit();"> Выйти </a>
                                    </div>
                                </div>
                            </form>
                            <form action="{{route('client.resend')}}" method="POST" class="p-2" id="resend-form">
                                @csrf
                            </form>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
