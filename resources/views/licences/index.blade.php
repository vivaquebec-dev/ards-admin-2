@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Gestion des licenses</h1>
            <p><a href="/licences/create" class="btn btn-primary mt-4">Ajouter une licence</a></p>
            <form method="GET" action="{{ url('licences') }}" class="mb-4">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="order" value="{{ request('order') }}">
                <div class="input-group">
                    <input
                        type="search"
                        name="recherche"
                        value="{{ $recherche }}"
                        class="form-control"
                        placeholder="Rechercher par organisation, nom ou courriel"
                        aria-label="Rechercher une licence"
                    >
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Rechercher</button>
                    </div>
                </div>
            </form>
            <?php		
                $ordreOrg = $ordreNom = "asc";
                if (isset($_GET['sort'])) {
                    if ($_GET['sort']=="org") {
                        if (isset($_GET['order'])) {
                            if 	($_GET['order']=="asc") {
                                $ordreOrg = 'desc';
                            } elseif ($_GET['order']=="desc") {
                                $ordreOrg = 'asc';
                            }
                        }
                    }

                    if ($_GET['sort']=="nom") {
                        if (isset($_GET['order'])) {
                            if 	($_GET['order']=="asc") {
                                $ordreNom = 'desc';
                            } elseif ($_GET['order']=="desc") {
                                $ordreNom = 'asc';
                            }
                        }
                    }
                }

            ?>
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><a href="?sort=org&order=<?php echo $ordreOrg; ?>">Organisation / École</a></th>
                        <th scope="col"><a href="?sort=nom&order=<?php echo $ordreNom; ?>">Nom</a></th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nombre de license</th>
                        <th scope="col" class="nowrap">&nbsp;</th>
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
                        <td class="text-nowrap"><a href="{{ url('/licences',  $licence->id_licence) }}">Modifier</a> | <a href="{{ url('/licences/destroy',  $licence->id_licence) }}" class="text-danger">Supprimer</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
