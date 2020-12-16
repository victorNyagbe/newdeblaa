@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex mt-4 justify-content-between align-items-center">
            <h4 class="font-weight-bold"><span class="icofont-company"></span> {{ $structure->name }}</h4>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.structures') }}">Structures</a></li>
                        <li class="breadcrumb-item active">{{ $structure->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <p><span class="icofont-check"></span> Contacts permanents: <span class="font-weight-bold font-italic">{{ $nombre_contactPermanent }}</span></p>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <p><span class="icofont-check"></span> Contacts non permanents: <span class="font-weight-bold font-italic">{{ $nombre_contactNonPermanent }}</span></p>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <p><span class="icofont-check"></span> Messages envoyés : <span class="font-weight-bold font-italic">{{ count($structure->messages) }}</span></p>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <p><span class="icofont-check"></span> SMS restants : <span class="font-weight-bold font-italic">{{ $structure->message_payer }}</span></p>
            </div>
        </div>
        <h5 class="mt-5"><span class="icofont-justify-all"></span> Liste des contacts</h5>
        <div class="row mt-3">
            <div class="col-12">
                <div class="table-responsive table-responsive-md text-nowrap">
                    <table class="table table-striped">
                        <tbody>
                            @forelse ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->number }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td width="100">{{ $contact->permanent == 1 ? 'CP' : 'CNP' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Aucun contact n'est enregistré par cette structure</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection