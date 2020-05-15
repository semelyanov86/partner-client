@extends('shareholder.layouts.def_app')

@section('style')
@endsection

@section('content')
    <!-- Begin page -->
    <div id="wrapper">
        @include('shareholder.partials.header')
        @include('shareholder.partials.menu')
        @include('shareholder.partials.content')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('/js/client/metisMenu.js')}}"></script>
    <script src="{{asset('/js/client/waves.js')}}"></script>
    <script src="{{asset('/js/client/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('/js/client/app.min.js')}}"></script>
    <script src="{{asset('/js/client/main.js')}}"></script>
@endsection


