@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row">
            <div class="col-12">
                <h1>Gestion des établissements</h1>
                <a href="/licences_commission/create" class="btn btn-primary my-4">Ajouter un établissement</a>
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th># License</th>
                            <th>Organisation / École</th>
                            <th>Nom contact</th>
                            <th>Prénom contact</th>
                            <th>Nombre de license</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($licences as $licence)
                        <tr>
                            <td>{{ $licence->id_licence }}</td>
                            <td>{{ $licence->nom_organisation }}</td>
                            <td>{{ $licence->nom_contact }}</td>
                            <td>{{ $licence->prenom_contact }}</td>
                            <td>{{ $licence->nombre_licence }}</td>
                            <td><a href="{{ url('/licences_commission',  $licence->id_licence) }}">Modifier</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection