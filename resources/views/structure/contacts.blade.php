@extends('layouts.sideBar')

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="row mt-2">
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
            <!-- Modal -->
            <div class="modal modalErrorContacts fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content red lighten-1">
                        <div class="modal-body text-white">
                            {{ $message }}
                            <button type="button" class="close fa-2x" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="text-white">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($errors->any())
            <ul class="list-unstyled alert alert-danger alert-dismissible fade show my-3" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="mt-4">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-green btn-sm text-white" data-toggle="modal" data-target="#basicExampleModal">
                        ajouter un contact
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un contact</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <form action="{{ route('structure.storePermanentContact') }}" method="POST" id="permanentContactForm">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                                <input type="text" name="number" id="number" @error('number') is-invalid @enderror placeholder="Numéro de téléphone" class="form-control" required autocomplete="off" autofocus>
                                                @error('number')
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('numbber') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <input type="text" name="name" id="name" @error('name') is-invalid @enderror placeholder="Nom complet du contact" class="form-control" required autocomplete="off">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-green btn-sm white-text spinnerShower insertContact" disabled>Enregistrer</button>
                                    </div>    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                    <a href="{{ route('structure.message') }}" class="btn btn-blue btn-sm white-text float-sm-right spinnerShower" id="sendMessageButton"
                    onclick="event.preventDefault(); document.getElementById('contactsLinkToMessageForm').submit();"
                    >Message</a>
                </div>
            </div>
        </div>

        <form action="{{ route('structure.contactPermanentLinkToMessage') }}" method="post" id="contactsLinkToMessageForm">
            @csrf
            <div class="row mt-4">
                <?php $compteur = 0; ?>
                @if (count($contactPermanents) > 0)
                    <div class="col-12">
                        <div class="py-3 px-2">
                            <input type="checkbox" class="allContacts" id="all">
                            <label for="all" class="font-weight-bold"><b>Sélectionner tous les contacts</b></label>
                        </div>
                    </div>
                @endif
                @foreach ($contactPermanents as $contactPermanent)
                        <?php $compteur++; ?>
                    <div class="col-12 mb-md-3">
                        <div class="py-2 px-2 border-bottom d-flex justify-content-between align-items-center">
                            <div class="mb-0">
                                <input type="checkbox" name="contactToBeChecked[]" value="{{ $contactPermanent->number }}" class="contactCheckedBox" id="contactToBeChecked{{ $compteur }}">
                                <label for="contactToBeChecked{{ $compteur }}">{{ $contactPermanent->name }}</label></span>
                            </div>
                            <div class="mb-0">
                                <a href="{{ route('structure.editContactPermanent', $contactPermanent->id) }}" class="btn btn-sm btn-amber white-text p-2 spinnerShower" title="editer le contact"><span class="icofont-edit"></span></a>
                                <a href="{{ route('structure.destroyContactPermanentProcessing', $contactPermanent->id) }}" class="btn btn-sm btn-red white-text p-2 ml-0 spinnerShower" title="supprimer le contact"><span class="icofont-trash"></span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {
            $('#name').keyup(function () {
                if ($('#number').val().length > 7 && $('#name').val().length > 2) {
                    $('.insertContact').removeAttr('disabled');
                } else {
                    $('.insertContact').attr('disabled', true);
                }
            });

            $(".allContacts").change(function () {
                $(".contactCheckedBox").prop("checked", $(this).prop("checked"));
                // $('#sendMessageButton').toggleClass('disabled');
            });

            // $('.contactCheckedBox').click(function () {
            //     let countContactChecked = $('input:checked').length;
            //     if (countContactChecked >= 1) {
            //         $('#sendMessageButton').removeClass('disabled');
            //     } else {
            //         $('#sendMessageButton').addClass('disabled');
            //     }
            // });

            $('.modalErrorContacts').modal('show');
        });
    </script>
@endsection

