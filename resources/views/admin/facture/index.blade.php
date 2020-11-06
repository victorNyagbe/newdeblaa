@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="table-responsive-sm text-nowrap">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="blue darken-4 white-text">
                            <tr>
                                <th scope="col">Numero de facture</th>
                                <th scope="col">Structure</th>
                                <th scope="col">Messages</th>
                                <th scope="col">Destinataires</th>
                                <th scope="col">Montant</th>
                                <th scope="col" width="150" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factures as $facture)
                                <tr>
                                    <td>{{ $facture->numero }}</td>
                                    <td>{{ $facture->structure->name }}</td>
                                    <td>{{ $facture->nombre_message }}</td>
                                    <td>{{ $facture->destinataires }}</td>
                                    <td>{{ $facture->montant }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.facture_show', $facture->id) }}" class="btn btn-sm btn-info"><span class="icofont icofont-plus-circle"></span> details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection