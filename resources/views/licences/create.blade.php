@extends('layouts.master')
@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header">Enregistrer une licence</div>
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
                        <form method="POST" action="/licences">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="">
                                <div><label>Type</label></div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="type_licence1" name="type_licence" value="3" @if (old('type_licence') == 3) checked @endif>
                                <label class="form-check-label" for="type_licence1">Commission scolaire / Regroupement</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="type_licence2" name="type_licence" value="4" @if (old('type_licence') == 4) checked @endif>
                                <label class="form-check-label" for="type_licence2">Écoles</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" id="type_licence3" name="type_licence" value="5" @if (old('type_licence') == 5) checked @endif>
                                <label class="form-check-label" for="type_licence3">Professeurs / Professionnels</label>
                            </div>
                            <div class="form-group" id="section_nom_organisation">
                                <label for="lbl_nom_organisation"> @if (old('type_licence') == 3) Organisation @else École @endif</label>
                                <input type="text" class="form-control" id="nom_organisation" name="nom_organisation" value="{{ old('nom_organisation') }}">
                            </div>
                            <div class="form-group" id="section_lien_organisation" style="display: @if (old('type_licence') == 3) block @else none @endif;;">
                                <label for="lbl_lien_organisation">Lien</label>
                                <input type="text" class="form-control" name="lien_organisation" id="lien_organisation" value="{{ old('lien_organisation') }}">
                            </div>
                            <div class="form-group" id="section_nom_contact">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom" value="{{ old('nom') }}">
                            </div>
                            <div class="form-group" id="section_prenom_contact">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="prenom" value="{{ old('prenom') }}">
                            </div>
                            <div class="form-group">
                                <label for="courriel">Courriel</label>
                                <input type="email" class="form-control" name="courriel" id="courriel" value="{{ old('courriel') }}">
                            </div>
                            <div class="form-group">
                                <label for="nombre_licences">Nombre de licences</label>
                                <input type="text" class="form-control" name="nombre_licences" id="nombre_licences" value="{{ old('nombre_licences') }}">
                            </div>
                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="date_achat_licences">Date achat licences</label>
                                    <div class='input-group date'>
                                        <input type='date' class="form-control"  id='date_achat_licences' name="date_achat_licence" value="{{ old('date_achat_licence') }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="date_expiration_licence">Date expiration licences</label>
                                    <div class='input-group date'>
                                        <input type='date' class="form-control" name="date_expiration_licence" id='date_expiration_licence' value="{{ old('date_expiration_licence') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nom_utilisateur">Nom d'utilisateur</label>
                                <input type="text" class="form-control" name="nom_utilisateur" value="{{ old('nom_utilisateur') }}" id="nom_utilisateur">
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

    <script language="javascript">
        $(function () {
            /*
            $('#date_achat_licences').datetimepicker({
                locale: 'fr',
                format: 'YYYY/MM/DD'
            });

            $('#date_expiration_licences').datetimepicker({
                locale: 'fr',
                format: 'YYYY/MM/DD'
            });
            */
        });

        $(document).ready(function(){
            var TypeLicence = "";

            $('form input').on('change', function() {
                TypeLicence = $('input[name="type_licence"]:checked', 'form').val();

                if (TypeLicence == 3)
                {
                    $("#section_nom_organisation").show();
                    $("#section_nom_organisation label").text('Organisation');
                    $("#section_lien_organisation").show();
                }
                else if (TypeLicence == 4)
                {
                    $("#section_nom_organisation").show();
                    $("#section_nom_organisation label").text('École');
                    $("#section_lien_organisation").hide();
                }
                else if (TypeLicence == 5)
                {
                    $("#section_nom_organisation").show();
                    $("#section_nom_organisation label").text('École');
                    $("#section_lien_organisation").hide();
                }
            });
        });
    </script>
@endsection

