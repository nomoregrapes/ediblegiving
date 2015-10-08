<?php namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\Location;
use App\Models\LocationTag;
use App\Models\TagKey;
use App\Models\Organisation;


class DataController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}



	public function returnData($data_request=null)
	{
		if($data_request == 'simpledata') {
			/*
			 * This script is a hack
			 * we should probably be pulling the files into a DB on a daily cron
			 * then this script can get them out (or refer to cached geojson file)
			 */

			//detail all the geoJSON files (internal or full URLs) that we want to use
			$sources = \Config::get('ediblegiving.sources');

			//let's make a geojson!
			$newJson = array(
				'type' => 'FeatureCollection',
				'features' => array()
				);

			foreach($sources as $s) {
				$thisFile = json_decode(file_get_contents($s['url']));

				if(!$thisFile->features) {
					//TODO: would be helpful to log!
					break; //skip this file
				}

				//each feature/point in the file
				foreach($thisFile->features as $feature) {
					//are we checking it's in bbox bounds?
						//TODO
					//do we have default properties to add to features in this file?
					if($s['f_properties'] != array()) {
						foreach($s['f_properties'] as $k => $v)
						{
							//only if it hasn't got a value
							if(!isset($feature->properties->$k)) {
								$feature->properties->$k = $v;
							}
						}
					}

					//add the feature to our mega object
					$newJson['features'][] = $feature;
				}
				//end of that file, onto the next
			}

			//okay, spit out the json now
			return json_encode($newJson);
		//end of simpledata request
		} else {
			abort(404, 'That data is not available.');
		}
	}


	/*
	 * This will be our main super function
	 */
	public function getData($public=1, $parameters=array()) {
		//hack attempt
		//$parameters = array('org' => 6);
		//parameters sent over get?

		//public or private?
		if($public == 1) {
			$query = Location::where('visible', '=', 1);
		} else {
			//you must be requesting an org if you want to include draft locations!
			if(empty($parameters['org'])) {
				die('404a'); //TODO: better failing
			}
			if(!$user = Auth::user()) {
				die('404b'); //not logged in
			}
			//check they can (org can be id or slug)
			if(!$user->canForOrg('org-locations-view', $parameters['org'])) {
				print_r($parameters);
				die('404c'); //don't have permission for this org
			}
		}

		//add any parameters
		if(!empty($parameters['org']) && is_integer($parameters['org'])) {
			$query = Location::where('organisation_id', '=', $parameters['org']);
		} elseif(!empty($parameters['org'])) {
			//need to convert org slug before querying
			$org = DB::select('SELECT id FROM organisations
			    WHERE slug = ? LIMIT 1;', [$parameters['org']])[0];
			//okay
			$query = Location::where('organisation_id', '=', (int)$org->id);
		}

		//on our query, we can get the data
		$locations = $query->get();

		//let's make a geojson!
		$newJson = array(
			'type' => 'FeatureCollection',
			'features' => array()
			);
		//put in the locations
		foreach($locations as $loc) {
			$feature = array(
				'type' => 'Feature'
				);

			//add tags. TODO: this could be one call to LocationTag, and negate the need for a loop?
			$tags = new LocationTag(); //yeah, I'm confused
			$feature['properties'] = $tags->getCoreTags($loc->id);
			foreach( $tags->getAllLocTags($loc->id) as $k => $v)
			{
				//hmm, mysql and php lose our data types
				if($v == "0") {
					$feature['properties'][$k] = false;
				} elseif($v == "1") {
					$feature['properties'][$k] = true;
				} else {
					$feature['properties'][$k] = $v;
				}
				
			}
			$feature['properties']['id'] = (int)$loc->id;

			//geometry last, to match old style (for flick-past comparing)
			$feature['geometry'] = array(
					'type' => 'Point',
					'coordinates' => array(floatval($loc->lon), floatval($loc->lat))
					);

			//add to data
			if(floatval($loc->lon) == 0 || floatval($loc->lat) == 0) {
				//skip bad data?
			} else {
				$newJson['features'][] = $feature;
			}
		}


		//okay, spit out the json now
		return json_encode($newJson);
	}

	/*
	 * Get all locations in an org
	 */
	public function orgLocations($orgslug) {

		return $this->getData($public=0, array('org'=>$orgslug));

	}

}
