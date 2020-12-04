@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="mt-3 d-flex justify-content-start">
            <a href="{{ route('structure.index') }}" class="btn btn-sm grey darken-1 white-text spinnerShower">retour</a>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-10 col-xl-12">
                @if ($messageError = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                        {{ $messageError }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if ($messageError = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                    {{ $messageError }}
                    <button type="button" class="close" aria-label="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
                <div class="table-responsive-sm table-responsive-md text-nowrap">
                    <table class="table table-striped table-sm table-bordered">
                        <thead class="light-blue darken-3 white-text">
                            <tr>
                                <th scope="col">Message</th>
                                <th scope="col">Destinataires</th>
                                <th scope="col">Nombre de pages</th>
                                <th scope="col">Date</th>
                                <th scope="col" class="text-center" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bilans as $bilan)
                                <?php
                                    if ((\Illuminate\Support\Str::of($bilan->body)->length()) > 160) {
                                        $nbre_pages = 2;
                                    } else {
                                        $nbre_pages = 1;
                                    }
                                ?>
                                <tr>
                                    <td>
                                        @if (\Illuminate\Support\Str::of($bilan->body)->length() > 25)
                                            {{ \Illuminate\Support\Str::substr($bilan->body, 0, 25) . "..." }}
                                        @else
                                            {{ $bilan->body }}
                                        @endif
                                    </td>
                                    <td>{{ $bilan->destinataires }}</td>
                                    <td>{{ $nbre_pages }}</td>
                                    <td>{{ $bilan->created_at->format('d-m-Y') }}</td>
                                    <td class="text-center"><a href="{{ route('messages.showBilan', $bilan->id) }}" class="btn btn-sm btn-info spinnerShower">Voir</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun bilan en vue!!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection