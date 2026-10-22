@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header">Éditez un élève</div>
                        <div class="card-body">
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
                            @foreach ($users as $user)
                            <form id="form" role="form" method="POST" action="/licences_prof/update/{{ $user->id_usager }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="id_usager" name="id_usager" value="{{ $user->id_usager  }}">
                                <input type="hidden" id="id_usager" name="id_eleve" value="{{ $user->id_eleve  }}">
                                <div class="form-group" id="section_nom_contact">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom" value="{{ $user->nom }}" disabled>
                                </div>
                                <div class="form-group" id="section_prenom_contact">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" id="prenom" value="{{ $user->prenom }}" disabled>
                                </div>
                                <div class="form-group" id="section_prenom_contact">
                                    <label for="ddlSexe">Sexe</label>
                                    <select id="ddlEstActif" name="ddlSexe" id="ddlSexe" class="form-control" disabled>
                                        <option value="">Veuillez sélectionner le sexe</option>
                                        <option value="G" @if ($user->sexe == 'G') selected @endif>Garçon</option>
                                        <option value="F" @if ($user->sexe == 'F') selected @endif>Fille</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nom_utilisateur">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" name="nom_utilisateur" id="nom_utilisateur" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="mot_de_passe">Mot de passe</label>
                                    <input type="password" class="form-control" name="mot_de_passe" id="mot_de_passe" value="{{ $user->password }}">
                                </div>
                                <div class="form-group">
                                    <label for="activites">Sélectionné une activité</label>
                                    <select name="activites" id="activites" class="lst_activites_eleves form-control">
                                        <option value="0">N/A</option>
                                    @foreach ($activites as $activite)
                                        @if ($activite->PREFIXE_ACTIVITES!='fn1')
                                        <option value="{{$activite->PREFIXE_ACTIVITES}}" @if ($user->projetRechercheAct == $activite->PREFIXE_ACTIVITES) selected @endif>{{mb_strtoupper($activite->PREFIXE_ACTIVITES)}} {{$activite->NOM_ACTIVITES}}</option>
                                        @endif
                                    @endforeach
                                    </select>                   
                                    <p class="text-danger small mb-0 mt-2">
                                    IMPORTANT: L'élève fera à nouveau l'activité que vous avez sélectionnée lorsqu'il retournera dans sa progression, <u>son étoile restera blanche et il n’aura pas accès à l’activité récompense</u>.</p>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

