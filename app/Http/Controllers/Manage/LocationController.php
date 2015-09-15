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
use App\Http\Requests\CreateLocationRequest;

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


	/**
	 * Edit/update a location
	 **/
	public function updateLocation($orgslug = '', $location_id = null)
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

		//find and get existing location
		$data['location'] = Location::findOrFail($location_id);
		$data['loc_tags'] = LocationTag::getAllTags($location_id);

		//$data['defaults'] = OrganisationTagDefaults::getWithTagDetail($org->id);
		$data['options_keys'] = TagKey::where('restricted', 0)->get();

		return view('manage.location.updatelocation', $data);


	}

	/**
	 * Save a new or edited location
	 **/
	public function storeLocation($orgslug = '', CreateLocationRequest $request)
	{
		$org = Organisation::getBySlug($orgslug);

		$input = $request->all();
		$input['organisation_id'] = $org->id; 

		//is location_id null or not found?
		if(array_key_exists('id', $input) && $input['id'] != null) {
			//updating
			$location = Location::findOrFail($input['id']);
			
			if($location->organisation_id != $org->id)
			{
				//location isn't in the org of the URL.
				return redirect('/manage');
			}
			//TODO: better permission check $input['organisation_id'] = current org_id, and permissions
			$location->update($input);
		} else {
			//is new
			$location = Location::create($input);

			//now add default tags (cant rely on blade form to have done that), if they arent overridden
			$default_tags = OrganisationTagDefaults::getWithTagDetail($org->id);
			foreach($default_tags as $default) {
				//if((!array_key_exists($default->key, $input['tag'])) || ($default->default_value != $input['tag'][$default->key])) {
				if(1==1) {
					//default not been overridden...
					$this_tag = array(
						'location_id' => $location->id,
						'key' => $default->key,
						'value' => $default->default_value,
						'populated_by' => 'defaults'
						);
					LocationTag::create($this_tag);
				}
			}
		}

		//now add/update tags
		foreach($input['tag'] as $key => $value) {
			if($value == "") {
				//value not given/changed, so don't update/empty it!
				continue;
			}
			$tag = LocationTag::findOrFail($location->id, $key);
			if($tag != null && $tag->value != $value) {
				//tag needs updating...
				$this_tag = array(
					'value' => $value,
					'populated_by' => 'manual'
					);
				//echo "UPDATE TAG"; print_r($tag); print_r($this_tag);
				//$tag->update($this_tag);
				//$match = array('location_id', 'key', 'value', 'populated_by');

				$match = array(
					'location_id' => $location->id,
					'key' => $key
					);
				$populate = $match;
				$populate['value'] = $value;
				$populate['populated_by'] = 'manual';

				//$values = array($location->id, $key, $value, 'manual');
				$tag->updateTags($location, $key, $this_tag);
			} elseif( $tag == null ) {
				//create a new tag...
				$this_tag = array(
					'location_id' => $location->id,
					'key' => $key,
					'value' => $value,
					'populated_by' => 'manual' //TODO: unless it is the default value for that tag
					);
				//echo "CREATE TAG"; print_r($this_tag);
				LocationTag::create($this_tag);
			}
		}

		//dd($location);


		//all done, move on/back to location list
		return redirect('manage/location/'. $orgslug);
	}


}
