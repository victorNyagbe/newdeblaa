@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex mt-4 mb-0">
            <h5>Liste des statistiques de messages des structures</h5>
        </div>
        <hr class="mt-0 grey darken-4">
        <?php
            $messages_count = 0;                             
        ?>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10">
                <div class="table-responsive-sm text-nowrap">
                    <table class="table table-striped table-sm table-bordered">
                        <thead class="light-blue darken-2 white-text">
                            <tr>
                                <th scope="col">Structure</th>
                                <th scope="col" width="150">Nbre de messages</th>
                                <th scope="col" width="150">Destinataires</th>
                                <th scope="col" width="150" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < sizeof($tab); $i++)
                                
                                <tr>
                                    <td>{{ $tab[$i]["nom_structure"] }}</td>
                                    <td>{{ $tab[$i]["nbre_messages"] }}</td>
                                    <td>{{ $tab[$i]["destinataires"] }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.statistiqueShow', $tab[$i]["structure_id"]) }}" class="btn btn-blue btn-sm"><span class="icofont icofont-eye"></span> voir</a>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection