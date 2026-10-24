@extends('layouts.master')
@section('content')
    <div id="bg_popup_lic_prof" class="{{ request()->cookie('licprof_consent') === '1' ? 'd-none' : '' }}">
        <div class="popup_lic_prof">
            <p>La sélection des activités comme mode de fonctionnement généralisé empêche l'élève de progresser à son rythme. Toujours utiliser la sélection des activités pour ses élèves peut nuire au bon fonctionnement du jeu. La sélection des activités doit être utilisée occasionnellement et préférablement pour peu d'élèves à la fois. Cette option a été ajoutée au Royaume des sons pour permettre à l'enseignant(e) de vérifier si l'élève maîtrise tel ou tel objectif de la conscience phonologique. </p>
            <button class="accept_popup_lic_prof">J'ai compris</button>
        </div>
    </div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-12">
                <h1>Gestion des élèves</h1>
                <p class="mb-0 mt-4">Licences disponibles: {{ $availableLicences }}</p>
                @if ($availableLicences > 0)
                    <a href="/licences_prof/create" class="btn btn-primary my-4">Ajouter un élève</a>
                @endif
                <table class="table table-bordered" id="users-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Activité sélectionnée
                        <p class="text-danger small mb-0">
                            IMPORTANT: L'élève fera à nouveau l'activité que vous avez sélectionnée lorsqu'il retournera <br>dans sa progression, <u>son étoile restera blanche et il n’aura pas accès à l’activité récompense</u>.</p>
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nom }}</td>
                            <td>{{ $user->prenom }}</td>
                            <td>@if ($user->projetRechercheAct != "0" && $user->projetRechercheAct != "") {{ $user->projetRechercheAct }} @else N/A @endif</td>
                            <td><a href="{{ url('/licences_prof',  $user->id_usager) }}">Modifier</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<script>
    document.querySelector('.accept_popup_lic_prof').addEventListener('click', function(e) {
        e.preventDefault();

        const consentementElement = document.getElementById('bg_popup_lic_prof');

        if (consentementElement) {
            fetch('{{ route('licences_prof.consent') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                consentementElement.remove();
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        }
    });
</script>
@endsection
