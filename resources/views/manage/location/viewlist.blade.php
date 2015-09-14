@extends('layouts.manage')

@section('title')
	Locations - Manage
@endsection

@section('extra-css')
	{!! HTML::style('css/jquery-ui-lightness/jquery-ui-1.10.4.min.css') !!}
	{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css') !!}
	{!! HTML::style('css/map.css') !!}
@endsection
@section('extra-js')
	{!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js') !!}
	{!! HTML::script('js/map-functions.js') !!}
	{!! HTML::script('js/views/manage/location-list.js') !!}
@endsection

@section('content')
	<h1 class="cover-heading">Locations</h1>
	<a href="{{ URL::to('/manage/location/' . $org->slug .'/add') }}">add a location</a>

	<div class="row">
		<div class="col-md-8">
			<table class="table table-condensed table-striped table-hover">
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Co-ordinates</th>
					<th>Tags</th>
					<th>Added</th>
					<th></th>
				</tr>
			@if(count($locations) < 1)
				<tr>
					<td colspan="5">No locations</td>
				</tr>
			@endif
			@foreach($locations as $location)
				<tr>
					<td>{{$location->id}}</td>
					<td>
						@if(isset($location->tags['name']))
							{{$location->tags['name']}}
						@endif
					</td>
					<td><small>{{$location->lat}}, {{$location->lon}}</small></td>
					<td>
					@foreach($location->more_tags as $key => $value)
						{{$key}} <strong>=</strong> {{$value}}<br>
					@endforeach
					</td>
					<td>{{ date('dS M Y', strtotime($location->created_at)) }}</td>
					<td><a href="{{ URL::to('/manage/location/' . $org->slug .'/'. $location->id .'/edit') }}">edit</a></td>
				</tr>
			@endforeach
			</table>
		</div>

		<div class="col-md-4">
			<div id="map"></div>
		</div>
	</div>


@endsection
