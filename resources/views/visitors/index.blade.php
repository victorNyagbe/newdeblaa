@extends('layouts.master')

@section('homecss')
    <style>

        div.deblaa {
            
            font-size: 94px;
            font-family: comfortaa;
            margin-top: 70px;
        }

        .mmsText {
            font-size: 60px;
            font-family: comfortaa;
        }

        .comfortaa {
            font-family: comfortaa;
        }

        @font-face {
            font-family: comfortaa;
            src: url(fonts/Comfortaa-Regular.ttf);
        }
        
        @media(max-width: 720px) {
            div.deblaa {
                font-size: 60px;
                font-family: comfortaa;
                margin-top: 130px;
            }

            .mmsText {
                font-size: 25px;
                font-family: comfortaa;
            }
        }

        body {
            background-image: url(assets/images/1.jpg);
        }
    </style>
@endsection

@section('navbar')
    <nav class="navbar navbar-expand-sm navbar-dark indigo comfortaa">
        <a href="{{ route('main.home') }}" class="comfortaa" style="margin-left: -10px; margin-right: 10px;">
            <img src="{{ URL::asset('assets/images/deblaa.png') }}" width="50" alt="logo">
        </a>
        <a class="navbar-brand comfortaa white-text font-weight-bold" href="{{ route('main.home') }}">
            Deblaa
        </a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="icofont-navigation-menu"></i>
        </button>
        <div class="collapse navbar-collapse comfortaa" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 font-size-14">

            </ul>
            <form class="form-inline my-2 my-lg-0" style="font-size: 13px;">

                <a class="nav-link white-text" href="{{ route('main.home') }}"><b>Accueil</b></a>

                <a class="nav-link white-text" href="#}"><b>En savoir plus</b></a>

                <a class="nav-link white-text" href="#"><b>Contactez-nous</b></a>

                <a class="nav-link white black-text font-weight-bold" href="#"><b>Connexion</b></a>
            </form>
        </div>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="deblaa text-center">
                    <span class="indigo-text">Deb</span><span class="orange-text">laa</span>
                </div>

                <div class="mmsText text-center text-white">
                    <span>Professionnal Communication Gate</span>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a class="white black-text px-5 py-2 rounded" href="#"><b>Connexion</b></a>
        </div>
    </div>
@endsection