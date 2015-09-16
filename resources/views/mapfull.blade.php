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
	<h2>Search Places</h2>
		<p>Coming soon...</p>

	<h2>Filters</h2>
		<p>Almost done...</p>
@endsection


@section('side-info')
	<h2>Info</h2>
@endsection

