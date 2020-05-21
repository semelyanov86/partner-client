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
                                    <span><img src="{{asset('/images/cancel.svg')}}" alt="" height="90"></span>
                                </a>
                            </div>
                            @if(session()->has('message'))
                                <p class="alert alert-danger">
                                    {{ session()->get('message') }}
                                </p>
                            @endif
                            <div class="text-center mb-4 mt-3">
                                <a class="btn btn-outline-primary" href="/"> Перезагрузить </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
