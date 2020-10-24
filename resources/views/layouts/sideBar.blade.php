@extends('layouts.header')

@section('css')
    <style>
        a:hover {
            text-decoration: none;
        }
        .side-bar-item a div.item {
            border-bottom: 1px solid #DDD;
            font-size: 13px;
            padding: 14px;
        }
        .side-bar-item a div {
            font-size: 13px;
            padding: 5px;
            color: #222;
        }
        .side-bar {
            width: 18%;
        }
        .asside-content {
            width: 82%;
        }
        .comfortaa {
            font-family: comfortaa;
        }
        .menu-item-sm-show {
            display: none;
        }
        @font-face {
            font-family: comfortaa;
            src: url("{{ URL::asset('fonts/Comfortaa-Regular.ttf') }}");
        }
        @media (max-width: 1000px) {
            .side-bar {
                width: 18%;
            }
            .asside-content {
                width: 82%;
            }
            .menu-item-sm-hide {
                display: none;
            }
            .side-bar-item div a div.item {
                text-align: center;
            }
            .side-bar-item div a div.item i {
                font-size: 18px;
            }
        }
        @media (max-width: 1000px) {
            .menu-item-sm-show {
                display: block;
            }
        }
    </style>
@endsection

@section('sideBar')
    <div class="side-bar indigo lighten-5">
        <a href="{{ route('main.home') }}">
            <div class="indigo p-1 darken-1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 p-0">
                            <!--<img src="{{ URL::asset('assets/images/deblaa.png') }}" alt="logo" width="100%">-->
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 4px 0 5px 0;">
                            <b class="font-weight-bold">
                                <small class="white-text comfortaa">Deblaa<span class="menu-item-sm-hide"> - STRUCTURE</span></small>
                            </b>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('structure.showProfile') }}">
            <div class="logo p-2 indigo lighten-4 black-text">
                <table width="100%">
                    <tr>
                        <td width="45">
                            <div style="width: 45px; height: 45px; overflow: hidden;" class="rounded-circle">
                                @if (session()->get('image') == null)
                                    <div style="width: 45px; height: 45px; line-height: 45px;" class="orange text-center">
                                        <b>Logo</b>
                                    </div>
                                @else
                                    <img src="{{ URL::asset('storage/'.session()->get('image')) }}" alt="logo-structure" width="100%">
                                @endif
                            </div>
                        </td>
                        <td class="menu-item-sm-hide">
                            <a href="{{ route('structure.showProfile') }}" class="ml-2 black-text text-decoration-none">
                                <small>{{ session()->get('name') }}</small>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </a>

        <div class="side-bar-item">
            <div>
                <a href="{{ route('structure.message') }}">
                    <div class="item d-block d-md-none">
                        <i class="icofont-envelope spinnerShower"></i><br>
                        <span class="spinnerShower" style="font-size: 8px;"><b>Message</b></span>
                    </div>
                    <div class="item d-none d-md-block d-lg-none">
                        <i class="icofont-envelope spinnerShower"></i><br>
                        <span class="spinnerShower" style="font-size: 8px;"><b>Envoyer un message</b></span>
                    </div>
                    <div class="item d-none d-lg-block">
                        <i class="icofont-envelope spinnerShower"></i>&nbsp;
                        <span class="spinnerShower"><b>Envoyer un message</b></span>
                    </div>
                </a>
            </div>
            <div class="accordion" id="accordionExample">
                <div class="z-depth-0">
                    <div id="headingFour">
                        <a href="#!" data-toggle="collapse" data-target="#collapseFour"
                        aria-expanded="true" aria-controls="collapseFour">
                            <div class="item d-block d-md-none">
                                <i class="icofont-ui-settings"></i><br>
                                <span style="font-size: 8px;"><b>Compte</b></span>
                            </div>
                            <div class="item d-none d-md-block d-lg-none">
                                <i class="icofont-ui-settings"></i><br>
                                <span style="font-size: 8px;"><b>Gestion de compte</b></span>
                            </div>
                            <div class="item d-none d-lg-block">
                                <i class="icofont-ui-settings"></i>&nbsp;
                                <span><b>Gestion de compte</b></span>
                            </div>
                        </a>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                        <div class="text-center px-md-4">
                                <a href="{{ route('structure.showProfile') }}">
                                    <div class="d-block d-md-none">
                                        <i class="icofont-user spinnerShower"></i><br>
                                        <span  class="spinnerShower" style="font-size: 8px;">Profil</span>
                                    </div>
                                    <div class="d-none d-md-block d-lg-none">
                                        <i class="icofont-user spinnerShower"></i><br>
                                        <span  class="spinnerShower" style="font-size: 8px;">Afficher le profil</span>
                                    </div>
                                    <div class="d-none d-lg-block">
                                        <i class="icofont-user spinnerShower"></i>&nbsp;
                                        <span class="spinnerShower">Afficher le profil</span>
                                    </div>
                                </a>
                            <a href="{{ route('structure.logout') }}">
                                <div class="d-block d-md-none"><br>
                                    <i class="icofont-power spinnerShower"></i>
                                    <span  class="spinnerShower" style="font-size: 8px;">Deconnexion</span>
                                </div>
                                <div class="d-none d-md-block d-lg-none">
                                    <i class="icofont-power spinnerShower"></i><br>
                                    <span  class="spinnerShower" style="font-size: 8px;">Deconnexion</span>
                                </div>
                                <div class="d-none d-lg-block">
                                    <i class="icofont-power spinnerShower"></i>&nbsp;
                                    <span class="spinnerShower">Deconnexion</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pl-2 pr-2">
                <span class="menu-item-sm-hide">
                    &nbsp;<small><b><span>STATISTIQUES</span></b></small>
                </span><br class="menu-item-sm-hide" />
                <div>
                    <a href="{{ route('messages.bilan') }}">
                        <div class="item d-block d-md-none" style="border: none;">
                            <i class="icofont-chart-bar-graph spinnerShower"></i><br>
                            <b><span class="spinnerShower" style="font-size: 8px;">Bilan</span></b>
                        </div>
                        <div class="item d-none d-md-block d-lg-none" style="border: none;">
                            <i class="icofont-chart-bar-graph spinnerShower"></i>
                            <b><span class="spinnerShower" style="font-size: 8px;">Bilan des messages</span></b>
                        </div>
                        <div class="item d-none d-lg-block" style="border: none;">
                            <i class="icofont-chart-bar-graph spinnerShower"></i>
                            <b><span class="spinnerShower">Bilan des messages</span></b>
                        </div>
                    </a>
                </div><br />
            </div>

        </div>
    </div>
    <div class="asside-content font-size-14">
        <div class="p-2 border-bottom indigo lighten-5">
            <table width="100%">
                <tr>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="#!" id="dropdownId" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                                <i class="icofont-navigation-menu"></i>
                            </a>
                            <div class="dropdown-menu font-size-14" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="{{ route('structure.showProfile') }}">Paramètres de compte</a>
                                <a class="dropdown-item" href="{{ route('structure.logout') }}">Déconnexion</a>
                            </div>
                        </div>
                        <a href="#!" id="dropdownId" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                            <small><b>PANNEAU DE CONFIGURATION</b></small>
                        </a>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('structure.logout') }}" title="Se déconnecter" class="btn btn-danger p-0 rounded m-0 z-depth-0"
                        style="width: 22px; height: 22px; line-height: 22px;">
                            <i class="icofont-power"></i>   
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        @yield('content')

    </div>

@endsection