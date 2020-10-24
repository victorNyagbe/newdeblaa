<?php  $structure = \App\Models\Structure::findOrFail(session()->get('id'))?>
<div class="mt-2 mb-2"></div>
<div class="mt-2"></div>
<div class="card border-warning font-size-14">
    <div class="card-header">
        Messages en réserve
    </div>
    <div class="card-body text-center">
        <h4 class="card-title text-center">
            @if (session()->get('pro') == 0)
                {{ session()->get('message_bonus') }}
            @else
                {{ session()->get('message_payer') }}
            @endif
        </h4>
        <p class="card-text">
            @if (session()->get('pro') == 0)
                Il vous reste {{ session()->get('message_bonus') }} essais de messages sur votre compte.
            @else
                Il vous reste {{ session()->get('message_payer') }} {{ \Illuminate\Support\Str::plural('message', session()->get('message_payer')) }} sur votre compte.
            @endif
        </p>
    </div>
</div>

<br />

<div class="card border-primary">
    <div class="card-header">
        <i class="icofont-chart-bar-graph"></i>
        Statistiques
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="{{ route('sListeMessage') }}" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ count($messageCount) }}</h5>
                    <small>Détails</small>
                </div>
                <p class="mb-1">Messages envoyés</p>
                <small>Plus de détails</small>
            </a>
            <a href="{{ route('sListeMembre') }}" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ count($userCount) }}</h5>
                    <small>Détails</small>
                </div>
                <p class="mb-1">Membres</p>
                <small>Plus de détails</small>
            </a>
            <a href="{{ route('sListeGroupe') }}" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ count($groupes) }}</h5>
                    <small>Détails</small>
                </div>
                <p class="mb-1">Groupes</p>
                <small>Plus de détails</small>
            </a>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a href="{{ route('sBilanMessage') }}">
            Bilan des messages
        </a>
    </div>
</div><br />

<div class="card border-success">
    <div class="card-body">
        <h4 class="card-title">Infos compte</h4>
        <p class="card-text">
            Sigle : {{ session()->get('sigle') }}<br />
            @ : {{ session()->get('email') }} <br />
        </p>

        @if (session()->get('logo') == "")
            <div style="height: 100px; line-height: 100px;" class="orange text-center rounded">
                <b>Votre logo</b>
            </div>
        @else
            <img src="{{ URL::asset('db/logos/structure/'.session()->get('logo')) }}" alt="logo-structure" width="100%">
        @endif

        <div class="text-center">
            <br />
            <a href="{{ route('sCompte', $structure) }}">
                <i class="icofont-pencil"></i>Modifier le profil
            </a>
        </div>
    </div>
</div><br /><br />
