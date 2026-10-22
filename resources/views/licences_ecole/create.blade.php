@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header">Ajouter un professeur</div>
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
                        <form class="form-horizontal" id="form" role="form" method="POST" action="/licences_ecole">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="type_licence" value="5" />
                            <div class="form-group" id="section_nom_contact">
                                <label class="control-label" for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom" value="{{ old('nom') }}">
                            </div>
                            <div class="form-group" id="section_prenom_contact">
                                <label class="control-label" for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="prenom" value="{{ old('prenom') }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="nombre_licences">Nombre de licences</label>
                                <input type="text" class="form-control" name="nombre_licences" id="nombre_licences" data-validation="number" data-validation-error-msg="Le nombre de licences ne peut pas être supérieur à celle disponible" data-validation-allowing="range[1;{{ $availableLicences }}]" value="{{ old('nombre_licences') }}">Licences disponibles: {{ $availableLicences }}
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="courriel">Courriel</label>
                                <input type="email" class="form-control" name="courriel" id="courriel" value="{{ old('courriel') }}">
                            </div>
                            <div class="form-group" id="section_lien_organisation">
                                <label class="control-label" id="lbl_lien_organisation" for="lien_organisation">Lien avec l'école</label>
                                <input type="text" class="form-control" name="lien_organisation" id="lien_organisation" value="{{ old('lien_organisation') }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="nom_utilisateur">Nom d'utilisateur</label>
                                <input type="text" class="form-control" name="nom_utilisateur" id="nom_utilisateur" value="{{ old('nom_utilisateur') }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="mot_de_passe">Mot de passe</label>
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
@endsection

