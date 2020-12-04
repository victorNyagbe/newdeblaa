@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="row mt-5 justify-content-center">
            @if ($errors->any())
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if ($message = Session::get('success'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @unless ($message = Session::get('success'))
                <div class="col-12 col-md-8">
                    <form action="{{ route('structure.validerTicket') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col-8">
                                <input type="text" name="code_ticket" id="code_ticket" class="form-control" placeholder="Saisir le code ticket ici..." value="{{ old('code_ticket') }}" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-sm btn-green white-text mt-0 rounded">valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endunless
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 mt-3 border border-light z-depth-2 py-5">
                <h3 class="h3-respnsive text-center">Vous avez {{ session()->get('message_payer') }} sms</h3>
            </div>
        </div>
    </div>
@endsection