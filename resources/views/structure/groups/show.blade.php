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
            {{-- <div class="toastBack" style="position: absolute; top: 0; bottom: 0; line-height:100%; left: 0; right: 0; background-color: rgba(0,0,0, 0.3)">
                <div class="text-center">
                    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
                        <div class="toast-body red lighten-1 text-white">
                            <div class="d-flex float-right">
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true" class="text-white hiddenToastError">&times;</span>
                                </button>
                            </div>
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                </div>
            </div> --}}

  
            <!-- Modal -->
            <div class="modal modalError fade" id="exampleModalCenter" tabindex="-1" role="dialog"
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
        <div class="row mt-4">
            <div class="col-12 col-sm-6">
                <h3><span class="icofont icofont-users"></span> {{ $group->name }}</h3>
            </div>
            <div class="col-12 col-sm-6">
                <nav aria-label="breadcrumb float-sm-right">
                    <ol class="breadcrumb bg-white">
                      <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Mes groupes</a></li>
                      <li class="breadcrumb-item active">{{ $group->name }}</li>
                    </ol>
                  </nav>
            </div>
            <div class="col-12 mt-3">
                <button type="button" class="btn btn-sm blue darken-4 white-text" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    parametres
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('groups.edit', $group->id) }}" class="dropdown-item" title="Editer le groupe"><span class="fa fa-edit"></span> Editer le groupe</a>
                    <a href="{{ route('groups.delete', $group->id) }}" class="dropdown-item" title="Supprimer le groupe"><span class="fa fa-trash"></span> Supprimer le groupe</a>
                </div>
            </div>
            <div class="col-12 mt-4">
                <p>Nombre de membres : {{ count($group->contacts) }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6">
                <a href="{{ route('groups.addContactView', $group->id) }}" class="btn btn-sm btn-light-green white-text" title="ajouter un contact"><span class="fa fa-user-plus"></span> Ajouter contact</a>
            </div>
            <div class="col-12 col-sm-6 mt-2 float-sm-right">
                <a href="#" class="btn btn-sm btn-blue white-text float-sm-right spinnerShower" id="sendMessageButton"
                onclick="event.preventDefault(); document.getElementById('selectContactByGroupForm').submit();">message</a>
            </div>
        </div>

        <form action="{{ route('structure.sendMessageByGroupProcessing') }}" method="post" id="selectContactByGroupForm">
            @csrf
            <div class="row mt-1">
                <?php $compteur = 0; ?>
                @if (count($group->contacts) > 0)
                    <div class="col-12">
                        <div class="py-3 px-2">
                            <input type="checkbox" class="allContacts" id="all">
                            <label for="all" class="font-weight-bold"><b>Sélectionner tous les contacts</b></label>
                        </div>
                    </div>
                @endif
                @foreach ($group->contacts as $contact)
                        <?php $compteur++; ?>
                    <div class="col-12 mb-md-3">
                        <div class="py-3 px-2 border-bottom">
                            <span>
                                <input type="checkbox" name="contactToBeChecked[]" value="{{ $contact->number }}" class="contactCheckedBox" id="contactToBeChecked{{ $compteur }}">
                            </span>
                            <span><label for="contactToBeChecked{{ $compteur }}">{{ $contact->name }}</label></span>
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
            $('.toast').toast('show')
            $('.modalError').modal('show')
            $('.hiddenToastError').click( function () {
                $('.toastBack').hide();
            });
        })
    </script>
@endsection