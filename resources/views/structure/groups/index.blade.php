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
        <div class="modal modalErrorGroup fade" id="exampleModalCenter" tabindex="-1" role="dialog"
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
    <div class="mt-4">
        <div class="row">
            <div class="mb-sm-0 col-12 col-sm-6">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-green btn-sm text-white" data-toggle="modal" data-target="#basicExampleModal">
                    ajouter un groupe
                </button>
    
                
                <!-- Modal -->
                <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter un groupe</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <form action="{{ route('groups.store') }}" method="POST" id="permanentContactForm">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" placeholder="Le nom du groupe" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-green btn-sm white-text spinnerShower storeGroup" disabled>Enregistrer</button>
                                </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <a href="{{ route('structure.message') }}" class="btn btn-blue btn-sm white-text float-sm-right spinnerShower" id="sendMessageButton"
                onclick="event.preventDefault(); document.getElementById('contactsLinkToMessageForm').submit();"
                >Message</a>
            </div>
        </div>
    </div>

    <form action="{{ route('structure.sendMessageByAllGroupProcessing') }}" method="post" id="contactsLinkToMessageForm">
        @csrf
        <div class="row mt-4">
            <?php $compteur = 0; ?>
            <div class="col-12">
                <div class="table-responsive-sm table-responsive-md text-nowrap">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="50"><input type="checkbox" class="allGroups font-weight-bold" id="all"></th>
                                <th class="font-weight-bold">Nom du groupe</th>
                                <th class="text-center font-weight-bold" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <?php $compteur++; ?>
                                <tr>
                                    <td><input type="checkbox" name="groups[]" value="{{ $group->id }}" class="groupCheckedBox" id="group{{ $compteur }}"></td>
                                    <td><label for="group{{ $compteur }}">{{ $group->name }}</label></td>
                                    <td class="text-center">
                                        {{-- <a href="{{ route('groups.addContactView', $group->id) }}" class="btn btn-sm btn-blue white-text" title="ajouter un contact"><span class="fa fa-user-plus"></span></a> --}}
                                        <a href="{{ route('groups.show', $group->id) }}" class="btn btn-sm btn-light-blue white-text" title="voir le groupe">VOIR</a>
                                        {{-- <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-sm btn-amber white-text" title="Editer le groupe"><span class="fa fa-edit"></span></a> --}}
                                        {{-- <a href="{{ route('groups.delete', $group->id) }}" class="btn btn-sm btn-red white-text p-1" title="Supprimer le groupe"><span class="fa fa-trash"></span></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {
            $('#name').keyup(function () {
                if ($('#name').val().length >= 3) {
                    $('.storeGroup').removeAttr('disabled');
                } else {
                    $('.storeGroup').attr('disabled', true);
                }
            });

            $(".allGroups").change(function () {
                $(".groupCheckedBox").prop("checked", $(this).prop("checked"));
                // $('#sendMessageButton').toggleClass('disabled');
            });

            // $('.groupCheckedBox').click(function () {
            //     let countContactChecked = $('input:checked').length;
            //     if (countContactChecked >= 1) {
            //         $('#sendMessageButton').removeClass('disabled');
            //     } else {
            //         $('#sendMessageButton').addClass('disabled');
            //     }
            // });

            $('.modalErrorGroup').modal('show');
        });
    </script>
@endsection