@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center justify-content-md-start">
            @for ($i = 0; $i < 10; $i++)
                <div class="col-10 my-3 py-3 px-2 rounded light-blue lighten-5">
                    <p class=""><strong class="font-weight-bold">Service des passeports</strong> a envoyé un message commun à 100 personnes</p>
                </div>
            @endfor
        </div>
    </div>
@endsection