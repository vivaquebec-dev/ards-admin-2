<?php 
use App\activites;

$activites = activites::all();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    @yield('title')
	<meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    @yield('css')
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Au Royaume des sons - Administration</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @if (Auth::check())
            <ul class="navbar-nav w-100">
            @if (Auth::user()->id_type_usager == 1)
                <li class="nav-item"><a href="/utilisateurs" class="nav-link">Gestion des utilisateurs</a></li>
                <li class="nav-item"><a href="/licences" class="nav-link">Gestion des licences</a></li>
            @elseif((Auth::user()->id_type_usager == 3))
                <li class="nav-item"><a href="/licences_commission" class="nav-link">Gestion des établissements</a></li>
            @elseif((Auth::user()->id_type_usager == 4))
                <li class="nav-item"><a href="/licences_ecole" class="nav-link">Gestion des professeurs</a></li>
                <li class="nav-item"><a href="/docs/procedure-admin.pdf" target="_blank" class="nav-link">Procédures</a></li>
            @elseif((Auth::user()->id_type_usager == 5))
                <li class="nav-item"><a href="/licences_prof/" class="nav-link">Gestion des élèves</a></li>
                <li class="nav-item"><a href="/tableau_resultats/" class="nav-link">Tableau des résultats</a></li>
                <li class="nav-item"><a href="/docs/procedure-admin.pdf" class="nav-link" class="nav-link" target="_blank">Procédures</a></li>
                <li class="nav-item"><a href="/docs/guide-utilisateur.pdf" class="nav-link" target="_blank">Guide de l'utilisateur</a></li>
                <li class="nav-item"><a href="/docs/informations-a-savoir.pdf" class="nav-link" target="_blank">Informations à savoir</a></li>
                <!--
                <li class="nav-item"><a href="/docs/Diplome-ARDS-20170430.pdf" target="_blank">Diplôme de réussite</a></li>
                -->
                <li class="nav-item"><a href="/docs-a-imprimer" class="nav-link">Documents à imprimer</a></li>
                @if (Auth::user()->projetRecherche == 1)
                <li class="nav-item">
                    <select name="activites" class="lst_activites">
                    <option value="0">Sélectionner l'activité de votre groupe</option>
                    @foreach ($activites as $activite)
                        @if ($activite->PREFIXE_ACTIVITES!='fn1')
                        <option value="{{$activite->PREFIXE_ACTIVITES}}" @if (Auth::user()->projetRechercheAct == $activite->PREFIXE_ACTIVITES) selected @endif>{{mb_strtoupper($activite->PREFIXE_ACTIVITES)}} {{$activite->NOM_ACTIVITES}}</option>
                        @endif
                    @endforeach
                    </select>
                </li>
                <script>
                    $('.lst_activites').on("change", function() {
                        var prefixe_activites = $(this).val();
                        var id_usager = {{Auth::user()->id_usager}};
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: '/test',
                            type: 'POST',
                            data: {_token: CSRF_TOKEN, prefixe_activites:prefixe_activites},
                            dataType: 'JSON',
                            success: function (data) { 
                                //console.log(data.prefixe_activites+' -> '+data.id_usager); 
                            }
                        }); 
                    });
                </script>
                @endif
            @endif
            <li class="nav-item ml-auto"><a href="/auth/logout" class="nav-link">Déconnexion</a></li>
        @endif
        </div>
    </nav>
    <main>
        <div class="container-fluid pt-5">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </main>
@yield('scripts')
@section('scripts')
@endsection
    <div class="footer" id="footer">
        <ul>
            <li><a href="https://auroyaumedessons.com/politique-confidentialite-produit.html" target="_blank">Politique de confidentialité</a></li>
            <li><a href="https://auroyaumedessons.com/conditionsutilisation.html" target="_blank">Conditions d'utilisation du logiciel</a></li>
        </ul>
    </div>
</body>
</html>







