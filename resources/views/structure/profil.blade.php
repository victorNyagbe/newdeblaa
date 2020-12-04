@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-8">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('structure.updateProfile', session()->get('id')) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Nom de la structure:</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ session()->get('name') }}" required autocomplete="off">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Profil:</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-blue white-text spinnerShower">Enregistrer</button>
                        <button type="button" class="btn btn-amber white-text" data-toggle="modal" data-target="#basicPasswordModal">
                            Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-4">
                @if (session()->get('image') == null)
                    <div style="width: 20rem; height: 20rem; line-height: 20rem;" class="orange text-center mb-4">
                        <b style="font-size: 3rem;">Logo</b>
                    </div>
                @else
                    <img src="{{ asset('storage/app/public/'.session()->get('image')) }}" class="z-depth-0 img-fmuid w-100 img-thumbnail"
                    alt="avatar image">
                @endif
            </div>
        </div>
    </div>
@endsection