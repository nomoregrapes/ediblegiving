<?php namespace App\Http\Controllers;

use App\Models\Organisation;

class MapController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index($orgslug=null)
	{
		$data['org_specific'] = false;

		if($orgslug != null) {
			//specific org display, look it up
			$data['org'] = Organisation::getBySlug($orgslug);
			if($data['org'] != null) {
				$data['org_specific'] = true;
			}
		}

		return view('mapfull', $data);
	}

}
