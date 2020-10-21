<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdb.lite.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Deblaa</title>
</head>
    @yield('homecss')
<body>

    @yield('navbar')

    @yield('content')
    
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/mdb.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
</body>
</html>