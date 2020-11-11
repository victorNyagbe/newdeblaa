@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex mt-3">
            <h4 class="h4-responsive">Créer un ticket :</h4>
        </div>
        <div class="row">
            @if ($errors->any())
                <div class="col-12">
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
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            <div class="col">
                <form action="{{ route('admin.storePerso') }}" method="post">
                    @csrf
                    <input type="hidden" name="categorie_id" value="1">
                    <button type="submit" class="btn btn-sm btn-info" style="height:60px; max-height: 60px;">ticket perso</button>
                </form>
            </div>
            <div class="col">
                <form action="{{ route('admin.storePro') }}" method="post">
                    @csrf
                    <input type="hidden" name="categorie_id" value="2">
                    <button type="submit" class="btn btn-sm btn-success" style="height:60px; max-height: 60px;">ticket pro</button>
                </form>
            </div>
            <div class="col">
                <form action="{{ route('admin.storePromax') }}" method="post">
                    @csrf
                    <input type="hidden" name="categorie_id" value="3">
                    <button type="submit" class="btn btn-sm btn-amber" style="height:60px; max-height: 60px;">ticket pro max</button>
                </form>
            </div>
        </div>
        <div class="d-flex mt-5">
            <h4 class="h4-responsive">Lien vers la liste des tickets disponibles</h4>
        </div>
        <hr class="mt-0">
        <div class="row mt-5">
            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-md-0">
                <a href="{{ route('admin.ticketPerso') }}">
                    <div class="border border-light blue white-text p-5 rounded">
                        <h5 class="text-center">Tickets Perso</h5>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-md-0">
                <a href="{{ route('admin.ticketPro') }}">
                    <div class="border border-light bg-success white-text p-5 rounded">
                        <h5 class="text-center">Tickets Pro</h5>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-md-0">
                <a href="{{ route('admin.ticketPromax') }}">
                    <div class="border border-light amber white-text p-5 rounded">
                        <h5 class="text-center">Tickets Pro max</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection