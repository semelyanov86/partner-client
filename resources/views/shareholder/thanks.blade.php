@extends('shareholder.layouts.main_app')
@section('page-title') Страница благодарности @endsection
@section('page-content')
    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4 mt-3">
                                <a href="/">
                                    <span><img src="{{asset('/images/success.svg')}}" alt="" height="90"></span>
                                </a>
                            </div>
                            @if(session()->has('message'))
                                <p class="alert alert-success">
                                    {{ session()->get('message') }}
                                </p>
                            @endif
                            <div class="text-center mb-4 mt-3">
                                <a class="btn btn-outline-primary" href="/"> На главную </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
