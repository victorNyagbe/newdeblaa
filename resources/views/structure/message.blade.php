@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end my-4 mr-5">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-green darken-1 white-text" data-toggle="modal" data-target="#basicExampleModal">
                Messages par défaut
            </button>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-12 col-md-10">
    
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                        {{ $message }}
                        <button class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                        {{ $message }}
                        <button class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
    
                <form action="{{ route('message.store') }}" method="post" class="sendMessage">
                    @csrf
                    <div class="form-group">
                        <textarea name="message" id="message" rows="6" maxlength="305" class="form-control @error('message') is-invalid @enderror" placeholder="Saisir votre message ici..."></textarea>
                        @error('message')
                            <div class="invalid-feedback">
                                {{ $errors->first('message') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <div class="mt-3 d-flex justify-content-center">
                            <a href="{{ route('structure.index') }}" class="btn grey darken-1 white-text spinnerShower">retour</a>
                            <button type="submit" class="btn btn-blue white-text sendButton">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10">
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="col-4">
                            <input type="text" name="number" id="number" placeholder="Téléphone" class="form-control" required autocomplete="off" autofocus>
                        </div>
                        <div class="col-8">
                            <input type="text" name="name" id="name" placeholder="Noms et prénoms" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group mt-3 d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-green btn-sm white-text spinnerShower insertContact" disabled>Enregistrer</button>
                    </div>
                </form>
            </div>
        </div> --}}
        {{-- <php
            $j = 0;
        ?> --}}
        {{-- @if (count($contacts) > 0)
            <div class="row justify-content-center mt-3">
                <div class="col-12 col-md-10">
                    <div class="table-responsive-sm text-nowrap">
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
                                        <th scope="row">{{ $j+1 }}</th>
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
        @endif --}}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Messages par défaut</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-3">
                    <ul class="list-group">
                        <?php $k = 1; ?>
                        @foreach ($default_messages as $default_message)
                            <li class="list-group-item">
                                <form action="{{ route('destroyDefaultMessage', $default_message->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="msg{{ $k }}" class="messageContent">{{ $default_message->content }}</div>
                                        @if (($default_message->structure_id) == session()->get('id'))
                                            <div><button type="submit" class="btn btn-sm btn-danger">Suprrimer</button></div>
                                        @endif
                                    </div>
                                    
                                </form>
                            </li>
                            <?php $k++; ?>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-blue darken-1 white-text" data-toggle="modal" data-target="#defaultMessageModal">
                        Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="defaultMessageModal" tabindex="-1" role="dialog" aria-labelledby="defaultMessageModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultMessageModalLabel">Enregistrer un message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-3">
                    <form action="{{ route('storeDefaultMessage') }}" method="post">
                        @csrf
                        <textarea name="defaultMessage" id="defaultMessage" class="form-control @error('defaultMessage') is-invalid @enderror" required autofocus rows="4"></textarea>
                        @error('defaultMessage')
                            <div class="invalid-feedback">
                                {{ $errors->first('defaultMessage') }}
                            </div>
                        @enderror
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-green darken-1 white-text spinnerShower saveDefaultMess" disabled>
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- MessageSending --}}
    <div id="MessageSending" style="display: none; position: absolute; top: 0; bottom: 0; line-height:100%; left: 0; right: 0; background-color: rgba(255,253,252, 0.5)">
        <div class="text-center gifImage" style="margin-top: 200px;">
            <img src="{{ URL::asset('assets/images/gif2.gif') }}" alt="Votre message est en cours d'envoi ..." class="w-25">
            <h4 class="text-center">Votre message est en cours d'envoi ...</h4>
        </div>
    </div>
    {{-- /.MessageSending --}}
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
           $('.messageContent').click(function() {
                let identity = $(this).attr('id');
                let text = $('#' + identity).text();
                $('textarea').val(text);
                $(this).attr('data-dismiss', 'modal');
           });
           
           $('#defaultMessage').keyup(function() {
               if ($(this).val().length >= 5) {
                    $('.saveDefaultMess').removeAttr('disabled')
               } else {
                $('.saveDefaultMess').attr('disabled', true)
               }
           });

           $('#name').keyup(function () {
                if ($('#number').val().length > 7 && $('#name').val().length > 2) {
                    $('.insertContact').removeAttr('disabled');
                } else {
                    $('.insertContact').attr('disabled', true);
                }
            });

            $('.sendMessage').submit(function() {
                $('#MessageSending').fadeIn();
                $('.gifImage').attr('class', 'text-center animated rotateIn')
            });
        });
    </script>
@endsection