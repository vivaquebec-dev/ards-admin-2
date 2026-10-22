@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Éditez un élève</div>
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

                        @foreach ($users as $user)
                        <form class="form-horizontal" id="form" role="form" method="POST" action="/licences_prof/update/{{ $user->id_usager }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="id_usager" name="id_usager" value="{{ $user->id_usager  }}">
                            <input type="hidden" id="id_usager" name="id_eleve" value="{{ $user->id_eleve  }}">

                            <div class="form-group" id="section_nom_contact">
                                <label class="col-md-4 control-label">Nom</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nom" value="{{ $user->nom }}" readonly>
                                </div>
                            </div>

                            <div class="form-group" id="section_prenom_contact">
                                <label class="col-md-4 control-label">Prénom</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="prenom" value="{{ $user->prenom }}" readonly>
                                </div>
                            </div>

                            <div class="form-group" id="section_prenom_contact">
                                <label class="col-md-4 control-label">Sexe</label>
                                <div class="col-md-6">
                                    <select id="ddlEstActif" name="ddlSexe" class="form-control" readonly>
                                        <option value="0">Veuillez sélectionner le sexe</option>
                                        <option value="G" @if ($user->sexe == 'G') selected @endif>Garçon</option>
                                        <option value="F" @if ($user->sexe == 'F') selected @endif>Fille</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nom d'utilisateur</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nom_utilisateur" value="{{ $user->email }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Mot de passe</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="mot_de_passe" value="{{ $user->password }}">
                                </div>
                            </div>

                            <div class='col-sm-6'>
                                <div class="form-group">

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Enregistrer
                                    </button>
                                </div>

                            </div>
                       </form>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
