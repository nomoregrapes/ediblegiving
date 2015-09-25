@extends('layouts.mapfull-page')

@section('title')
	Map
@endsection

@section('extra-css')
@endsection
@section('extra-js')
	{!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js') !!}
	{!! HTML::script('js/map-functions.js') !!}
	{!! HTML::script('js/map-full.js') !!}
@endsection


@section('side-control')
	<h2>Find your area...</h2>
		<p>Coming soon...</p>

	<h2>Map display</h2>
		<div class="map-filters">
			<div class="input-group" id="filter-activity">
				<span class="filter-intro">Show locations for...</span>
				<div>
					<label for="donation-points">Donating
					<input type="checkbox" activity="donation" id="donation-points" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="distribution-points">Receiving food
					<input type="checkbox" activity="distribution" id="distribution-points" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="volunteering-locations">Volunteering
					<input type="checkbox" activity="volunteering" id="volunteering-locations" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="office-locations">Organisation offices
					<input type="checkbox" activity="office" id="office-locations" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
			</div>
			<div class="input-group" id="filter-foodtype">
				<span class="filter-intro">Include places that accept...</span>
				<div>
					<label for="unopened-food">Unopened food
					<input type="checkbox" foodtype="unopened" id="unopened-food" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="fresh-food">Fresh food
					<input type="checkbox" foodtype="fresh" id="fresh-food" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
			</div>
		</div>
@endsection


@section('side-info')
		<div id="side-welcome">
			<h2>Welcome</h2>
			<p>Use Edible Giving to find organisations that you can donate food or your time to. </p>
			<p>
				First use the "map display" controls to change what markers are shown.
				Then click a marker to bring up further details.
			</p>
			<p>
				<div id="site-links" style="display: inline-block; padding: 0;">
				Head to the <a href="/about" id="about" style="margin-left:0;">About <span class="link-icon">About</span></a>
				 page, for information on how the locations are collected and the vision of Edible Giving.</div>
			</p>
		</div>
		<div class="hide" id="map-marker-details">
			<h2 class="mmd-dynamic mmd-name"></h2>
			<p class="mmd-dynamic mmd-telephone"></p>
			<p class="mmd-dynamic mmd-address"></p>
			<p class="mmd-dynamic mmd-opening"></p>
			<p class="mmd-dynamic mmd-description"></p>
			<p class="mmd-links">
				<span class="mmd-addtolist"><a href="#">add to list</a></span> | 
				<span class="mmd-dynamic mmd-website"></span>
			</p>
		</div>
		<div class="location-list-heading hide">
			<hr>
			<strong>Your location list</strong>
		</div>
		<div class="" id="location-list">
		</div>
@endsection

