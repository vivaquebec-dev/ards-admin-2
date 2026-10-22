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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

	<link rel="stylesheet" href="css/all.min.css">



    @yield('css')



    <style>



        .panel  {

            padding-top:50px;



        }



        .container {

            margin-left: -20px;

        }



        a {

            color: #000;

        }

		

		.lst_activites {

			margin-top:15px;

		}

		

		.lst_activites_eleves {

		    padding: 6px 12px;

		}

.footer {
    padding-top: 50px;
}
.footer ul {
    list-style: none;
    display: flex;
    justify-content: center;
    margin: 0;
}

.footer li {
    padding: 2px 15px 5px 15px;
}

.footer a {
    color: #000;
    font-size: 12px;
    text-decoration: none;
}


    </style>





    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>



    <script language="javascript">



        $.validate({

            lang : 'fr'

        });



    </script>

</head>

<body>



<div class="container-fluid">

    <nav class="navbar navbar-inverse navbar-fixed-top">

        <div class="container-fluid">



            <!-- Brand and toggle get grouped for better mobile display -->

            <div class="navbar-header">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">



                    <span class="sr-only">Toggle navigation</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </button>

                <a class="navbar-brand" href="/">Royaume des sons - Administration</a>

            </div>



            <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">



                @if (Auth::check())

                    @if (Auth::user()->id_type_usager == 1)

                        <ul class="nav navbar-nav">

                            <li><a href="/utilisateurs">Gestion des utilisateurs</a></li>

                            <li><a href="/licences">Gestion des licences</a></li>

                        </ul>

                    @elseif((Auth::user()->id_type_usager == 3))

                        <ul class="nav navbar-nav">

                            <li><a href="/licences_commission">Gestion des établissements</a></li>

                        </ul>

                    @elseif((Auth::user()->id_type_usager == 4))

                        <ul class="nav navbar-nav">

                            <li><a href="/licences_ecole">Gestion des professeurs</a></li>

                            <li><a href="/docs/procedure-admin.pdf" target="_blank">Procédures</a></li>

                        </ul>

                    @elseif((Auth::user()->id_type_usager == 5))

                        <ul class="nav navbar-nav">

                            <li><a href="/licences_prof/">Gestion des élèves</a></li>

                            <li><a href="/tableau_resultats/">Tableau des résultats</a></li>

                            <li><a href="/docs/procedure-admin.pdf" target="_blank">Procédures</a></li>

                            <li><a href="/docs/guide-utilisateur.pdf" target="_blank">Guide de l'utilisateur</a></li>

                            <li><a href="/docs/informations-a-savoir.pdf" target="_blank">Informations à savoir</a></li>

                            <li><a href="/docs/Diplome-ARDS-20170430.pdf" target="_blank">Diplôme de réussite</a></li>

                            @if (Auth::user()->projetRecherche == 1)

                            <li>

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

                        </ul>

                    @endif

                @endif



                <ul class="nav navbar-nav navbar-right">

                   @if (!Auth::check())

                        <li><a href="/auth/login">Connexion </a></li>

                    @else (Auth::check())

                        <li><a href="#">{{Auth::user()->email}}</a></li>

                        <li class="dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>

                            <ul class="dropdown-menu" role="menu">

                                <li><a href="/auth/logout">Logout</a></li>



                            </ul>

                        </li>

                </ul>

                @endif

            </div><!-- /.navbar-collapse -->

        </div><!-- /.container-fluid -->

    </nav>

	<div class="row">

    <div class="col-md-12">





        @yield('content')





    </div>

    </div>

</div>





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







