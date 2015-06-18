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



Route::get('manage', function() {
	if( Auth::check()) return 'Welcome back, '. Auth::user()->username;

	return 'Hi guest. '. link_to('manage/login', 'Login with Github!');
});

Route::get('manage/login', 'AuthController@login');

Route::get('manage/power', 'Manage\PowerController@index');

Route::get('manage/power/users', 'Manage\PowerController@users');

Route::get('manage/power/orgs/{slug}', 'Manage\PowerController@orgsView');
Route::get('manage/power/orgs', 'Manage\PowerController@orgs');
Route::get('manage/power/orgs/create', 'Manage\PowerController@orgsCreate');
Route::post('manage/power/orgs', 'Manage\PowerController@orgsStore');

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
