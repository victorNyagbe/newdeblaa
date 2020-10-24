@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end my-4 mr-5">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-grey darken-1 white-text" data-toggle="modal" data-target="#basicExampleModal">
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
                                {{ $error }}
                            @endforeach
                        </ul>
                        <button class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
    
                <form action="{{ route('message.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea name="message" id="message" rows="6" class="form-control @error('message') is-invalid @enderror" placeholder="Saisir votre message ici..."></textarea>
                        @error('message')
                            <div class="invalid-feedback">
                                {{ $errors->first('message') }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-blue white-text">Envoyer le message</button>
                    </div>
                </form>
            </div>
        </div>
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
                            <li class="list-group-item" id="msg{{ $k }}">{{ $default_message->content }}</li>
                            <?php $k++; ?>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-blue darken-1 white-text" data-toggle="modal" data-target="#defaultMessageModal">
                        Enregistrer un message
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
                            <button type="submit" class="btn btn-green darken-1 white-text" >
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
           $('li').click(function() {
                let identity = $(this).attr('id');
                let text = $('#' + identity).text();
                $('textarea').val(text);
                $(this).attr('data-dismiss', 'modal');
           });
        });
    </script>
@endsection