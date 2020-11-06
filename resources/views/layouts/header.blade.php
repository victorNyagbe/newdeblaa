<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/mdb.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('icofont/icofont.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/deblaa.png') }}" type="image/x-icon">
    <style>
        .comfortaa {
            font-family: comfortaa;
        }

        body {
            font-family: comfortaa;
        }

        .messageContent {
            cursor: pointer
        }
    
        @font-face {
            font-family: comfortaa;
            src: url("{{ asset('fonts/Comfortaa-Regular.ttf') }}");
        }
    </style>
    @yield('css')
    <title>Deblaa</title>
</head>
<body class="body">

    <main id="app">
        @yield('sideBar')
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
                            <input type="password" name="oldpassword" id="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror" placeholder="ancien mot de passe" required autocomplete="off">
                            @error('oldpassword')
                                <div class="invalid-feedback">
                                    {{ $errors->first('oldpassword') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="newpassword" id="newpassword" class="form-control @error('newpassword') is-invalid @enderror" placeholder="nouveau mot de passe" required autocomplete="off">
                            @error('newpassword')
                                <div class="invalid-feedback">
                                    {{ $errors->first('newpassword') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="newpassword_confirmation" id="newpassword_confirmation" class="form-control @error('newpassword_confirmation') is-invalid @enderror" placeholder="confirmer" required autocomplete="off">
                            @error('newpassword_confirmation')
                                <div class="invalid-feedback">
                                    {{ $errors->first('newpassword_confirmation') }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ml-auto">
                            <button type="button" class="btn btn-grey white-text" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('js/app.js') }}"></script>
    @yield('extra-js')
</body>
</html>
