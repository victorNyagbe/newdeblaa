@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="rowc mt-5">
            <div class="col-12">
                <div class="table-responsive-sm text-nowrap">
                    <table class="table table-striped table-sm table-bordered">
                        <thead class="light-blue darken-3 white-text">
                            <tr>
                                <th scope="col">Message</th>
                                <th scope="col">Destinataires</th>
                                <th scope="col">Date</th>
                                <th scope="col">Heure</th>
                                <th scope="col" class="text-center" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bilans as $bilan)
                                <tr>
                                    <td>
                                        @if (\Illuminate\Support\Str::of($bilan->body)->length() > 25)
                                            {{ \Illuminate\Support\Str::substr($bilan->body, 0, 25) . "..." }}
                                        @else
                                            {{ $bilan->body }}
                                        @endif
                                    </td>
                                    <td>{{ $bilan->destinataires }}</td>
                                    <td>{{ $bilan->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $bilan->created_at->format('H:m:s') }}</td>
                                    <td class="text-center"><a href="#" class="btn btn-sm btn-info">Voir</a></td>
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