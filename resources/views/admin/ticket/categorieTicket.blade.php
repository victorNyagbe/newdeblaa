@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            @foreach ($categories as $categorie)
                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="border border-light white-text rounded {{ $categorie->code_couleur }}">
                        <div class="d-flex justify-content-between align-items-center py-4 px-2">
                            <h3>{{ "Carte " . \Illuminate\Support\Str::ucfirst($categorie->nom) }}</h3>
                            <div>
                                <p>{{ $categorie->montant }} F CFA</p>
                                <p>{{ $categorie->nombre_sms }} SMS</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-0">
                            <form action="{{ route('admin.categorieTicketDelete', $categorie->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded"><span class="icofont icofont-trash"></span> supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center mt-5">
            @if ($errors->any())
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    {{ $message }}
                    <button type="button" class="close" aria-label="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-12 col-md-10 col-lg-8 border border-light z-depth-2 p-5">
                <form action="{{ route('admin.categorieTicketStore') }}" method="post">
                    @csrf
                    <h4 class="text-center mb-4 h4-responsive">Enregistrer une catégorie</h4>
                    <div class="form-group">
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}" autocomplete="off" placeholder="le nom de la catégorie...">
                    </div>
                    <div class="form-group">
                        <input type="text" name="nombre_sms" id="nombre_sms" class="form-control" required value="{{ old('nombre_sms') }}" autocomplete="off" placeholder="nombre de sms...">
                    </div>
                    <div class="form-group">
                        <input type="text" name="montant" id="montant" class="form-control" required value="{{ old('montant') }}" autocomplete="off" placeholder="Le montant...">
                    </div>
                    <div class="form-group">
                        <input type="text" name="couleur" id="couleur" class="form-control" required value="{{ old('couleur') }}" autocomplete="off" placeholder="couleur de la carte. Exple: success pour vert">
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-green rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection