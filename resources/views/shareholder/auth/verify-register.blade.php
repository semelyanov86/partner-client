@extends('shareholder.layouts.def_app')
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
                                <p class="alert alert-warning">
                                    {{ session()->get('message') }}
                                </p>
                            @endif
                            <form action="{{route('client.register.verify.submit')}}"  method="POST" class="p-2">
                                @csrf
                                <div class="form-group">
                                    <label for="phone">Номер телефона</label>
                                    <input class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="phone" id="phone" name="phone" required="" value="{{ old('phone', null) }}">
                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-link ml-auto" id="generate-password">Сгенерировать пароль?</button>
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input class="form-control  {{ $errors->has('password') ? ' is-invalid' : '' }}" type="text" required="" id="password" name="password" autofocus placeholder="Введите ваш пароль" value="{{ old('password', null) }}">
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">Повторите пароль</label>
                                    <input class="form-control  {{ $errors->has('password') ? ' is-invalid' : '' }}" type="text" required="" id="password-confirm" name="password-confirm" placeholder="Введите ваш пароль" value="{{ old('password-confirm', null) }}">
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-link ml-auto" name="action" value="resend" formaction="{{route('client.register.verify.resend')}}" formnovalidate type="submit"> <b>Отправить код повторно?</b> </button>
                                </div>
                                <div class="form-group">
                                    <label for="code">Введите код из СМС</label>
                                    <input class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" type="number" required="" id="code" name="code" placeholder="Код из СМС">
                                    @if($errors->has('code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('code') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary btn-block" name="action" value="register" type="submit"> Зарегистрироваться </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 text-center">
                            <p class="text-muted mb-0">Уже зарегистрированы? <a href="{{route('client.login')}}" class="text-dark ml-1"><b>Войти</b></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('/js/client/register.js')}}"></script>
@endsection
