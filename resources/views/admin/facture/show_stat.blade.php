@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('admin.payBill') }}" method="post">
            <div class="d-flex justify-content-end mt-5">
                @csrf
                <input type="hidden" name="numero" value="{{ $numero_facture }}">
                <input type="hidden" name="structure_id" value="{{ $structure->id }}">
                <input type="hidden" name="nombre_messages" value="{{ count($statistiques) }}">
                <button type="submit" class="btn btn-green btn-sm">Régler la facture</button>        
                <a href="#printthis" class="btn btn-blue btn-sm printer"><span class="icofont icofont-print"></span> imprimer</a>
            </div>
            <div class="row mt-3 mb-4">
                @if ($message = Session::get('error'))
                    <div class="col-12 mb-2">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="col-12 border border-light pt-4 pb-5 px-4 printable">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="font-weight-bold black-text mt-2"><strong>IBTA Group</strong></h5>
                            <p>Agoè Léo 2000, non loin de l'école LA VOLONTÉ</p>
                            <p>Lomé-TOGO</p>
                            <p>22891019245</p>
                        </div>
                        <img src="{{ asset('assets/images/deblaa.png') }}" alt="" style="width: 10rem;">
                        <div>
                            <h5 class="light-blue lighten-5 p-2">FACTURE : {{ $numero_facture }}</h5>
                            <p class="mt-5 black-text">Nom de la structure: <span class="font-weight-bolder">{{ \Illuminate\Support\Str::upper($structure->name) }}</span></p>
                        </div>
                    </div>
                    <div>
                        <p class="mt-3">Date : {{ now()->format('d M Y') }}</p>
                        <p class="mt-5 ml-4">Intitulé : Facture des messages envoyés</p>
                    </div>
                    <?php
                        $nbre_pages = 0;
                        $montant_total = 0;
                        $destinataires = 0;
                        $tab_messages = [];
                    ?>
                    <div class="table-responsive-sm text-nowrap mt-3">
                        <table class="table table-sm table-bordered">
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

                                        $tab_messages[] = $statistique->id;

                                        $montant = 0;
                                        
                                        $montant = (30 * $nbre_pages) * $statistique->destinataires;

                                        $montant_total += $montant;

                                        $destinataires += $statistique->destinataires;
                                    ?>
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::substr($statistique->body, 0, 25) . '...' }}</td>
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
                        <?php
                            $messages = collect($tab_messages);
                            $messageImploded = $messages->implode('-');
                        ?>
                        <input type="hidden" name="destinataires" value="{{ $destinataires }}">
                        <input type="hidden" name="montant" value="{{ $montant_total }}">
                        <input type="hidden" name="messages" value="{{ $messageImploded }}">
                    </div>
                    <div class="mt-5 text-right">
                        <h4>Montant total : <b>{{ $montant_total }} F CFA</b></h4>
                    </div>
                    <div class="mt-5">
                        <p>En votre aimable règlement, <br> Cordialement,</p>
                    </div>
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-center">
            <a href="{{ route('admin.statistique') }}" class="btn btn-grey">retour</a>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
            $('.printer').click(function () {
                $('.printable').printThis();
            });
        });
    </script>
@endsection