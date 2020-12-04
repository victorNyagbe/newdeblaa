@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <form action="{{ route('structure.updateContactPermanentProcessing', $contact->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-row">
                        <div class="col-5">
                            <input type="text" name="number" id="number" class="form-control" value="{{ $contact->number }}" required>
                        </div>
                        <div class="col-7">
                            <input type="text" name="name" id="name" class="form-control" value="{{ $contact->name }}" required>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-sm btn-green white-text spinnerShower">Modifier</button>
                        <a href="{{ route('structure.contact') }}" class="btn btn-sm grey white-text spinnerShower">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection