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
                            <form action="{{ route('client.login.submit') }}" method="POST"  class="p-2">
                                @csrf
                                <div class="form-group">
                                    <label for="phone">Номер телефона</label>
                                    <input class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="phone" id="phone" name="phone" autofocus required="" value="{{ old('phone', null) }}">
                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <a href="#" class="text-muted float-right">Забыли пароль?</a>
                                    <label for="password">Пароль</label>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" required="" id="password" name="password" placeholder="Введите ваш пароль">
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> Войти </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 text-center">
                            <p class="text-muted mb-0">В первый раз? <a href="{{route('client.register')}}" class="text-dark ml-1"><b>Зарегистрироваться</b></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('/js/client/login.js')}}"></script>
@endsection
