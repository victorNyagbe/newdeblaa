@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-10">
                @if ($messageError = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                        {{ $messageError }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div>
                    <textarea name="bilan" id="bilan" class="form-control" rows="4" readonly>{{ $message->body }}</textarea>
                </div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <p>Destinataires: {{ $message->destinataires }}</p>
                        <p>
                            <?php
                            if ((\Illuminate\Support\Str::of($message->body)->length()) > 160) {
                                $nbre_pages = 2;
                            } else {
                                $nbre_pages = 1;
                            }
                            ?>
                            Nombre de pages: {{ $nbre_pages }}
                        </p>
                    </div>
                    <div>Date: {{ $message->created_at->format('d-m-Y H:m:s') }}</div>
                </div>
                <div class="mt-5">
                    <h5>Liste des destinataires:</h5>
                    <div class="table-responsive-sm text-nowrap">
                        <table class="table table-striped table-sm">
                            <tbody>
                                @foreach ($cacheContacts as $cacheContact)
                                    <tr>
                                        <td>{{ $cacheContact->name }}</td>
                                        <td>{{ $cacheContact->number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            <a href="{{ route('messages.bilan') }}" class="btn btn-sm grey darken-1 white-text spinnerShower">Retour</a>
            <form action="{{ route('renvoyer.message') }}" method="post">
                @csrf
                <?php $hasard = random_int(1000, 9000); ?>
                <input type="hidden" name="msgi" id="msgi" value="#{{ $message->id }}">
                <button type="submit" class="btn btn-sm blue lighten-1 white-text spinnerShower">Renvoyer un message</button>
            </form>
        </div>
    </div>
@endsection