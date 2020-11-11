@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            @foreach ($persos as $perso)
                <div class="col-6 col-md-2">
                    <div class="border border-light z-depth-1 white py-2 px-1">
                        <h5 class="h5-responsive text-center black-text">
                            {{ $perso->code }}
                        </h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection