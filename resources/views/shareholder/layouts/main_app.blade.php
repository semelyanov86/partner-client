@extends('shareholder.layouts.def_app')

@section('style')
@endsection

@section('content')
    <div id="wrapper">
        @include('shareholder.partials.header')
        @include('shareholder.partials.menu')
        @include('shareholder.partials.content')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('/js/client/bootstrap-filestyle.min.js')}}"></script>
    <script src="{{asset('/js/client/metisMenu.js')}}"></script>
    <script src="{{asset('/js/client/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('/js/client/app.js')}}"></script>
    <script src="{{asset('/js/client/main.js')}}"></script>
@endsection


