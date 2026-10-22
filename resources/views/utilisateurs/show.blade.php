@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header">Éditer un utilisateur</div>
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
                        <form method="POST" action="/utilisateurs/update/{{ $utilisateur->id_usager }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom" value="{{ $utilisateur->nom }}">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" value="{{ $utilisateur->prenom }}">
                            </div>
                            <div class="form-group">
                                <label for="nom_utilisateur">Nom d'utilisateur</label>
                                <input type="text" class="form-control" name="nom_utilisateur" id="nom_utilisateur" value="{{ $utilisateur->email }}">
                            </div>
                            <div class="form-group">
                                <label for="mot_de_passe">Mot de passe</label>
                                <input type="password" class="form-control" name="mot_de_passe" id="mot_de_passe">
                            </div>
                            <div class="form-group">
                                <label for="ddlTypeUsager">Type d'usager</label>
                                <select id="ddlTypeUsager" name="ddlTypeUsager" class="form-control">
                                    <option value="0">Veuillez sélectionner un type</option>
                                    @foreach ($user_types as $user_type)
                                        <option value="{{ $user_type->id_type_usager }}" @if ($user_type->id_type_usager == $utilisateur->id_type_usager) selected @endif>{{ $user_type->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ddlEstActif">Est actif ?</label>
                                <select id="ddlEstActif" name="ddlEstActif" class="form-control">
                                    <option value="1" @if ($utilisateur->est_actif == 1) selected @endif>Oui</option>
                                    <option value="0" @if ($utilisateur->est_actif == 0) selected @endif>Non</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

