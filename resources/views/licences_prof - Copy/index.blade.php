@extends('layouts.master')

@section('content')
    <br /><br />
    <h1>Gestion des élèves</h1>
	
    <p>Licences disponibles: {{ $availableLicences }}</p>
    
	@if ($availableLicences > 0)
    	<a href="/licences_prof/create">Ajouter un élève</a>
	@endif
    <table class="table table-bordered" id="users-table">
        <thead>
        <tr>
            <th>Nom de l'élève</th>
            <th>Prénom de l'élève</th>
             <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)

            <tr>
                <td>{{ $user->nom }}</td>
                <td>{{ $user->prenom }}</td>
                <td><a href="{{ url('/licences_prof',  $user->id_usager) }}">Modifier</a></td>
            </tr>
        @endforeach

        </tbody>
    </table>


@endsection