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

Route::get('/character/new', function() {
	return View::make('newCharacter');
});


Route::post('/character/new', 'HomeController@createNewCharacter');
Route::get('/character/{id}', function($id) {
	return View::make('character')->with('character', Character::find($id));
});


Route::get('/campaign/{id}', function($id) {
	return View::make('campaignGeneral')->with('campaign', Campaign::find($id));
});

Route::get('/campaign/{id}/settings', function($id) {
	return View::make('campaignSettings')->with('campaign', Campaign::find($id));
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
	Route::post('/character/{id}/update/stunts', 'EditAPIController@updateCharacterStunts');
	Route::post('/character/{id}/update/refresh', 'EditAPIController@updateCharacterRefresh');
	Route::post('/character/{id}/update/aspect/{position}', 'EditAPIController@updateCharacterAspect');
	Route::post('/character/{id}/update/consequence/{severity}/{slot?}', 'EditAPIController@updateCharacterConsequence');
	Route::post('/character/{id}/update/stress/{type}', 'EditAPIController@updateCharacterStress');
	Route::post('/character/{id}/update/skill/{rank}/{position}', 'EditAPIController@updateCharacterSkill');
	
	Route::get('/campaign/{id}/request/{request_id}/accept', 'CampaignAPIController@acceptCampaignRequest');
	Route::get('/campaign/{id}/request/{request_id}/reject', 'CampaignAPIController@rejectCampaignRequest');
	Route::get('/campaign/{id}/skill/add', 'CampaignAPIController@addNewSkill');
	Route::post('/campaign/{id}/skill/delete', 'CampaignAPIController@deleteSkill');
	Route::post('/campaign/{id}/skill/{skill_id}/update/name', 'CampaignAPIController@updateSkillName');
	Route::post('/campaign/{id}/skill/{skill_id}/update/physical', 'CampaignAPIController@setPhysicalSkill');
	Route::post('/campaign/{id}/skill/{skill_id}/update/mental', 'CampaignAPIController@setMentalSkill');

});