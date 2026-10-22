@extends('layouts.master')
@section('content')
<div class="container pb-5" id="doc_a_imprimer">
    <div class="row">
        <div class="col-12">
            <h1>Documents à imprimer</h1>
        </div>
    </div>
    <div class="row dessins my-5">
        <div class="col-12">
            <h2>La comptine de Cricri</h2>
        </div>
        <div class="col-sm-4 item">
            <a href="/docs/La-comptine-de-Cricri.pdf" target="_blank">
                <img src="/img/cricri.jpg" alt="Cricri">
                Télécharger le document
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 item">
            <h2>Carte accès élèves</h2>
            <a href="/docs/ARDS_Carte-Acces.pdf" target="_blank">
                <img src="/img/ARDS_Carte-Acces.jpg" alt="Carte d'accès">
                Télécharger le document
            </a>
        </div>
        <div class="col-sm-4 item">
            <h2>Diplôme de réussite</h2>
            <a href="/docs/Diplome-ARDS-20170430.pdf" target="_blank">
                <img src="/img/diplome-reussite.jpg" alt="Diplôme de réussite">
                Télécharger le document
            </a>
        </div>
        <div class="col-sm-4 item">
            <h2>Enseignement en groupe</h2>
            <a href="/docs/ARDS-progression-enseignement-groupe.pdf" target="_blank">
                <img src="/img/progression-enseignement-groupe.jpg" alt="Enseignement en groupe">
                Télécharger le document
            </a>
        </div>
    </div>
    <div class="row dessins mt-5">
        <div class="col-12">
            <h2>Dessins à colorier</h2>
        </div>
        <div class="col-sm-4 item">
            <a href="/docs/ARDS_Dessin_Chevalier.pdf" target="_blank">
                <img src="/img/ARDS_Dessin_Chevalier.jpg" alt="Dessin Chevalier">
                Télécharger le dessin du Chevalier
            </a>
        </div>
        <div class="col-sm-4 item">
            <a href="/docs/ARDS_Dessin_Dragon.pdf" target="_blank">
                <img src="/img/ARDS_Dessin_Dragon.jpg" alt="Dessin Dragon">
                Télécharger le dessin du Dragon
            </a>
        </div>
        <div class="col-sm-4 item">
            <a href="/docs/ARDS_Dessin_Fee.pdf" target="_blank">
                <img src="/img/ARDS_Dessin_Fee.jpg" alt="Dessin Fée">
                Télécharger le dessin de la Fée
            </a>
        </div>
        <div class="col-sm-4 item">
            <a href="/docs/ARDS_Dessin_Princesse.pdf" target="_blank">
                <img src="/img/ARDS_Dessin_Princesse.jpg" alt="Dessin Princesse">
                Télécharger le dessin de la Princesse
            </a>
        </div>
        <div class="col-sm-4 item">
            <a href="/docs/ARDS_Dessin_Sorciere.pdf" target="_blank">
                <img src="/img/ARDS_Dessin_Sorciere.jpg" alt="Dessin Sorcière">
                Télécharger le dessin de la Sorcière
            </a>
        </div>
    </div>
@endsection