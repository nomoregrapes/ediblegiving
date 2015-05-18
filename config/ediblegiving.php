<?php

return array(
	'sources' =>
		array(
			array(
				//Durham foodbanks
				'name' => 'County Durham Foodbanks',
				'url' => 'sources/uk-foodbanks-durham.geojson',
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
				//Newcastle foodbanks
				'name' => 'Foodbanks in Newcastle',
				'url' => 'sources/uk-foodbanks-newcastle.geojson',
				'updated_date' => 'manually from Newcastle Council on 18/5/15',
				'source_desc' => 'various locations of food banks in Newcastle, taken from a pdf compiled by Newcastle Council with additional information from food bank websites.',
				'desc_url' => 'https://www.newcastle.gov.uk/sites/drupalncc.newcastle.gov.uk/files/wwwfileroot/benefits-and-council-tax/welfare_rights_and_money_advice/foodbank_information_sheet_march_2013.pdf',
				'f_properties' => array(
					'source' => 'compiled by Edible Giving',
					'organisation' => 'County Durham Foodbank'
				)
			),
			array(
				//foodcycles
				'name' => 'Food Cycle Hubs',
				'url' => 'sources/uk-foodcycle.geojson',
				'updated_date' => 'manually from website on 11/3/15',
				'source_desc' => 'places that hot & healthy meals are served from food waste',
				'desc_url' => 'http://foodcycle.org.uk/locations/',
				'f_properties' => array(
					'source' => 'compiled by Edible Giving from Food Cycle website',
				)
			)
		)
	);

?>