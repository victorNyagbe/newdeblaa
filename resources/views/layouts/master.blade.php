<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdb.lite.css') }}">
    <link rel="stylesheet" href="{{ asset('icofont/icofont.css') }}">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/deblaa.png') }}" type="image/x-icon">
    <title>Deblaa</title>
    <style>
        body {
            font-family: comfortaa;
        }

        @font-face {
            font-family: comfortaa;
            src: url("{{ asset('fonts/Comfortaa-Regular.ttf') }}");
        }
    </style>
</head>
    @yield('homecss')
<body>

    @yield('navbar')

    @yield('content')
    
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/mdb.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    @yield('script')
</body>
</html>