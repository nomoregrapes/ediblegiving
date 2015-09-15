@extends('layouts.manage')

@section('title')
	New - Locations - Manage
@endsection

@section('extra-js')
	{!! HTML::script('js/views/manage/location-edit.js') !!}
@endsection

@section('content')
	<h1 class="cover-heading">Add A Location</h1>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	<div class="row">
		{!! Form::open(['url' => '/manage/location/' . $org->slug . '/store', 'class'=>'form-horizontal']) !!}
			<div class="col-md-8">
				<div class="control-group row">
					{!! Form::label('location', 'Location co-ordinates', ['class'=>"col-md-3  control-label"]) !!}
					<div class="col-md-2">
						<span id="hidden-location">0,0</span>
						{!! Form::hidden('latitude', 0, ['class' => "form-control", 'placeholder' => ""]) !!}
						{!! Form::hidden('longitude', 0, ['class' => "form-control", 'placeholder' => ""]) !!}
					</div>
					<small>Use the map to set the location</small>
				</div>
				<div class="control-group row">
					{!! Form::label('visible', 'Published', ['class'=>"col-md-3  control-label"]) !!}
					<div class="col-md-2">
					{!! Form::checkbox('visible', 1, ['class' => "form-control"]) !!}
					</div>
					<small>Leaving this unticked keeps the location as a draft and not shown publicaly.</small>
				</div>


				<table class="table table-condensed table-striped table-hover location-tag-table">
					<tr>
						<th>Key</th>
						<th>Value</th>
						<th></th>
					</tr>
				@foreach($defaults as $tag)
					<tr class="default-row location-tag" key="{{$tag->key}}" tag-key-id="{{$tag->id}}">
						<td>{{$tag->label}}</td>
						<td class="tag-value">{{$tag->default_value}}</td>
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
					<!--
					<div class="control-group row">
						<div class="col-md-3"></div>
						<div class="col-md-4">
							{!! Form::button('change', ['class' => "btn btn-default action-change-item"]) !!}
						</div>
					</div>
					--!>


				<div class="form-group">
					{!! Form::submit('Add Location', ['class' => "btn btn-default"]) !!}
				</div>
			</div>

			<div class="col-md-4">
				<div id="map"></div>
			</div>
		{!! Form::close() !!}
	</div>


@endsection