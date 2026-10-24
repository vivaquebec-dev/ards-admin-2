@extends('layouts.master')
@section('content')
<div class="container pb-5">
    <div class="row">
        <div class="col-12">
            <h1>Gestion des utilisateurs</h1>
            <p><a href="utilisateurs/create" class="btn btn-primary mt-4">Ajouter un utilisateur</a></p>
            <form method="GET" action="{{ url('utilisateurs') }}" class="mb-4">
                <div class="input-group">
                    <input
                        type="search"
                        name="recherche"
                        value="{{ $recherche }}"
                        class="form-control"
                        placeholder="Rechercher par nom, prénom ou courriel"
                        aria-label="Rechercher un utilisateur"
                    >
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Rechercher</button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Nom d'utilisateur</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($utilisateurs as $utilisateur)
                    <tr>
                        <td>{{ $utilisateur->id_usager }}</td>
                        <td>{{ $utilisateur->nom }}</td>
                        <td>{{ $utilisateur->prenom }}</td>
                        <td>{{ $utilisateur->email }}</td>
                        <td><a href="{{ url('/utilisateurs',  $utilisateur->id_usager) }}">Modifier</a> | <a href="{{ url('/utilisateurs/destroy',  $utilisateur->id_usager) }}">Supprimer</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
