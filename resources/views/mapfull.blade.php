@extends('layouts.mapfull-page')

@section('title')
	Map
@endsection

@section('extra-css')
	{!! HTML::style('css/jquery-ui-lightness/jquery-ui-1.10.4.min.css') !!}
	{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css') !!}
	{!! HTML::style('css/map-full.css') !!}
@endsection
@section('extra-js')
	{!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js') !!}
	{!! HTML::script('js/map-functions.js') !!}
	{!! HTML::script('js/map-full.js') !!}
@endsection