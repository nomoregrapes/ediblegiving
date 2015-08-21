<?php namespace App\Http\Controllers\Manage;

use Auth;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\LocationTag;
use App\Models\Organisation;
use App\Models\OrganisationTagDefaults;
use App\Models\TagKey;
use App\User;
//use App\Http\Requests\CreateOrganisationTagDefaultRequest;

class LocationController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Location Controller
	|--------------------------------------------------------------------------
	|
	| This controller provides location viewing and managing, generally on a per-organisation basis
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
	public function index()
	{
		//TODO: something else here perhaps
		return redirect('/manage');
	}


	/**
	 * List locations in this organisation
	 **/
	public function viewList($orgslug = '')
	{
		$org = Organisation::getBySlug($orgslug);

		//check login and are a manager/admin of the org
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->canForOrg('org-locations-view', $org->slug, false))
		{
			die('404');	
		}

		$data = array('org' => $org);
				$query = 'SELECT U.*, R.* 
					FROM role_user AS RU
					LEFT JOIN users AS U ON RU.user_id = U.id
					LEFT JOIN roles AS R ON RU.role_id = R.id
					WHERE RU.organisation_id = ?
					GROUP BY U.id
					ORDER BY RU.role_id ASC, U.username ASC';
		$data['users'] = DB::select($query, array((int)$org->id));

		$locations = Location::where('organisation_id', '=', $org->id)
			->get();

		foreach($locations as $loc) {
			$tags = new LocationTag(); //yeah, I'm confused
			$loc->tags = $tags->getCoreTags($loc->id);
			$loc->more_tags = $tags->getTopTags($loc->id);
			$data['locations'][] = $loc;
		}

		return view('manage.location.viewlist', $data);
	}

	/**
	 * Add a new location
	 **/
	public function addLocation($orgslug = '')
	{
		$org = Organisation::getBySlug($orgslug);

		//check login and are a manager/admin of the org
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->canForOrg('org-locations-view', $org->slug, false))
		{
			die('404');	
		}

		
		$data = array('org' => $org);
		$data['defaults'] = OrganisationTagDefaults::getWithTagDetail($org->id);
		$data['options_keys'] = TagKey::where('restricted', 0)->get();

		return view('manage.location.addlocation', $data);


	}


}
