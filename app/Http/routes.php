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

Route::get('/', function() {
	return view('home');
});

Route::get('about', function() {
	return view('about');
});
Route::get('about/addlocations', function() {
	return view('about-addlocations');
});

Route::get('map', function() {
	return view('map');
});
//The new map style, to replace the homepage
Route::get('newmap', 'MapController@index');


//Feeds are public URLS (may need authorisation)
	//TODO

//Data is for the system to use (ie geojson to populate the map)
Route::get('data/{data_request}.json', 'DataController@returnData'); //old style, static files combined. TODO: depreciate
Route::get('data/{orgslug}/locations.json', 'DataController@orgLocations');



Route::get('manage', 'ManageController@index');
Route::get('manage/login/{provider?}', 'AuthController@login');

//Route::get('manage/location/', 'Manage\LocationController');
Route::get('manage/location/{orgslug}', 'Manage\LocationController@viewList');
Route::get('manage/location/{orgslug}/add', 'Manage\LocationController@addLocation');
Route::get('manage/location/{orgslug}/{location_id}/edit', 'Manage\LocationController@updateLocation');
Route::post('manage/location/{orgslug}/store', 'Manage\LocationController@storeLocation'); //send id by post

//Route::get('manage/organisation/{orgslug}', 'Manage\OrganisationController');
Route::get('manage/organisation/{orgslug}/users/{username}', 'Manage\OrganisationController@usersView');
Route::get('manage/organisation/{orgslug}/users', 'Manage\OrganisationController@users');
Route::get('manage/organisation/{orgslug}/defaults', 'Manage\OrganisationController@defaults');
Route::post('manage/organisation/{orgslug}/defaults', 'Manage\OrganisationController@defaultsStore');

Route::get('manage/power', 'Manage\PowerController@index');

Route::get('manage/power/users/{username}', 'Manage\PowerController@usersView');
Route::post('manage/power/users/{username}', 'Manage\PowerController@usersRoleSave');
Route::post('manage/power/usersrole/{username}', 'Manage\PowerController@usersRoleRemove');
Route::get('manage/power/usersrole/{username}', function($username='') {
	return redirect('manage/power/users/' . $username);
});
Route::get('manage/power/users', 'Manage\PowerController@users');

Route::get('manage/power/orgs/create', 'Manage\PowerController@orgsCreate');
Route::get('manage/power/orgs/{slug}', 'Manage\PowerController@orgsView');
Route::get('manage/power/orgs', 'Manage\PowerController@orgs');
Route::post('manage/power/orgs', 'Manage\PowerController@orgsStore');
Route::patch('manage/power/orgs/{slug}', 'Manage\PowerController@orgsUpdate');

Route::get('manage/power/statistics', 'Manage\PowerController@statistics');
Route::get('manage/power/bootup/{function}', 'Manage\PowerController@bootup');


/*
Route::get('home', 'HomeController@index');
Route::get('about', 'AboutController@index');
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
