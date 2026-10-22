<?php 

ini_set('memory_limit','1024M');

ini_set('memory_limit', '-1');

?>

@extends('layouts.tableau_resultats')

<?php 

	/*

	echo "<br /><br />";

	foreach ($activitesThemes as $activiteTheme) {

		echo $activiteTheme['NOM_THEMES']."<br />";

	}

	foreach ($resultats as $resultat) {

		//echo $resultat["ID_ACTIVITES"]." ".$resultat["resultat"]."<br />";

		echo $resultat->resultat;

	}

	echo "<br />";

	foreach ($activites as $activite) {

		echo "<strong>".$activite['NOM_ACTIVITES']."</strong><br />";

		foreach ($eleves as $eleve) {

			echo $eleve["prenom"]." ".$eleve["nom"]."<br />";

		}

	}

	echo "<br /><br />";

	*/

	

	

?>

@section('content')

<div class="br"><br /><br /></div>

<!--

    <div class="shownom"></div>

-->

    <h1>Tableau des résultats</h1>
	<p><sup>*</sup>NOTE: En avril 2020, les seuils de réussite ont été révisés et modifiés pour certaines activités. Il est possible que vos anciens résultats ne concordent pas avec les nouveaux seuils de réussite. </p>
    <!--<table class="table table-bordered" id="users-table">-->

        <style type="text/css" media="screen">

            .tg  {border-collapse:collapse;border-spacing:0;margin-bottom:50px;}

            .tg td{font-family:Arial, sans-serif;font-size:14px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}

            .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}

            .tg .tg-yw4l{vertical-align:top;line-height:14px;}

			.nomeleves {min-width:200px;width:200px;}

			.nomactivites{min-width:100px;width:150px;}

			.table{margin-bottom:40px;width:inherit;}

			.table>thead>tr>td.success, .table>tbody>tr>td.success, .table>tfoot>tr>td.success, .table>thead>tr>th.success, .table>tbody>tr>th.success, .table>tfoot>tr>th.success, .table>thead>tr.success>td, .table>tbody>tr.success>td, .table>tfoot>tr.success>td, .table>thead>tr.success>th, .table>tbody>tr.success>th, .table>tfoot>tr.success>th, .table>thead>tr>td.danger, .table>tbody>tr>td.danger, .table>tfoot>tr>td.danger, .table>thead>tr>th.danger, .table>tbody>tr>th.danger, .table>tfoot>tr>th.danger, .table>thead>tr.danger>td, .table>tbody>tr.danger>td, .table>tfoot>tr.danger>td, .table>thead>tr.danger>th, .table>tbody>tr.danger>th, .table>tfoot>tr.danger>th {

				border-color:#000;

			}

			.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {

				border-color:#000;

			}

			.shownom{background:#FFF;padding:5px;position:absolute;white-space:nowrap;}

			td.green{background:#dff0d8;}

			td.red{background:#f2dede;}

			td.tg-yw4l{padding:10px 5px;}

			.allresults td a{display:block;padding:10px 5px;}.allresults td a:hover{text-decoration:none;}

			a.print {

				float:right;

				font-size:18px;

				margin-top:-25px;

			}

            @media screen and (max-width: 1500px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {-webkit-overflow-scrolling: touch;}}

		</style>

        <style type="text/css" media="print">

			h1,div.br,.allresults { display:none; }

			.table { width:inherit !important; }

			.nomeleves {min-width:150px;width:150px;}

			.nomactivites{max-width:100px;}

			div.bloc_theme{

				page-break-inside: avoid;

			}

			a.print, button.printall { display:none; }			

		</style>

        <div class="tg-wrap"><table class="tg allresults">

                <tr>

                    <th class="tg-yw4l" rowspan="2"><strong>&nbsp;</strong></th>

                    @foreach ($activitesThemes as $activiteTheme)

                    <th class="tg-yw4l" colspan="{{ $activiteTheme->items }}"><strong>{{ $activiteTheme->NOM_THEMES }}</strong></th>

                    @endforeach

                </tr>

                <tr>

                    @foreach ($activites as $activite)

                        <td class="tg-yw4l">{{ $activite->NOM_ACTIVITES }}</td>

                    @endforeach

                </tr>
                <tr>
                  <th class="tg-yw4l" style="font-weight:normal;"><sup>*</sup>Seuil de réussite</th>
                    @foreach ($activites as $activite)

                        <td align="center" valign="middle" class="tg-yw4l" style="vertical-align:middle">
                        <?php
						$seuil=$activite->NB_EXERCICES-$activite->NB_MAX_ERREUR;
						echo $seuil.'/'.$activite->NB_EXERCICES;
						?>
                        </td>

                    @endforeach
                </tr>

                @foreach ($eleves as $eleve)

                <tr class="row_nom" data-nom="{{ $eleve->nom }}, {{ $eleve->prenom }}">

                    <td class="tg-yw4l"><strong>{{ $eleve->nom }}, {{ $eleve->prenom }}</strong></td>

                    @foreach ($activites as $activite)

                    <?php

					$r = array();

					$estReussi = false;

					$estEchec = false;

					$resultatToShow = $td_bg = '';

					?>

                    	@foreach ($resultats as $resultat)

                        	@if ($activite->ID_ACTIVITES==$resultat->ID_ACTIVITES && $eleve->id_usager==$resultat->id_usager)

                            <?php

							 	$id_usager = $eleve->id_usager;

								$id_activites = $resultat->ID_ACTIVITES;

								if ($resultat->resultat < ($resultat->NB_EXERCICES - $resultat->NB_MAX_ERREUR)) {

									$estEchec=true;

								}elseif ($resultat->resultat > $resultat->NB_MAX_ERREUR) {

									$estReussi=true;

								}

								$resultatToShow .= $resultat->resultat.' / '.$resultat->NB_EXERCICES.'<br>';

							?>

                            @endif

                        @endforeach

                        <?php

								if ($estReussi) {

									$td_bg='green';

								} else {

									if ($estEchec) {

										$td_bg='red';

									}

								}

								

								if (!$estReussi && !$estEchec) {

									$td_bg = '';

								}

							?>

                        	<td class="text-center <?php echo $td_bg; ?> ">

                            	<?php if ($estReussi || $estEchec) { ?>

                                <?php echo $resultatToShow; ?>

                                <!--

                            	<a href="{{ url('/tableau_resultats',  $parameters = [$resultat->id_usager, $resultat->ID_ACTIVITES]) }}">Résultats</a>

                            	<a href="/tableau_resultats/<?php echo $id_usager; ?>/<?php echo $id_activites; ?>">Résultats</a>

                                -->

                                <?php } ?>

                            </td>

                    @endforeach

                </tr>

                @endforeach



                </table>

				

                    <!--

                    -->

          <button type="button" class="btn btn-info printall" style="margin-bottom:15px;">Imprimer tous les thèmes</button>

                    @foreach ($activitesThemes as $activiteTheme)

                    <div class="bloc_theme">

                    <!--<h3>{{ $activiteTheme->NOM_THEMES }}</h3>-->

                    <div class="table-responsive">

					<table class="table table-bordered table-condensed table-striped">

                    <tr>

                    	<th class="" colspan="<?php echo count($activites)+1; ?>" style="background:#FFF !important;">

                        <h3 style="margin:0;">{{ $activiteTheme->NOM_THEMES }}</h3><a href="tableau_resultats/{{ $activiteTheme->ID_THEMES }}" class="print"><i class="fas fa-print"></i></a>

                        </th>

                    </tr>

                    <tr>

                    	<th class="">&nbsp;</th>

                        @foreach ($activites as $activite)

                        	@if ($activite->ID_THEMES==$activiteTheme->ID_THEMES)

                            <td class="nomactivites">{{ $activite->NOM_ACTIVITES }}</td>

                            @endif

                        @endforeach

                    </tr>
                    <tr>
                      <th class="tg-yw4l" style="font-weight:normal;"><sup>*</sup>Seuil de réussite</th>
                        @foreach ($activites as $activite)

                        	@if ($activite->ID_THEMES==$activiteTheme->ID_THEMES)

                        <td align="center" valign="middle" class="tg-yw4l" style="vertical-align:middle">
                        <?php
						$seuil=$activite->NB_EXERCICES-$activite->NB_MAX_ERREUR;
						echo $seuil.'/'.$activite->NB_EXERCICES;
						?>
                        </td>

                            @endif

                        @endforeach
                    </tr>

                	@foreach ($eleves as $eleve)

                	<tr>

                    	<td class="nomeleves"><strong>{{ $eleve->nom }}, {{ $eleve->prenom }}</strong></td>

                        

                        @foreach ($activites as $activite)

                        	@if ($activite->ID_THEMES==$activiteTheme->ID_THEMES)

                            <?php

							$r = array();

							$estReussi = false;

							$estEchec = false;

							$resultatToShow = $td_bg = '';

							?>

                        	@foreach ($resultats as $resultat)

                                @if ($activiteTheme->ID_THEMES==$resultat->ID_THEMES && $activite->ID_ACTIVITES==$resultat->ID_ACTIVITES && $eleve->id_usager==$resultat->id_usager)

                                    <?php

										if ($resultat->resultat < ($resultat->NB_EXERCICES - $resultat->NB_MAX_ERREUR)) {

											$estEchec=true;

										}elseif ($resultat->resultat > $resultat->NB_MAX_ERREUR) {

											$estReussi=true;

										}

										

										$resultatToShow .= $resultat->resultat.' / '.$resultat->NB_EXERCICES.'<br>';

									?>

                                @endif

                            @endforeach

                            <?php

								if ($estReussi) {

									$td_bg='success';

								} else {

									if ($estEchec) {

										$td_bg='danger';

									}

								}

									

							?>

                        	<td class="text-center <?php echo $td_bg; ?>">

                            <?php echo $resultatToShow; ?>

                            </td>

                            @endif

                        @endforeach

                	</tr>

                    @endforeach

					</table>

                    </div>

                    </div>

                    @endforeach

</div>
	<p><sup>*</sup>NOTE: En avril 2020, les seuils de réussite ont été révisés et modifiés pour certaines activités. Il est possible que vos anciens résultats ne concordent pas avec les nouveaux seuils de réussite. </p>

                    

<script>

$(document).ready(function(){

	$('.printall').on('click', function() {

		window.print();

	});

/*

	$(".row_nom").on("mouseenter", function (e) {

		var nomEleve = $(this).attr('data-nom');

		$('.shownom').show();

		$('.shownom').html(nomEleve);

		$('.shownom').css({

			top:  e.pageY,

			left: e.pageX

		});

		e.stopPropagation();

		e.stopImmediatePropagation();

	});

	

	$('.row_nom > td').on('mouseenter', function(e) {

		var nomEleve = $(this).parent().attr('data-nom');

		$('.shownom').show();

		//$(this).append(nomEleve);

		

		e.stopImmediatePropagation();

		e.stopPropagation();

		

		$('.shownom').html(nomEleve);

		$('.shownom').css({

			top:  parseInt(e.pageY)+15,

			left: parseInt(e.pageX)+15

		});

	}).on('mouseleave', function(){

		$('.shownom').hide();

	});

*/

});

</script>



@endsection

<?php

/*

	[ID_ACTIVITES] => 1

    [ID_THEMES] => 1

    [PREFIXE_ACTIVITES] => cm1

    [NOM_ACTIVITES] => Distinguer et manipuler des mots dans une phrase

    [NB_MAX_ERREUR] => 2

    [NB_EXERCICES] => 6

    [id_resultat] => 42272

    [id_usager] => 950

    [resultat] => 2

    [created_at] => 0000-00-00 00:00:00

    [nbExercice] => 0

    [nom] => René

    [prenom] => Stella

    [email] => srene

    [password] => 50a6364a6fd2fbd46d075f6c9e814c2c

    [id_type_usager] => 6

    [id_licence] => 329

    [est_actif] => 0

    [acceptCond] => 0

    [projetRecherche] => 0

    [projetRechercheAct] => cp3

    [remember_token] => 

    [updated_at] => 2019-02-19 00:24:21

*/

?>