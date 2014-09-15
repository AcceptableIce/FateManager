<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
	return View::make('hello');
});

Route::get('/test/{id}/', function($id) {
	return View::make('test')->with('character', Character::find($id));
});

Route::get('logout', array('uses' => 'HomeController@doLogout'));

Route::get('login', array('uses' => 'HomeController@showLogin'));
Route::post('login', array('uses' => 'HomeController@doLogin'));

Route::post('createAccount', array('uses' => 'HomeController@createAccount'));

Route::group(array('prefix' => 'api/v1'), function() {
	Route::get('/test', 'EditAPIController@test');
	Route::post('/character/{id}/update/name', 'EditAPIController@updateCharacterName');
	Route::post('/character/{id}/update/description', 'EditAPIController@updateCharacterDescription');
	Route::post('/character/{id}/update/extras', 'EditAPIController@updateCharacterExtras');
	Route::post('/character/{id}/update/refresh', 'EditAPIController@updateCharacterRefresh');
	Route::post('/character/{id}/update/aspect/{position}', 'EditAPIController@updateCharacterAspect');
	Route::post('/character/{id}/update/consequence/{severity}/{slot?}', 'EditAPIController@updateCharacterConsequence');
	Route::post('/character/{id}/update/stress/{type}', 'EditAPIController@updateCharacterStress');

});