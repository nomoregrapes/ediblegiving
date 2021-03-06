@extends('layouts.manage')

@section('title')
	geoJSON preview - Import Locations - Manage
@endsection


@section('extra-css')
	{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css') !!}
	{!! HTML::style('css/map.css') !!}
@endsection
@section('extra-js')
	<script type="text/javascript">
		var mapDataURL = "{{URL::to($geojsonurl)}}";
	</script>
	{!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js') !!}
	{!! HTML::script('js/map-functions.js') !!}
	{!! HTML::script('js/map-basic.js') !!}}
@endsection

@section('content')
	<h1 class="cover-heading">geoJSON</h1>
	<p>Displayed is the contents of the geoJSON feed for you to preview.</p>

	@if(count($failreason) > 0)
	<ul class="alert alert-danger">
		@foreach($failreason as $fail)
			<li>{{ $fail }}</li>
		@endforeach
	</ul>
	@endif
	@if(count($warnreason) > 0)
	<ul class="alert alert-warning">
		@foreach($warnreason as $warn)
			@if($warn == null OR $warn['items'] == null)
			@elseif(is_array($warn))
				<li>
					<a href="#{{$warn['key']}}" data-toggle="collapse" aria-expanded="false">{{$warn['description']}}  <span class="caret"></a>
					<div id="{{$warn['key']}}" class="collapse">
						<ul>
						@foreach($warn['items'] as $warndetail)
							<li>{{ $warndetail }}</li>
						@endforeach
						</ul>
					</div>
				</li>
			@else
				<li>{{ $warn }}</li>
			@endif
		@endforeach
	</ul>
	@endif

	<div class="row">
		<div class="col-md-8">
			<h2>{{count($newdata)}} locations can be imported</h2>
		</div>
		<div class="col-md-4">
			<div id="map"></div>
		</div>
	</div>

	@if(count($failreason) < 10)
		{!! Form::open(['url' => '/manage/import/' . $org->slug . '/geojson/store', 'class'=>'form-horizontal']) !!}
		{!! Form::hidden('dataurl', $geojsonurl) !!}
		<table class="table table-condensed table-striped table-hover">
			<tr>
				<th>Import reference</th>
				<th title="Latitude, Longitude">Location co-ordinates</th>
				<th>Properties</th>
				<th>Import?</th>
			</tr>
		@if(count($newdata) > 0)
			@foreach($newdata as $location)
				<tr>
					<td>{{$location->reference}}</td>
					<td>{{$location->geometry->coordinates[1]}}, {{$location->geometry->coordinates[0]}}</td>
					{!! Form::hidden('location['.$location->reference.'][lat]', $location->geometry->coordinates[1]) !!}
					{!! Form::hidden('location['.$location->reference.'][lon]', $location->geometry->coordinates[0]) !!}
					<td>
						<ul>
						@if(count($location->properties) > 0)
							@foreach($location->properties as $key => $value)
								@if(in_array($key, $available_keys))
									<li>{{$key . ' = ' . $value}}</li>
									{!! Form::hidden('location['.$location->reference.'][tags]['.$key.']', $value) !!}
								@else
									<li><strike>{{$key . ' = ' . $value}}</strike></li>
								@endif
							@endforeach
						@endif
						</ul>
					</td>
					<td>
						Import
						@if(count($location->fails) > 0)
							{!! Form::checkbox('location['.$location->reference.'][importit]', 0, ['class' => "form-control", 'disabled' => "disabled"]) !!}
						@else
							{!! Form::checkbox('location['.$location->reference.'][importit]', 1, ['class' => "form-control"]) !!}
						@endif
					</td>
				</tr>
			@endforeach
		@endif
		</table>

		{!! Form::submit('Import Locations', ['class' => "btn btn-default"]) !!}
		{!! Form::close() !!}
	@endif


@endsection