@extends('layouts.manage')

@section('title')
	Edit - Locations - Manage
@endsection

@section('extra-css')
	{!! HTML::style('css/jquery-ui-lightness/jquery-ui-1.10.4.min.css') !!}
	{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css') !!}
	{!! HTML::style('css/map.css') !!}
@endsection
@section('extra-js')
	<script type="text/javascript">
		var mapDataURL = "{{URL::to('/data/testing-super-cafes/locations.json')}}";
		var mapCurrentLocation = {id:{{$location->id}}, lat:{{$location->lat}}, lon:{{$location->lon}}};
	</script>
	{!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js') !!}
	{!! HTML::script('js/map-functions.js') !!}
	{!! HTML::script('js/views/manage/location-edit-map.js') !!}
	{!! HTML::script('js/views/manage/location-edit.js') !!}
@endsection

@section('content')
	<h1 class="cover-heading">Edit Location</h1>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	<div class="row">
		{!! Form::open(['url' => '/manage/location/' . $org->slug . '/store', 'class'=>'form-horizontal']) !!}
			{!! Form::hidden('id', $location->id, ['class' => "form-control"]) !!}
			<div class="col-md-8">
				<div class="control-group row">
					{!! Form::label('location', 'Location co-ordinates', ['class'=>"col-md-3  control-label"]) !!}
					<div class="col-md-2">
						<span id="hidden-location">
							@if($location->lat != 0 && $location->lon != 0)
								{!! $location->lat !!}, {!! $location->lon !!}
							@else
								<em>-not set-</em>
							@endif
						</span>
						{!! Form::hidden('lat', $location->lat, ['class' => "form-control", 'placeholder' => ""]) !!}
						{!! Form::hidden('lon', $location->lon, ['class' => "form-control", 'placeholder' => ""]) !!}
					</div>
					<small>Use the map to change the location</small>
				</div>
				<div class="control-group row">
					{!! Form::label('visible', 'Published', ['class'=>"col-md-3  control-label"]) !!}
					<div class="col-md-2">
					{!! Form::checkbox('visible', $location->visible, ['class' => "form-control"]) !!}
					</div>
					<small>Leaving this unticked keeps the location as a draft and not shown publicaly.</small>
				</div>


				<table class="table table-condensed table-striped table-hover location-tag-table">
					<tr>
						<th>Key</th>
						<th>Value</th>
						<th></th>
					</tr>
				@foreach($loc_tags as $tag)
					<tr class="default-row location-tag" key="{{$tag->key}}" tag-key-id="{{$tag->id}}">
						<td>{{$tag->label}}</td>
						<td class="tag-value">{{$tag->value}}</td>
						<td>{!! Form::button('change', ['class' => "btn btn-default action-change-item"]) !!}</td>
						{!! Form::hidden('tag['. $tag->key .']', $tag->default_value, ['class' => "form-control tag-hidden"]) !!}
					</tr>
				@endforeach
				</table>


				<h3>Add/edit a tag value</h3>
					<div class="control-group row">
						{!! Form::label('key', 'Key', ['class'=>"col-md-3 control-label"]) !!}
						<div class="col-md-4">
							<select name="key" class="form-control key-to-edit">
								<option value="" selected="selected">-- select --</option> 
							@foreach($options_keys as $option)
								<option value="{!! $option->key !!}" input-type="{!! $option->value_type !!}">{!! $option->label !!}</option>
							@endforeach
							</select>
						</div>
					</div>
					<div class="control-group row">
						{!! Form::label('value', 'Value', ['class'=>"col-md-3 control-label"]) !!}
						<div class="col-md-4 tag-value-input tag-value-input-text">
							{!! Form::text('value-text', null, ['class' => "form-control", 'placeholder' => "Default value"]) !!}
						</div>
						<div class="col-md-4 tag-value-input tag-value-input-boolean">
							<select name="value-boolean" class="form-control">
								<option value="" selected="selected">-- select --</option>
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
						<div class="col-md-4 tag-value-input tag-value-input-telephone">
							{!! Form::text('value-telephone', null, ['class' => "form-control", 'placeholder' => "0123456789"]) !!}
						</div>
						<div class="col-md-4 tag-value-input tag-value-input-website">
							{!! Form::text('value-website', null, ['class' => "form-control", 'placeholder' => "http://"]) !!}
						</div>
					</div>


				<div class="form-group">
					{!! Form::submit('Update Location and Tags', ['class' => "btn btn-default"]) !!}
				</div>
			</div>

			<div class="col-md-4">
				<div id="map"></div>
			</div>
		{!! Form::close() !!}
	</div>


@endsection