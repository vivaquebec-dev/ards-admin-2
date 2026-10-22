<?php 
ini_set('memory_limit','1024M');
ini_set('memory_limit', '-1');
?>

@extends('layouts.master')
@section('content')
<style type="text/css" media="print">
    h1,.allresults,a.print, button.printall,.footer { display:none; }
    .table { width:inherit !important; }
    .nomeleves {min-width:150px;width:150px;}
    .nomactivites{max-width:100px;}
    div.bloc_theme{
        page-break-inside: avoid;
    }
</style>
<div class="col-12 pb-5" id="tableau_resultats">
    <h1>Tableau des résultats</h1>
	<p><sup>*</sup>NOTE: En avril 2020, les seuils de réussite ont été révisés et modifiés pour certaines activités. Il est possible que vos anciens résultats ne concordent pas avec les nouveaux seuils de réussite. </p>
    <div class="table-responsive allresults">
        <table class="tg table table-bordered">
            <tr class="themes_activites">
                <th class="tg-yw4l" rowspan="2"></th>
                @foreach ($activitesThemes as $activiteTheme)
                <th class="tg-yw4l" colspan="{{ $activiteTheme->items }}"><strong>{{ $activiteTheme->NOM_THEMES }}</strong></th>
                @endforeach
            </tr>
            <tr class="nom_activites">
                @foreach ($activites as $activite)
                <td class="nomactivites">{{ $activite->NOM_ACTIVITES }}</td>
                @endforeach
            </tr>
            <tr class="table-info seuil_de_reussite">
                <th class="tg-yw4l font-weight-normal"><sup>*</sup>Seuil de réussite</th>
                @foreach ($activites as $activite)
                <td align="center" valign="middle" class="tg-yw4l align-middle">
                <?php
                $seuil=$activite->NB_EXERCICES-$activite->NB_MAX_ERREUR;
                echo $seuil . '/' . $activite->NB_EXERCICES;
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

                            $resultatToShow .= '<p class="mb-0">' . $resultat->resultat . '/' . $resultat->NB_EXERCICES . '</p>';
                        ?>
                        @endif
                    @endforeach
                    <?php
                    if ($estReussi) {
                        $td_bg='table-success';
                    } else {
                        if ($estEchec) {
                            $td_bg='table-danger';
                        }
                    }

                    if (!$estReussi && !$estEchec) {
                        $td_bg = '';
                    }
                    ?>
                    <td class="text-center <?php echo $td_bg; ?>">
                        
                        <?php 
                        if ($estReussi || $estEchec) {
                            echo $resultatToShow;
                        }
                        ?>
                        
                    </td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
    <button type="button" class="btn btn-info printall mb-3 mt-5">Imprimer tous les thèmes</button>
    
    @foreach ($activitesThemes as $activiteTheme)
    <div class="bloc_theme pb-4">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-striped table-sm">
                <tr>
                    <th class="" colspan="<?php echo count($activites)+1; ?>" style="background:#FFF !important;">
                    <h3 style="margin:0;">{{ $activiteTheme->NOM_THEMES }}</h3><a href="tableau_resultats/{{ $activiteTheme->ID_THEMES }}" class="print"><i class="fas fa-print"></i></a>
                    </th>
                </tr>
                <tr class="nom_activites">
                    <th>&nbsp;</th>
                    @foreach ($activites as $activite)
                        @if ($activite->ID_THEMES==$activiteTheme->ID_THEMES)
                        <td class="nomactivites">{{ $activite->NOM_ACTIVITES }}</td>
                        @endif
                    @endforeach
                </tr>
                <tr class="table-info">
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
                <tr class="row_nom">
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
                                $td_bg='table-success';
                            } else {
                                if ($estEchec) {
                                    $td_bg='table-danger';
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

    <p><sup>*</sup>NOTE: En avril 2020, les seuils de réussite ont été révisés et modifiés pour certaines activités. Il est possible que vos anciens résultats ne concordent pas avec les nouveaux seuils de réussite. </p>
</div>

                    

<script>
    $(document).ready(function(){
        $('.printall').on('click', function() {
            window.print();
        });
    });
</script>

@endsection