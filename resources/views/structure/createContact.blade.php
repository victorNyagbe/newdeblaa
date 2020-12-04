@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="mt-4">
            <label class="mb-0">Enregistrer vos contacts</label>
            <hr class="grey darken-3">
        </div>
        @if ($message = Session::get('success'))
            <div class="row">
                <div class="col-12">     
                    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>    
                </div>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="row">
                <div class="col-12">     
                    <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>    
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <a href="{{ route('structure.contact') }}" class="btn btn-amber white-text btn-sm ml-md-5">Mes contacts</a>
                <a href="{{ route('groups.index') }}" class="btn btn-amber btn-sm white-text">Mes groupes</a>
            </div>
        </div>
    
        <?php
            $k = 1;
        ?>
        @if (count($contacts) > 0)
            
            <div class="row justify-content-center mt-3">
                <div class="col-12 col-md-10">
                    <div class="table-responsive-sm table-responsive-md text-nowrap">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Noms et prénoms</th>
                                    <th scope="col" class="text-center" width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <th scope="row">{{ $k++ }}</th>
                                        <td>{{ $contact->number }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>
                                            <form action="{{ route('contact.delete', $contact->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <button type="submit" class="btn btn-sm btn-red white-text my-1 spinnerShower">Supprimer</button>
                                            </form>
                                        </td>   
                                    </tr>
                                @endforeach                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10">
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="col-12 mb-3 mb-md-0 col-md-4">
                            <input type="text" name="number" id="number" placeholder="Entrer un nouveau contact" class="form-control" required autocomplete="off" autofocus>
                        </div>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name" placeholder="Nom complet du contact" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group mt-3 d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-green btn-sm white-text spinnerShower insertContact" disabled>Enregistrer</button>
                        <a href="{{ route('structure.message') }}" class="btn btn-blue white-text btn-sm spinnerShower">Message</a>
                    </div>
                </form>
            </div>
        </div>
        <div id="contactForm"></div>
    </div>
    {{-- Spinner --}}
    <div id="spinner" style="display: none; position: absolute; top: 0; bottom: 0; line-height:100%; left: 0; right: 0; background-color: rgba(0,0,0, 0.5)">
        <div class="text-center" style="margin-top: 200px;">
            <img src="{{ URL::asset('assets/images/spinner.svg') }}" alt="loading ..." width="100px;">
        </div>
    </div>
    {{-- /.Spinner --}}
@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {
            let scrollToBottom = $("#contactForm").offset().top + $(this).height()
            $('html, body').animate({
                scrollTop: scrollToBottom
            }, 2000);

            $('#name').keyup(function () {
                if ($('#number').val().length > 7 && $('#name').val().length > 2) {
                    $('.insertContact').removeAttr('disabled');
                } else {
                    $('.insertContact').attr('disabled', true);
                }
            });
        });
    </script>
@endsection