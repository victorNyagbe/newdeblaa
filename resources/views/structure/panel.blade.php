@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="d-flex flex-column align-items-center mt-5 " style="height: 100%">
            <img src="{{ asset('assets/images/deblaa.png') }}" alt="" class="img-fluid w-25 mt-lg-3">
            <h4 class="font-weight-bold animated rollIn mt-4 mb-2 text-center">Mon espace de travail DEBLAA</h4>
            @if (count($verifyTicketPaidByStructure) == 0)
                <div class="blue white-text py-2 px-3 rounded animated fadeIn delay-1s z-depth-1-half mt-3">
                    <h5 class="text-center">!! IMPORTANT</h5>
                    <p>Vous avez eu 20 SMS offerts pour tester l'application. Il vous en reste {{ session()->get('message_payer') }} SMS à utiliser.</p>
                </div>
            @endif
        </div>
    </div>
@endsection