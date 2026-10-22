<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'WelcomeController@index');
    
    // Documents à imprimer
    Route::get('docs-a-imprimer', 'DocsController@index');

    // Utilisateurs routes...
    Route::get('utilisateurs', 'UtilisateursController@index');
    Route::get('utilisateurs/create', 'UtilisateursController@create');
    Route::get('utilisateurs/{id}', 'UtilisateursController@show');
    Route::get('utilisateurs/destroy/{id}', 'UtilisateursController@destroy');
    Route::post('utilisateurs/update/{id}', 'UtilisateursController@update');
    Route::post('utilisateurs/updatepassword/{id}', 'UtilisateursController@updatePassword');
    Route::post('utilisateurs', 'UtilisateursController@store');

// Licences routes...
    Route::get('licences', 'LicencesController@index');
    Route::get('licences/create', 'LicencesController@create');
    Route::get('licences/{id}', 'LicencesController@show');
    Route::get('licences/destroy/{id}', 'LicencesController@destroy');
    Route::post('licences/update/{id}', 'LicencesController@update');
    Route::post('licences', 'LicencesController@store');

// Licences pour commissions routes...
    Route::get('licences_commission', 'LicencesCommissionController@index');
    Route::get('licences_commission/create', 'LicencesCommissionController@create');
    Route::get('licences_commission/{id}', 'LicencesCommissionController@show');
    Route::get('licences_commission/destroy/{id}', 'LicencesCommissionController@destroy');
    Route::post('licences_commission/update/{id}', 'LicencesCommissionController@update');
    Route::post('licences_commission', 'LicencesCommissionController@store');

// Licences pour ecoles routes...
    Route::get('licences_ecole', 'LicencesEcoleController@index');
    Route::get('licences_ecole/create', 'LicencesEcoleController@create');
    Route::get('licences_ecole/{id}', 'LicencesEcoleController@show');
    Route::get('licences_ecole/destroy/{id}', 'LicencesEcoleController@destroy');
    Route::post('licences_ecole/update/{id}', 'LicencesEcoleController@update');
    Route::post('licences_ecole', 'LicencesEcoleController@store');

// Licences pour profs routes...
    Route::get('licences_prof', 'LicencesProfController@index');
    Route::get('licences_prof/create', 'LicencesProfController@create');
    Route::get('licences_prof/{id}', 'LicencesProfController@show');
    Route::get('licences_prof/destroy/{id}', 'LicencesProfController@destroy');
    Route::post('licences_prof/update/{id}', 'LicencesProfController@update');
    Route::post('licences_prof', 'LicencesProfController@store');

    // Tableau des résultats routes..
    Route::get('tableau_resultats', 'TableauResultatsController@index');
    Route::get('tableau_resultats/test', 'TableauResultatsController@test');
    Route::get('tableau_resultats/{id_theme}', 'TableauResultatsController@bytheme');

    Route::post('projet_recherche/update/', 'projetRechercheController@update');

});

Route::get('suivi/{id}', 'suiviEmailController@send');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::controllers([
    'password' => 'Auth\PasswordController',
]);
