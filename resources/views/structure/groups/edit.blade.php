@extends('layouts.sideBar')

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="row mt-2">
                <div class="col-12">     
                    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>    
                </div>
            </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="row mt-2">
            <div class="col-12">     
                <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                    {{ $message }}
                    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>    
            </div>
        </div>
        @endif
        <div class="row mt-4">
            <div class="col-12 col-sm-6">
                <h3><span class="icofont icofont-shield-alt"></span> {{ $group->name }}</h3>
            </div>
            <div class="col-12 col-sm-6">
                <nav aria-label="breadcrumb float-sm-right">
                    <ol class="breadcrumb bg-white">
                        <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Mes groupes</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('groups.show', $group->id) }}">{{ $group->name }}</a></li>
                        <li class="breadcrumb-item active">Editer {{ $group->name }}</li>
                    </ol>
                    </nav>
            </div>
            <div class="col-12 mt-4">
                <p>Nombre de membres : {{ count($group->contacts) }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-6">
                <form action="{{ route('groups.update', $group->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="form-row">
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name" value="{{ $group->name }}" placeholder="Le nom du groupe" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-sm btn-success mt-md-0">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection