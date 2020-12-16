@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex mt-4">
            <h5 class="font-weight-bold"><span class="icofont-dashboard"></span> Tableau de bord</h5>
        </div>
        <hr class="grey mt-0">
        <div class="row justify-content-center justify-content-md-start mb-3">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="d-flex justify-content-between align-items-center red white-text py-4 px-2 z-depth-2 rounded">
                    <div class="text-center">
                        <div><span class="icofont-company icofont-4x mb-1" style="opacity: 0.3;"></span></div>
                        <h4>Structures</h4>
                    </div>
                    <div>
                        <h3>{{ $nombre_structures }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="d-flex justify-content-between align-items-center blue darken-2 white-text py-4 px-2 z-depth-2 rounded">
                    <div class="text-center">
                        <div><span class="icofont-credit-card icofont-4x mb-1" style="opacity: 0.3;"></span></div>
                        <h4>Tickets</h4>
                    </div>
                    <div>
                        <h3>{{ $nombre_tickets }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="d-flex justify-content-between align-items-center green white-text py-4 px-2 z-depth-2 rounded">
                    <div class="text-center">
                        <div><span class="icofont-comment icofont-4x mb-1" style="opacity: 0.3;"></span></div>
                        <h4>Messages</h4>
                    </div>
                    <div>
                        <h3>{{ $nombre_messages }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection