@extends('layouts.manage')

@section('title')
	geoJSON preview - Import Locations - Manage
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
			<li>{{ $warn }}</li>
		@endforeach
	</ul>
	@endif

	@if(count($failreason) < 10)
		{!! Form::open(['url' => '/manage/import/' . $org->slug . '/geojson/store', 'class'=>'form-horizontal']) !!}
		{!! Form::hidden('dataurl', $geojsonurl) !!}
		<table class="table table-condensed table-striped table-hover">
			<tr>
				<th>Import reference</th>
				<th>Location co-ordinates</th>
				<th>Properties</th>
				<th>Import?</th>
			</tr>
		@if(count($newdata) > 0)
			@foreach($newdata as $location)
				<tr>
					<td>{{$location->reference}}</td>
					<td>{{$location->geometry->coordinates[0]}}, {{$location->geometry->coordinates[0]}}</td>
					{!! Form::hidden('location['.$location->reference.'][lat]', $location->geometry->coordinates[0]) !!}
					{!! Form::hidden('location['.$location->reference.'][lon]', $location->geometry->coordinates[1]) !!}
					<td>
						<ul>
						@if(count($location->properties) > 0)
							@foreach($location->properties as $key => $value)
								@if(in_array($key, $available_keys))
									<li>{{$key . ' = ' . $value}}</li>
									{!! Form::hidden('location['.$location->reference.'][tags]['.$key.']', $value) !!}
								@else
									<li><strikeout>{{$key . ' = ' . $value}}</strikeout></li>
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