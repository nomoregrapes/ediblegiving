<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Organisation;

class ManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest'); //dont use this because we are working it out ourself?
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

		//work out what to do with them
		if(!$user = Auth::user())
		{
			return view('manage.index'); //need to choose a provider & login
		}
		$user->orgs = Organisation::getByUser($user->id);
		if(!$user->orgs[0])
		{
			return view('manage.welcome'); //need a role in an org
		}

		return view('manage.home'); //all good, show some manage links
	}


}
