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
                            <form action="{{ route('client.forgot.submit') }}" method="POST"  class="p-2">
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
                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> Сбросить пароль </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 text-center">
                            <p class="text-muted mb-0">Оказались здесь случайно? <a href="{{route('client.login')}}" class="text-dark ml-1"><b>Вернуться на страницу входа</b></a></p>
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
