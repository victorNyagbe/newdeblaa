@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="mt-3 d-flex justify-content-start">
            <a href="{{ route('structure.index') }}" class="btn btn-sm grey darken-1 white-text">retour</a>
        </div>
        <div class="row mt-3">
            @if ($message = Session::get('error'))
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="table-responsive-sm text-nowrap">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="blue darken-4 white-text">
                            <tr>
                                <th scope="col">Numero</th>
                                <th scope="col">Date</th>
                                <th scope="col">Messages</th>
                                <th scope="col">Destinataires</th>
                                <th scope="col">Montant</th>
                                <th scope="col" width="150" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($factures as $facture)
                                <tr>
                                    <td>{{ $facture->numero }}</td>
                                    <td>{{ $facture->created_at->format('d M Y') }}</td>
                                    <td>{{ $facture->nombre_message }}</td>
                                    <td>{{ $facture->destinataires }}</td>
                                    <td>{{ $facture->montant . ' F CFA' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('structure.factureShow', $facture->id) }}" class="btn btn-sm btn-info"><span class="icofont-plus-circle"></span> details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Pas de factures enregistrés pour le moment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection