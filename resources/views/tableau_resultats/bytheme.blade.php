<?php 
	//ini_set('memory_limit','1024M');
	//ini_set('memory_limit', '-1');
?>
@extends('layouts.tableau_resultats_bytheme')
@section('content')
        <style type="text/css" media="screen">
			.tg-wrap { padding:15px 0; }
            .tg  {border-collapse:collapse;border-spacing:0;margin-bottom:50px;}
            .tg td{font-family:Arial, sans-serif;font-size:14px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
            .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
            .tg .tg-yw4l{vertical-align:top}
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
            @media screen and (max-width: 1500px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {-webkit-overflow-scrolling: touch;}}
		</style>
        <style type="text/css" media="print">
			.container-fluid, tg-wrap { padding:0; }
			h1,div.br,.allresults { display:none; }
			.table { width:inherit !important; }
			.nomeleves {min-width:150px;width:150px;}
			.nomactivites{max-width:100px;}
			div.bloc_theme{
				page-break-inside: avoid;
			}
			.print-btns {
				display:none;
			}
		</style>
        <div class="tg-wrap">
                    <div class="bloc_theme">
                    <div class="print-btns" style="padding-bottom:15px;">
                    <button type="button" class="btn btn-info print">Imprimer</button>
                    <button type="button" class="btn btn-secondary back">Annuler</button>
                    </div>
                    <div class="table-responsive">
					<table class="table table-bordered table-condensed table-striped">
                    <tr>
                    	<th class="" colspan="<?php echo count($activites)+1; ?>" style="background:#FFF !important;">
                        <h3 style="margin:0;">{{ $activitesThemes['NOM_THEMES'] }}</h3>
                        </th>
                    </tr>
                    <tr>
                    	<th class="">&nbsp;</th>
                        @foreach ($activites as $activite)
                            <td class="nomactivites">{{ $activite->NOM_ACTIVITES }}</td>
                        @endforeach
                    </tr>
                	@foreach ($eleves as $eleve)
                	<tr>
                    	<td class="nomeleves"><strong>{{ $eleve->nom }}, {{ $eleve->prenom }}</strong></td>
                        
                        @foreach ($activites as $activite)
                        	@if ($activite->ID_THEMES==$activitesThemes['ID_THEMES'])
                            <?php
							$r = array();
							$estReussi = false;
							$estEchec = false;
							$resultatToShow = $td_bg = '';
							?>
                        	@foreach ($resultats as $resultat)
                                @if ($activitesThemes['ID_THEMES']==$resultat->ID_THEMES && $activite->ID_ACTIVITES==$resultat->ID_ACTIVITES && $eleve->id_usager==$resultat->id_usager)
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
                    
                    </div>
                    
<script>
$(document).ready(function(){
	$('.print').on('click', function() {
		window.print();
	});
	$('.back').on('click', function() {
		window.history.back();
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