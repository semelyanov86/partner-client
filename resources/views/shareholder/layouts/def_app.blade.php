<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Личный кабинет</title>
    <link rel="shortcut icon" href="{{ asset('/images/favicons.png') }}" type="image/x-icon">
    <link href="{{ asset('/css/client/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/client/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/client/app.min.css') }}"rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/client/custom.css') }}" rel="stylesheet" type="text/css" />
    @yield('styles')
</head>

<body>
    @yield('content')
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/popper.min.js')}}"></script>
    <script src="{{asset('/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    @yield('scripts')
    @yield('custom-scripts')
</body>

</html>
