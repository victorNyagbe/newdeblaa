@extends('layouts.sideBar')

@section('content')
    <div class="container">
        <div class="mt-4">
            <label class="mb-0">Enregistrer vos contacts</label>
            <hr class="grey darken-3">
        </div>
        <div class="row">
            <div class="col-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                        {{ $message }}
                        <button class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <contact-list></contact-list>
        <div id="contactForm"></div>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {
            let scrollToBottom = $("#contactForm").offset().top + $(this).height()
            $('html, body').animate({
                scrollTop: scrollToBottom
            }, 2000);
        });
    </script>
@endsection