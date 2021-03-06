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

Route::get('/', 'MapController@index');

Route::get('about', function() {
	return view('about');
});
Route::get('about/addlocations', function() {
	return view('about-addlocations');
});

// Map URLs
Route::get('map/{orgslug}', 'MapController@index');
Route::get('map', 'MapController@index');
//TODO: depreciate
Route::get('newmap', function() { return redirect('/'); });



//Feeds are public URLS (may need authorisation)
	//TODO

//Data is for the system to use (ie geojson to populate the map)
Route::get('data/all.geojson', 'DataController@getData');
Route::get('data/{data_request}.json', 'DataController@returnData'); //old style, static files combined. TODO: depreciate
Route::get('data/{orgslug}/locations.geojson', 'DataController@orgLocations'); //for manage area



Route::get('manage', 'ManageController@index');
Route::get('manage/login/{provider?}', 'AuthController@login');
//Route::get('manage/logout', );
Route::post('manage/newcontact', 'ManageController@contactNew');

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

//exports
Route::get('manage/output/{orgslug}', 'Manage\OutputController@index');
Route::get('manage/output/{orgslug}/{filename}.csv', 'Manage\OutputController@csvDirect'); //straight download link!
	//Route::post('manage/import/{orgslug}/geojson', 'Manage\ImportController@geojson');
	//Route::post('manage/import/{orgslug}/geojson/store', 'Manage\ImportController@geojsonStore');

//imports
Route::get('manage/import/{orgslug}', 'Manage\ImportController@index');
Route::post('manage/import/{orgslug}/geojson', 'Manage\ImportController@geojson');
Route::post('manage/import/{orgslug}/geojson/store', 'Manage\ImportController@geojsonStore');


/* Power areas, for EG admins only */
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
