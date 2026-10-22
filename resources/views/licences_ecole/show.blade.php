@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header">Éditez une licence</div>
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
                        <form class="form-horizontal" id="form" role="form" method="POST" action="/licences_ecole/update/{{ $licence->id_licence }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="id_usager" name="id_usager" value="{{ $licence->id_usager  }}">
                            <input type="hidden" name="type_licence" value="{{ $licence->id_type_licence  }}" />
                            <div class="form-group" id="section_nom_contact">
                                <label class="control-label">Nom</label>
                                <input type="text" class="form-control" name="nom" value="{{ $licence->nom_contact }}" readonly>
                            </div>
                            <div class="form-group" id="section_prenom_contact">
                                <label class="control-label">Prénom</label>
                                <input type="text" class="form-control" name="prenom" value="{{ $licence->prenom_contact }}" readonly>

                            </div>
                            <div class="form-group">
                                <label class="control-label">Nombre de licences</label>
                                    <input type="text" class="form-control" name="nombre_licence"  data-validation="number" value="{{ $licence->nombre_licence }}" readonly data-validation-error-msg="Le nombre de licences ne peut pas être supérieur à ceux disponible" data-validation-allowing="range[1;{{ $availableLicences }}]">
                                    Licences disponibles: {{ $availableLicences }}
                            </div>
                            <div class="form-group">
                                <label class="control-label">Courriel</label>
                                <input type="email" class="form-control" name="courriel" value="{{ $licence->courriel }}" readonly>
                            </div>
                            <div class="form-group" id="section_lien_organisation">
                                <label class="control-label" id="lbl_lien_organisation">Lien</label>
                                <input type="text" class="form-control" name="lien_organisation" value="{{ $licence->lien_description }}" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nom d'utilisateur</label>
                                <input type="text" class="form-control" name="nom_utilisateur" value="{{ $licence->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mot de passe</label>
                                <input type="password" class="form-control" name="mot_de_passe" value="{{ $licence->password }}" readonly>
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

