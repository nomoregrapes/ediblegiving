@extends('layouts.manage')

@section('title')
	Locations - Manage
@endsection

@section('content')
	<h1 class="cover-heading">Locations</h1>

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
			<td>{{$location->tags['name']}}</td>
			<td><small>{{$location->lat}}, {{$location->lon}}</small></td>
			<td>
			@foreach($location->more_tags as $key => $value)
				{{$key}} <strong>=</strong> {{$value}}<br>
			@endforeach
			</td>
			<td>{{ date('dS M Y', strtotime($location->created_at)) }}</td>
			<td><a href="{{ URL::to('/manage/location/edit'. $location->id) }}">edit</a></td>
		</tr>
	@endforeach
	</table>


@endsection
