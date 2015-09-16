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

	<h2>Find places...</h2>
		<div class="container map-filters">
			<div class="input-group" id="filter-activity">
				<div>
					<label for="donation-points">Donation points
					<input type="checkbox" activity="donation" id="donation-points" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="distribution-points">Distribution points
					<input type="checkbox" activity="distribution" id="distribution-points" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="volunteering-locations">Volunteering locations
					<input type="checkbox" activity="volunteering" id="volunteering-locations" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="office-locations">Office locations
					<input type="checkbox" activity="office" id="office-locations" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
			</div>
			<div class="input-group" id="filter-foodtype">
				<span class="filter-intro">Include places that accept</span>
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
	<h2>Info</h2>
@endsection

