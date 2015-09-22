<?php namespace App\Http\Controllers\Manage;

use Auth;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\OrganisationTagDefaults;
use App\Models\TagKey;
use App\User;
use App\Http\Requests\CreateOrganisationTagDefaultRequest;

class ImportController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Import Controller
	|--------------------------------------------------------------------------
	|
	| This controller provides functions to import location data
	*/

	protected $organisation; //current org that is being managed

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest'); //dont use this because we are working it out ourself?

		//TODO: can we do this in the constructior to avoid duplicate code in each function?
		//$this->organisation = Organisation::getBySlug($orgslug);

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index($orgslug = '')
	{
		$org = Organisation::getBySlug($orgslug);

		//work out what to do with them
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}

		if(!$curr_user->getOrgPermissions($org->id))
		{
			die('404');	
		}

		$data = array(
			'user' => $curr_user,
			'org' => $org
			);

		return view('manage.import.index', $data); //all good, show some manage links
	}


}
