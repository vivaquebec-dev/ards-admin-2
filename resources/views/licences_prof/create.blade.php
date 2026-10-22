@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header">Ajouter un élève</div>
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
                            <form id="form" role="form" method="POST" action="/licences_prof">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group" id="section_nom_contact">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom" value="{{ old('nom') }}">
                                </div>
                                <div class="form-group" id="section_prenom_contact">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" id="prenom" value="{{ old('prenom') }}">
                                </div>
                                <div class="form-group" id="section_prenom_contact">
                                    <label for="ddlSexe">Sexe</label>
                                    <select id="ddlEstActif" name="ddlSexe" id="ddlSexe" class="form-control">
                                        <option value="">Veuillez sélectionner le sexe</option>
                                        <option value="G" @if (old('ddlSexe') == 'G') checked @endif>Garçon</option>
                                        <option value="F" @if (old('ddlSexe') == 'F') checked @endif>Fille</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nom_utilisateur">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" name="nom_utilisateur" id="nom_utilisateur" value="{{ old('nom_utilisateur') }}">
                                </div>
                                <div class="form-group">
                                    <label for="mot_de_passe">Mot de passe</label>
                                    <input type="password" class="form-control" name="mot_de_passe" id="mot_de_passe" value="{{ old('mot_de_passe') }}">
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
    </div>
@endsection

