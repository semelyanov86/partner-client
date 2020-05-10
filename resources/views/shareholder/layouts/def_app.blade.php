<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Клиентский портал</title>
    <link href="../css/client//bootstrap.min.css" rel="stylesheet" />
    <link href="../css/client//app.min.css" rel="stylesheet" type="text/css" />
    <link href="../css/client//icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../css/client//custom.css" rel="stylesheet" type="text/css" />
    @yield('styles')
</head>

<body class="enlarged">
    @yield('content')
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.mask.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    @yield('scripts')
</body>

</html>
