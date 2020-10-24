@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-5"></div>
        <div class="d-flex justify-content-center">
            <img src="{{ asset('assets/images/deblaa.png') }}" height="100"  alt="">
        </div>

        <div class="row justify-content-center mt-2">
            <div class="col-10 col-md-6 border border-light px-3 py-4 grey lighten-3 rounded">

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                <h3 class="text-center mb-3"><span class="text-primary">Deb</span><span class="orange-text">laa</span> Administration</h3>
                <form action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" autofocus required autocomplete="off">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="off">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection