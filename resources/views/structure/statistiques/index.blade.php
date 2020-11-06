@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="mt-3 d-flex justify-content-start">
            <a href="{{ route('structure.index') }}" class="btn btn-sm grey darken-1 white-text">retour</a>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <table width="100%">
                    <tr>
                        <td width="40">
                            <i class="icofont icofont-calendar icofont-2x"></i>
                        </td>
                        <td width="300">
                            <input type="text" name="date" value="{{ now() }}" readonly required class="form-control form-control-md">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
            $nbre_pages = 0;
            $montant_total = 0;
        ?>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive-sm text-nowrap mt-3">
                    <table class="table table-striped table-sm table-bordered">
                        <thead class="blue darken-4">
                            <tr class="text-white">
                                <th scope="col">Message</th>
                                <th scope="col" width="150">Date d'envoi</th>
                                <th scope="col" width="150">Nombre de pages</th>
                                <th scope="col" width="150">Destinataires</th>
                                <th scope="col" width="150">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($statistiques as $statistique)
                                <?php
                                    if ((\Illuminate\Support\Str::of($statistique->body)->length()) > 160 ) {
                                        $nbre_pages = 2;
                                    } else {
                                        $nbre_pages = 1;
                                    }

                                    $montant = 0;
                                    
                                    $montant = (30 * $nbre_pages) * $statistique->destinataires;

                                    $montant_total += $montant;
                                ?>
                                <tr>
                                    <td>{{ \Illuminate\Support\Str::substr($statistique->body, 0, 20) . '...' }}</td>
                                    <td>{{ $statistique->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $nbre_pages }}</td>
                                    <td>{{ $statistique->destinataires }}</td>    
                                    <td>{{ $montant }}</td>    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun statistique de messages disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <h4>Montant total : <b>{{ $montant_total }} F CFA</b></h4>
                </div>
            </div>
        </div>
    </div>
@endsection