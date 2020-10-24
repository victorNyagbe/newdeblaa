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
    <link rel="stylesheet" href="{{ asset('icofont/icofont.css') }}">
    <title>Deblaa | Admin</title>
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
<body>
    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark primary-color-dark">
        <a class="navbar-brand" href="{{ route('admin.home') }}">
            <img src="{{ asset('assets/images/deblaa.png') }}" height="35" alt="">
            Deblaa
        </a>
        @if (session()->has('id'))
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
                aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ $page == 'adminhome' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.home') }}">Accueil
                        <span class="sr-only">(current)</span>
                    </a>
                    </li>
                    <li class="nav-item {{ $page == 'structure' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.structures') }}">Les structures</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ml-auto nav-flex-icons">
                    <li class="nav-item avatar dropdown">
                    <a class="nav-link p-0" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" class="rounded-circle z-depth-0"
                        alt="avatar image" height="35">
                    </a>
                    <div class="dropdown-menu dropdown-primary dropdown-menu-md-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Profil</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">Se déconnecter</a>
                    </div>
                    </li>
                </ul>
            </div>
        @endif
    </nav>
    <!--/.Navbar -->

    @yield('content')
  
    <!-- Modal -->
    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter une structure</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.registerStructure') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="structure_name">Nom de la structure</label>
                        <input type="text" name="structure_name" id="structure_name" class="form-control @error('structure_name') is-invalid @enderror" autofocus autocomplete="off" required>
                        @error('structure_name')
                            <div class="invalid-feedback">
                                {{ $errors->first('structure_name') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mot de passe</label>
                        <input type="password" name="pwd" id="pwd" class="form-control @error('pwd') is-invalid @enderror" placeholder="mot de passe" required autocomplete="off">
                        @error('pwd')
                            <div class="invalid-feedback">
                                {{ $errors->first('pwd') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pwd_confirmation">Confirmation</label>
                        <input type="password" name="pwd_confirmation" id="pwd_confirmation" class="form-control @error('pwd_confirmation') is-invalid @enderror" placeholder="mot de passe" required autocomplete="off">
                        @error('pwd_confirmation')
                            <div class="invalid-feedback">
                                {{ $errors->first('pwd_confirmation') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group ml-auto">
                        <button type="button" class="btn btn-grey" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/mdb.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
</body>
</html>