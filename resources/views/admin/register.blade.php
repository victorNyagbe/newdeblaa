@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-5"></div>
        <div class="d-flex justify-content-center">
            <img src="{{ asset('assets/images/deblaa.png') }}" height="100"  alt="">
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-10 col-md-6 border border-light px-3 py-4 grey lighten-3 rounded">
                
                <h3 class="text-center mb-3"><span class="text-primary">Deb</span><span class="orange-text">laa</span> Administration</h3>
                <form action="{{ route('admin.register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" autofocus required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <input type="password" name="password" id="password" class="form-control" required autocomplete="off">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection