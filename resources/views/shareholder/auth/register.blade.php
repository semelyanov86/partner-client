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
                                    <span><img src="../images/logo.png" alt="" height="70"></span>
                                </a>
                            </div>
                            <form action="{{route('client.register.submit')}}"  method="POST" class="p-2">
                                @csrf
                                <div class="form-group">
                                    <label for="phone">Номер телефона</label>
                                    <input class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="phone" id="phone" name="phone" autofocus required="" >

                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <label for="emailaddress">Email address</label>--}}
{{--                                    <input class="form-control" type="email" id="emailaddress" required="" placeholder="john@deo.com">--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input class="form-control  {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" required="" id="password" name="password" placeholder="Введите ваш пароль">
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
{{--                                <div class="form-group mb-4 pb-3">--}}
{{--                                    <div class="custom-control custom-checkbox checkbox-primary">--}}
{{--                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin">--}}
{{--                                        <label class="custom-control-label" for="checkbox-signin">I accept <a href="#">Terms and Conditions</a></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> Зарегистрироваться </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-4">
                        <div class="col-sm-12 text-center">
                            <p class="text-muted mb-0">Уже есть учетная запись? <a href="{{route('client.login')}}" class="text-dark ml-1"><b>Войти</b></a></p>
                        </div>
                    </div>

                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
@endsection
@section('scripts')
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.mask.min.js"></script>
    {{--    <script src="../js/bootstrap.min.js"></script>--}}
    <script src="../js/client/register.js"></script>
    {{--    <script src="../js/client/vendor.min.js"></script>--}}
    {{--    <script src="../js/client/app.min.js"></script>--}}
@endsection
