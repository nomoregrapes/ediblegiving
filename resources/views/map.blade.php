@extends('layouts.master')

@section('title')
	Map
@endsection

@section('extra-css')
	{!! HTML::style('css/jquery-ui-lightness/jquery-ui-1.10.4.min.css') !!}
	{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css') !!}
	{!! HTML::style('css/map.css') !!}
@endsection
@section('extra-js')
	{!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js') !!}
	{!! HTML::script('js/map-functions.js') !!}
	{!! HTML::script('js/map.js') !!}
@endsection

@section('precontent')
	<div class="jumbotron">
		<div class="container map-filters">
			<h2>Choose what to find...</h2>
			<div class="input-group" id="filter-activity">
				<label for="donation-points">Donation points</label>
				<input type="checkbox" activity="donation" id="donation-points" checked="checked">

				<label for="distribution-points">Distribution points</label>
				<input type="checkbox" activity="distribution" id="distribution-points" checked="checked">

				<label for="volunteering-locations">Volunteering locations</label>
				<input type="checkbox" activity="volunteering" id="volunteering-locations" checked="checked">

				<label for="office-locations">Office locations</label>
				<input type="checkbox" activity="office" id="office-locations" checked="checked">
			</div>
			<div class="input-group" id="filter-foodtype">
				<span class="filter-intro">Include places that accept</span>
				<label for="unopened-food">Unopened food</label>
				<input type="checkbox" foodtype="unopened" id="unopened-food" checked="checked">

				<label for="fresh-food">Fresh food</label>
				<input type="checkbox" foodtype="fresh" id="fresh-food" checked="checked">
			</div>
		</div>
	</div>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8">
			<div id="map"></div>
			Sharable link to: <a href="#" id="permalink-map">current view of map</a>.
		</div>
		<!-- side column of detailed info -->
		<div class="col-md-4 hide" id="map-marker-details">
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
		<div class="col-md-4 location-list-heading hide">
			<hr>
			<strong>Your location list</strong>
		</div>
		<div class="col-md-4" id="location-list">
		</div>
	</div>
@endsection
