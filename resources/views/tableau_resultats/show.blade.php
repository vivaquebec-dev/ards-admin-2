@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Résultat pour l'élève : {{ $utilisateur->nom }}, {{ $utilisateur->prenom }}<br />Activité : {{ $activite->NOM_ACTIVITES }}</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Oups!</strong> Vous devez corriger les erreur(s) suivante(s)<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- <form class="form-horizontal" role="form" method="POST" action=""> -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Détails</label>
                                <div class="col-md-6">
                                    <?php $count = 1; ?>
                                    @foreach ($resultats as $resultat)
                                    	<?php 
										$nbExercice = $activite->NB_EXERCICES;
										if ($resultat->nbExercice!=0) {
											$nbExercice=$resultat->nbExercice;
										}
										?>
                                        Note #{{ $count }} : {{ $resultat->resultat }} / {{ $nbExercice }}<br />
                                        <?php $count++; ?>
                                    @endforeach

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <a href="/tableau_resultats">Retour au tableau des résultats</a>
                                    </button>
                                </div>

                            </div>
                       <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
