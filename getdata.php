<?php
/*
 * This script is a hack
 * we should probably be pulling the files into a DB on a daily cron
 * then this script can get them out (or refer to cached geojson file)
 */

//detail all the geoJSON files (internal or full URLs) that we want to use
$sources = array(
	array(
		//Durham foodbanks
		'url' => 'data/uk-foodbanks-durham.geojson',
		'f_properties' => array(
			'source' => 'compiled by Edible Giving',
			'organisation' => 'County Durham Foodbank',
			'website' => 'http://durham.foodbank.org.uk/'
		)
	),
	array(
		//foodcycles
		'url' => 'data/uk-foodcycle.geojson',
		'f_properties' => array(
			'source' => 'compiled by Edible Giving',
		)
	)
);

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
				if(!$feature->properties->$k) {
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
exit( json_encode($newJson) );

?>