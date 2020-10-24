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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('icofont/icofont.css') }}">
    <title>Deblaa</title>
    <style>

        body {
            font-family: comfortaa;
        }

        @font-face {
            font-family: comfortaa;
            src: url(fonts/Comfortaa-Regular.ttf);
        }
    </style>
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark primary-color-dark">

        <!-- Navbar brand -->
        <a class="navbar-brand" href="{{ route('structure.index') }}">
            <img src="{{ asset('assets/images/deblaa.png') }}" height="35" alt="">
        </a>
    
        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
        aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">
    
        <!-- Links -->
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a href="{{ route('structure.message') }}" class="nav-link">Envoyer un message</a>
            </li>
                
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item avatar dropdown">
            <a class="nav-link p-0" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                @if (session()->get('image') != null)
                    <img src="{{ asset('storage/'.session()->get('image')) }}" class="rounded-circle z-depth-0"
                    alt="avatar image" height="50">
                @else
                    <div style="width: 35px; height: 35px; overflow: hidden;" class="rounded-circle">
                        <div style="width: 35px; height: 35px; line-height: 35px;" class="white text-center">
                            <span class="icofont-building icofont-1x black-text"></span>
                        </div>
                    </div>
                @endif
            </a>
            <div class="dropdown-menu dropdown-primary dropdown-menu-md-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('structure.showProfile') }}">Profil</a>
                <a class="dropdown-item" href="{{ route('structure.logout') }}">Se déconnecter</a>
            </div>
            </li>
        </ul>
        <!-- Links -->
        </div>
        <!-- Collapsible content -->
    
    </nav>
    <!--/.Navbar-->

    <main class="container" id="app">
        @yield('content')
    </main>

    <div class="modal fade" id="basicPasswordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Modifier mot de passe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('structure.changePassword', session()->get('id')) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="mot de passe" required autocomplete="off">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ml-auto">
                            <button type="button" class="btn btn-grey" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/mdb.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
</body>
</html>