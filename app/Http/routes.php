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

Route::get('data/{data_request}.json', 'DataController@returnData');



Route::get('manage', 'ManageController@index');
Route::get('manage/login/{provider?}', 'AuthController@login');

//Route::get('manage/location/', 'Manage\LocationController');
Route::get('manage/location/list/{orgslug}', 'Manage\LocationController@viewList');

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

Route::get('manage/power/orgs/{slug}', 'Manage\PowerController@orgsView');
Route::get('manage/power/orgs', 'Manage\PowerController@orgs');
Route::get('manage/power/orgs/create', 'Manage\PowerController@orgsCreate');
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
