@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row">
            <div class="col-12">
                <h1>Gestion des professeurs</h1>
                <a href="/licences_ecole/create" class="btn btn-primary my-4">Ajouter un professeur</a>
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Nombre de license</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($licences as $licence)
                        <tr>
                            <td>{{ $licence->nom_contact }}</td>
                            <td>{{ $licence->prenom_contact }}</td>
                            <td>{{ $licence->nombre_licence }}</td>
                            <td><a href="{{ url('/licences_ecole',  $licence->id_licence) }}">Modifier</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection