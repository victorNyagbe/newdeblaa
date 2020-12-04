@extends('layouts.master')

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
                
                <h3 class="text-center mb-3">Connexion</h3>
                <form action="{{ route('structure.login') }}" method="post" class="spinnerShower">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom de la structure:</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control form-control-sm @error('name') is-invalid @enderror" autofocus required autocomplete="off">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="icofont icofont-eye btnEye" style="cursor: pointer;"></span>
                                    <span class="icofont icofont-eye-blocked btnEyeBlocked" style="cursor: pointer; display: none;"></span>
                                </div>
                            </div>
                            <input type="password" name="password" id="passwordEye" class="form-control form-control-sm @error('password') is-invalid @enderror" required autocomplete="off">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Spinner --}}
    <div id="spinner" style="display: none; position: absolute; top: 0; bottom: 0; line-height:100%; left: 0; right: 0; background-color: rgba(0,0,0, 0.5)">
        <div class="text-center" style="margin-top: 200px;">
            <img src="{{ URL::asset('assets/images/spinner.svg') }}" alt="loading ..." width="100px;">
        </div>
    </div>
    {{-- /.Spinner --}}
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.btnEye').click(function() {
                $('#passwordEye').attr('type','text');
                $(this).css('display', 'none');
                $('.btnEyeBlocked').css('display', 'block')
            });

            $('.btnEyeBlocked').click(function() {
                $('#passwordEye').attr('type','password');
                $(this).css('display', 'none');
                $('.btnEye').css('display', 'block')
            });

            $('.spinnerShower').submit(function () {
                $('#spinner').fadeIn();
            });
        })
    </script>
@endsection