<?php

$sources = array(
	array(
		//Durham foodbanks
		'name' => 'County Durham Foodbanks',
		'url' => 'data/uk-foodbanks-durham.geojson',
		'updated_date' => 'manually from website on 5/3/15',
		'source_desc' => 'various locations of the County Durham Foodbank (run by Durham Christian Partnership)',
		'desc_url' => 'http://www.batchgeo.com/map/7a4edfd360686967bae18243378aece7',
		'f_properties' => array(
			'source' => 'compiled by Edible Giving',
			'organisation' => 'County Durham Foodbank',
			'website' => 'http://durham.foodbank.org.uk/'
		)
	),
	array(
		//foodcycles
		'name' => 'Food Cycle Hubs',
		'url' => 'data/uk-foodcycle.geojson',
		'updated_date' => 'manually from website on 5/3/15 (incomplete)',
		'source_desc' => 'some locations',
		'desc_url' => 'http://foodcycle.org.uk/locations/',
		'f_properties' => array(
			'source' => 'compiled by Edible Giving',
		)
	)
);

?>