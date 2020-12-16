@extends('layouts.app')

@section('content')
    <main class="container">
        <div class="d-flex justify-content-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicExampleModal">
                Ajouter une structure
            </button>
        </div>
        <h4 class="mt-4">Liste des structures</h4>
        <hr>
        <div class="row">
            <div class="col-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
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
                        <button type="button" class="close" aria-label="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive-sm text-nowrap">
                    <table class="table table-hover">
                        <thead class="white-text blue lighten-2">
                            <tr>
                                <th scope="col">Nom de la structure</th>
                                <th scope="col">Messages envoyés</th>
                                <th scope="col">Destinataires</th>
                                <th scope="col" class="text-center" width="100" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($structures as $structure)
                                <tr>
                                    <?php
                                        $allmessages = count($structure->messages);
                                        $destinataires = 0;
                                        for ($i = 0; $i < $allmessages; $i++) {
                                            $destinataires += $structure->messages[$i]->destinataires;
                                        }
                                    ?>
                                    <td>{{ $structure->name }}</td>
                                    <td>{{ count($structure->messages) }}</td>
                                    <td>{{ $destinataires }}</td>
                                    <td class="btn-group">
                                        <form action="{{ route('admin.structureDestroy', $structure->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('admin.structureShow', $structure->id) }}" class="btn btn-primary btn-sm p-2 mt-0"><span class="icofont icofont-2x icofont-eye"></span></a>
                                            <button type="submit" class="btn btn-sm btn-danger p-2" onclick="return confirm('Êtes-vous certain de vouloir supprimer cette structure?')"><span class="icofont icofont-2x icofont-trash"></span></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </main>
@endsection