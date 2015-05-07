@extends('layouts.master')

@section('title')
	About
@endsection

@section('content')

	<div class="page-header">
		<h1>Add Locations</h1>
	</div>
	<p class="lead">The aims of this website can only be achieved if other organisations bring their locations to it.</p>
	<p>The website is in progress and it is planned to make it easier for you to add and manage locations, however there are already a number of ways to supply locations. You may need to talk to your organisation's website developer or IT expert to follow these methods, or get in touch with me yourself by e-mailing info[at]ediblegiving.org</p>
	<p>If you already manage your locations in a database or online system, can you generate a geojson file containing the expected properties? Then send me an e-mail with the URL and I'll add it to the sources list for automatic retrival.</p>
	<p>Supplying other geospatial file formats is possible, but I'll probably have to convert these manually and so it won;t be possible to update so frequently. Get in touch to talk about it.</p>
	<p>You can use a third-party website, <a href="http://geojson.io/">geojson.io</a> to create the locations with the required properties (ask me for an example!) and then save the geojson file to e-mail it to me. You can also use that to add the map with markers to your own website.</p>
	<p>The code is on <a href="http://www.github.com">Github</a> including some geojson files. Fork the code, add or edit a geojson file, then the sources file. Send a pull request and I'll try to work out how to accept/merge it.</p>

	<h2>Current sources</h2>
	<ul>
	<?php
		//use our data source array here
		$sources = \Config::get('ediblegiving.sources');
		foreach($sources as $s) {
			echo '<li>';
			echo '<strong>' . $s['name'] . '</strong>';
			if(isset($s['updated_date'])) {
				echo ', last update '. $s['updated_date'] .'';
			}
			if(isset($s['source_desc'])) {
				echo ' - '. $s['source_desc'] .'';
			}
			echo ' <a href="'. $s['url'] .'">geojson</a>';
			if(isset($s['desc_url'])) {
				echo ' | <a href="'. $s['desc_url'] .'">information</a>';
			}
			echo '</li>';
		}
	?>
	</ul>
@endsection
