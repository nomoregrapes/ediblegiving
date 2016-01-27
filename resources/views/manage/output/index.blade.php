@extends('layouts.manage')

@section('title')
	Export - Locations - Manage
@endsection

@section('content')
	<h1 class="cover-heading">Locations</h1>
	<p>Your organisation has <strong>{{$location_count}}</strong> locations in Edible Giving.</p>

	<p>Public view of <strong><a href="http://www.ediblegiving.org/map/{{$org->slug}}">{{$org->name}} locations</strong> on Edible Giving</a> (with no other locations shown).</p>

	<p><a href="{{$csvLatest}}">Download CSV file</a></p>
	<p>The format of the CSV file has the following aspects.
	<ul>
		<li>The fields/columns are seperated by a comma. Some fields may be in double quotation marks.</li>
		<li>The first row contains the column headings.</li>
		<li>The first 6 columns: id; latitude; longitude; published; created; updated, will remain in that order.</li>
		<li>Remaining columns may change order every time you download the CSV. They are tags/attributes of the location.</li>
		<li>A tag column is only included in the CSV, if at least one location has a value for it.</li>
		<li>The values will be filled with "n/a" if the location does not have that tag. Edible Giving treats n/a(null) values differently, but often as a "no".</li>
	</ul>
	This is subject to change during the development of Edible Giving. Please inform us if you are coding systems that require the format to continue following these rules.
	</p>

	<h2>Coming Soon</h2>
	<p>It is planned that outputs will be available in the following forms. If these are important to you and you wish to help development of them; please <a href="/about">get in touch</a>.
	<ul>
		<li>Map on your website - a simple bit of HTML iframe code to add once & updates automatically</li>
		<li>geoJSON feed - for use programming the live data into other systems</li>
		<li>Defaults & org info - export not just your locations, but other information saved on Edible Giving</li>
	</ul>


@endsection