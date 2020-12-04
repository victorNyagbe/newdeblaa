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
            <div class="modal modalErrorAddContacts fade" id="exampleModalCenter" tabindex="-1" role="dialog"
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
        @if ($errors->any())
            <ul class="alert alert-danger alert-dismissible fade show my-3 list-unstyled" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="row mt-4">
            <div class="col-12 col-sm-6">
                <h3><span class="icofont icofont-shield-alt"></span> {{ $group->name }}</h3>
            </div>
            <div class="col-12 col-sm-6">
                <nav aria-label="breadcrumb float-sm-right">
                    <ol class="breadcrumb bg-white">
                      <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Mes groupes</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('groups.show', $group->id) }}">{{ $group->name }}</a></li>
                      <li class="breadcrumb-item active">Ajouter contact</li>
                    </ol>
                  </nav>
            </div>
            <div class="col-12 mt-4">
                <p>Nombre de membres : {{ count($group->contacts) }}</p>
            </div>

            <div class="col-12 col-md-10 mt-3">
                <form action="{{ route('groups.storeContactProcessing', $group->id) }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <input type="text" name="number" id="number" placeholder="Téléphone du contact" @error('number') is-invalid @enderror class="form-control" required autocomplete="off" autofocus>
                            @error('number')
                                <div class="inavlid-feedback">
                                    {{ $errors->first('number') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name" placeholder="Nom complet du contact" @error('name') is-invalid @enderror class="form-control" required autocomplete="off">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-green btn-sm white-text spinnerShower insertContact" disabled>Enregistrer</button>
                    </div>
                </form>
            </div>

        </div>
        <form action="{{ route('groups.storeContactByListOfContactProcessing', $group->id) }}" method="post"  id="storeContactToGroupByListForm">
            @csrf   
            <div class="row">
                <?php $compteur = 0; ?>
                <div class="col-12 my-3">
                    <small class="red-text mb-2">Sélectionner des contacts que vous voulez ajouter à ce groupe</small>
                    <h5>Mes contacts</h5>
                    <div class="mt-0" style="border-bottom: 2px solid #000; width: 3rem"></div>
                </div>
                <div class="col-12">
                    <a href="#" class="btn btn-sm btn-success disabled float-right" id="addContactsToGroup"
                     onclick="event.preventDefault(); document.getElementById('storeContactToGroupByListForm').submit();">Ajouter</a>
                </div>
                <div class="col-12">
                    @if (count($contact_collections) > 0)
                        <div class="py-3 px-2">
                            <input type="checkbox" class="allContacts" id="all">
                            <label for="all" class="font-weight-bold"><b>Sélectionner tous les contacts</b></label>
                        </div>
                    @endif
                </div>
                @foreach ($contact_collections as $contact_collection)
                    <?php $compteur++; ?>
                    <div class="col-12 mb-md-3">
                        <div class="py-3 px-2 border-bottom">
                                <span>
                                    <input type="checkbox" name="contactToBeChecked[]" value="{{ $contact_collection["number"] }}" class="contactCheckedBox" id="contactToBeChecked{{ $compteur }}">
                                </span>
                                <span><label for="contactToBeChecked{{ $compteur }}">{{ $contact_collection["name"] }}</label></span>
                        </div>
                    </div>
                @endforeach
            </div>     
        </form>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
            $('#name').keyup(function () {
                if ($('#number').val().length > 7 && $('#name').val().length > 2) {
                    $('.insertContact').removeAttr('disabled');
                } else {
                    $('.insertContact').attr('disabled', true);
                }
            });
            $(".allContacts").change(function () {
                $(".contactCheckedBox").prop("checked", $(this).prop("checked"));
                $('#addContactsToGroup').toggleClass('disabled');
            });
            $('.contactCheckedBox').click(function () {
                let countContactChecked = $('input:checked').length;
                if (countContactChecked >= 1) {
                    $('#addContactsToGroup').removeClass('disabled');
                } else {
                    $('#addContactsToGroup').addClass('disabled');
                }
            });

            $('.modalErrorAddContacts').modal('show');
        });
    </script>
@endsection