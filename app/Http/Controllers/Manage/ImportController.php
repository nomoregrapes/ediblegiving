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
use App\Http\Requests\NewImportRequest;

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

	/**
	 * Read a geojson url, show a preview list and map, so we can import it later
	 **/
	public function geojson(NewImportRequest $request, $orgslug='')
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
		$data['available_keys'] = TagKey::where('restricted', 0)->get()->all();
		$data['available_keys'] = array_map(create_function('$o', 'return $o->key;'), $data['available_keys']); //extracts the keys

		//okay, what data we got?
		$input = $request->all();
		$data['geojsonurl'] = $input['dataurl'];

		$importdata = json_decode(file_get_contents($data['geojsonurl']));

		//need to do some checking that importdata is what we need/expect
		$data['newdata'] = array(); //also do data adjustments
		$required_properties = array('name');
		$failreason = array();
		$warnreason = array();
		$i = 0;
		//TODO: check it's an object of things
		foreach($importdata->features as $location)
		{
			$i++; $loc_ref = $i;
			$location->fails = array();
			$location->warns = array();
			//TODO: can we refer to this location somehow, and mention that in each fail reason?
			if(!isset($location->type) || $location->type != "Feature") {
				$location->fails[] = "Items of ". $loc_ref ." are not geoJSON features.";
				//exit if or foreach?
			}
			if(!isset($location->properties)) {
				$location->fails[] = "Location ". $loc_ref ."  does not have any properties.";
			} else {
				//check properties have a matching tag? (or we will skip them?)
				foreach($location->properties as $key => $value) {
					if(in_array($key, $data['available_keys']) == false) {
						$location->warns[] = "Location ". $loc_ref ." has property '". $key ."' that will not be imported into the Edible Giving system.";
						//check minimum properties required
						if(in_array($key, $required_properties)) {
							$location->fails[] = "Location ". $loc_ref ." does not have a value for '". $key ."', this is required.";
						}
					}
				}
			}
			if(!isset($location->geometry) || !isset($location->geometry->type) || $location->geometry->type != "Point") {
				$location->fails[] = "Location does not have point geometry.";
			}
			elseif(!isset($location->geometry->coordinates) || !is_array($location->geometry->coordinates)) {
				$location->fails[] = "Location does not have coordinates in it's geometry.";
			}
			elseif($location->geometry->coordinates[0] < -180 || $location->geometry->coordinates[0] > 180 || $location->geometry->coordinates[0] == 0) {
				$location->fails[] = "Location does not have a valid latitude (may be 0 or switched with longitude).";
			}
			elseif($location->geometry->coordinates[1] < -90 || $location->geometry->coordinates[1] > 90 || $location->geometry->coordinates[1] == 0) {
				$location->fails[] = "Location does not have a valid longitude (may be 0 or switched with latitude).";
			}
			else {
				$location->geometry->coordinates[0] = round($location->geometry->coordinates[0], 6);
				$location->geometry->coordinates[1] = round($location->geometry->coordinates[1], 6);
				//TODO: warn if there is a location with same or very similar co-ordinates?
			}

			//clean up
			$location->reference = $loc_ref;
			$data['newdata'][] = $location;
			$failreason = array_merge($failreason, $location->fails);
			$warnreason[] = array(
				'key' => 'location-'.$loc_ref,
				'description' => 'Multiple warnings('. count($location->warns) .') for location '. $loc_ref .'.',
				'items' => $location->warns
				);
			//$warnreason = array_merge($warnreason, $location->warns);
		}

		$data['warnreason'][] = "This import will add new locations, not checking if they already exist.";
		$data['failreason'] = $failreason;
		$data['warnreason'] = $warnreason;

		return view('manage.import.geojson', $data); //all good, show some manage links
	}


	/**
	 * Store the geojson that we are importing
	 * This may be used by other formats than geoJSON if we follow the current process of building a form first
	 **/
	public function geojsonStore(NewImportRequest $request, $orgslug='')
	{
		//TODO: NewImportRequest should be replaced with something that checks the data being submitted. Then we don't need to submit dataurl.
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
		$data['available_keys'] = TagKey::where('restricted', 0)->get()->all();
		$data['available_keys'] = array_map(create_function('$o', 'return $o->key;'), $data['available_keys']); //extracts the keys

		//okay, what data we got?
		$input = $request->all();

		//prep for impotrting
		$default_tags = OrganisationTagDefaults::getWithTagDetail($org->id);

		//do the import
		$completed = array();
		foreach($input['location'] as $ref => $loc) {
			if($loc['importit'] == 1) {
				//TODO: refractor to improve the create function? It could include default tags for an org. It could add tags on inm the func.
				$location = Location::create(array(
					'lat' => $loc['lat'],
					'lon' => $loc['lon'],
					'organisation_id' => $org->id,
					'visible' => 0 //TODO: review if this should be an option when importing?
					));
				//add default tags?...
				//add imported tags...
				foreach($loc['tags'] as $key => $value) {
					//create a new tag... (because we didn't add defaults, theres no chance we'll need to update)
					$this_tag = array(
						'location_id' => $location->id,
						'key' => $key,
						'value' => $value,
						'populated_by' => 'feed'
						);
					LocationTag::create($this_tag);
				}
				//done adding location and tags...
				$completed[] = array(
					"newid" => $location->id,
					"ref" => $ref
					);
			}
			//otherwise, don't import
		}
		//all locations imported?
		$data['completed'] = $completed;

		//done, now show what?
		//all done, move on/back to location list
		return redirect('manage/location/'. $orgslug);

	}


}
