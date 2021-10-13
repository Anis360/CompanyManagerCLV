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

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('auth\login');
});

//Changer mot de passe

Route::get('/changePassword','ChangePasswordController@showChangePasswordForm');

Route::post('/changePassword','ChangePasswordController@changePassword')->name('changePassword');

//Sessions

Route::get('dtable-custom-posts', 'SessionController@get_custom_posts');
/*Route::get('/session', function () {
    return view('session');
});*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

//Route::get('change', 'Auth\LoginController@showLoginForm')->name('login');

Route::auth();

Route::get('home', 'HomeController@index');


Route::get('sessions','SessionController@index');

Route::get('/sessions','SessionController@index');

Route::get('/sessions/search','SessionController@search')->name('SessionController.search');

Route::get('/sessions/deb','SessionController@datesearch')->name('SessionController.datesearch');


//Route::get('session','SessionController@edit');


//Route::get('session','SessionController@select');



Route::post('createSs','SessionController@insert');

Route::post('edit','SessionController@edit');

Route::post('sessions/edit','SessionController@edit');

Route::post('sessions/delete','SessionController@delete');

Route::post('sessions/action', 'SessionController@action')->name('SessionController.action');

Route::resource('sessions', 'SessionController');




//Inscriptions

Route::get('inscriptions','InscriptionController@index');

Route::get('/inscriptions','InscriptionController@index')->name('inscriptions.index');

Route::get('/inscriptions/search','InscriptionController@search')->name('InscriptionController.search');

Route::post('createIn','InscriptionController@insert');

Route::post('inscriptions/edit','InscriptionController@edit');

Route::post('inscriptions/delete','InscriptionController@delete');

Route::resource('inscriptions', 'InscriptionController');

//Route::get('/session/action', 'SessionController@action')->name('SessionController.action');

//Utilisateurs

Route::get('utilisateurs','UtilisateurController@index');

Route::get('/utilisateurs','UtilisateurController@index')->name('utilisateurs.index');

Route::get('/utilisateurs/search','UtilisateurController@search')->name('UtilisateurController.search');

Route::post('createUt','UtilisateurController@insert');

Route::post('utilisateurs/edit','UtilisateurController@edit');

Route::post('utilisateurs/delete','UtilisateurController@delete');

Route::resource('utilisateurs', 'UtilisateurController');

//Thèmes

Route::get('themes','ThemeController@index');

Route::get('/themes','ThemeController@index')->name('themes.index');

Route::get('/themes/search','ThemeController@search')->name('ThemeController.search');

Route::post('createTh','ThemeController@insert');

Route::post('themes/edit','ThemeController@edit');

Route::post('themes/delete','ThemeController@delete');

Route::resource('themes', 'ThemeController');

//Catégories

Route::get('categories','CategorieController@index');

Route::get('/categories','CategorieController@index')->name('categories.index');

Route::get('/categories/search','CategorieController@search')->name('CategorieController.search');

Route::post('createCt','CategorieController@insert');

Route::post('categories/edit','CategorieController@edit');

Route::post('categories/delete','CategorieController@delete');

Route::resource('categories', 'CategorieController');

//Formateurs


Route::get('formateurs','FormateurController@index');

Route::get('/formateurs','FormateurController@index')->name('formateurs.index');

Route::get('/formateurs/search','FormateurController@search')->name('FormateurController.search');

Route::post('createFr','FormateurController@insert');

Route::post('formateurs/edit','FormateurController@edit');

Route::post('formateurs/delete','FormateurController@delete');

Route::resource('formateurs', 'FormateurController');

//Stagiaires

Route::get('stagiaires','StagiaireController@index');

Route::get('/stagiaires','StagiaireController@index')->name('stagiaires.index');

Route::get('/stagiaires/search','StagiaireController@search')->name('StagiaireController.search');

Route::post('createSt','StagiaireController@insert');

Route::post('stagiaires/edit','StagiaireController@edit');

Route::post('stagiaires/delete','StagiaireController@delete');

Route::resource('stagiaires', 'StagiaireController');

//Editeurs

Route::get('editeurs','EditeurController@index');

Route::get('/editeurs','EditeurController@index')->name('editeurs.index');

Route::get('/editeurs/search','EditeurController@search')->name('EditeurController.search');

Route::post('createEd','EditeurController@insert');

Route::post('editeurs/edit','EditeurController@edit');

Route::post('editeurs/delete','EditeurController@delete');

Route::resource('editeurs', 'EditeurController');

//Salles

Route::get('salles','SalleController@index');

Route::get('/salles','SalleController@index')->name('salles.index');

Route::get('/salles/search','SalleController@search')->name('SalleController.search');

Route::post('createSl','SalleController@insert');

Route::post('salles/edit','SalleController@edit');

Route::post('salles/delete','SalleController@delete');

Route::resource('salles', 'SalleController');