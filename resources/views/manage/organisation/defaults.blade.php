@extends('layouts.manage')

@section('title')
	Defaults - Manage
@endsection

@section('extra-js')
	{!! HTML::script('js/views/manage/organisation-defaults.js') !!}
@endsection

@section('content')
	<h1 class="cover-heading">Defaults</h1>
	<p>These are the default properties for new locations added in your organisation. They are not required, but it often makes adding new locations quicker and with the right information.</p>

	<table class="table table-condensed table-striped table-hover">
		<tr>
			<th>Key</th>
			<th>Default value</th>
			<th>Set/changed on</th>
			<th></th>
		</tr>
	@foreach($defaults as $tag)
		<tr class="default-row" key="{{$tag->key}}" tag-id="{{$tag->id}}">
			<td>{{$tag->label}}</td>
			<td class="tag-value">{{$tag->default_value}}</td>
			<td>{{ date('dS M Y', strtotime($tag->updated_at)) }}</td>
			<td>{!! Form::submit('change', ['class' => "btn btn-default action-change-item"]) !!}</td>
		</tr>
	@endforeach
	</table>

	<h3>Add/edit deafult tag</h3>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	{!! Form::model($org, ['method' => 'POST', 'url' => 'manage/organisation/'. $org->slug .'/defaults']) !!}
		<div class="form-group">
			{!! Form::label('key', 'Key') !!}
			<select name="key" class="form-control">
				<option value="" selected="selected">-- select --</option> 
			@foreach($options_keys as $option)
				<option value="{!! $option->key !!}" input-type="{!! $option->value_type !!}">{!! $option->label !!}</option>
			@endforeach
			</select>
		</div>
		<div class="form-group">
			{!! Form::label('value', 'Value') !!}
			<div class="tag-value-input tag-value-input-text">
				{!! Form::text('value-text', null, ['class' => "form-control", 'placeholder' => "Default value"]) !!}
			</div>
			<div class="tag-value-input tag-value-input-boolean">
				<select name="value-boolean" class="form-control">
					<option value="" selected="selected">-- select --</option>
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</div>
			<div class="tag-value-input tag-value-input-telephone">
				{!! Form::text('value-telephone', null, ['class' => "form-control", 'placeholder' => "0123456789"]) !!}
			</div>
			<div class="tag-value-input tag-value-input-website">
				{!! Form::text('value-website', null, ['class' => "form-control", 'placeholder' => "http://"]) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::hidden('value-type', '') !!}
			{!! Form::hidden('id', '') !!}
			{!! Form::submit('Add', ['class' => "btn btn-default"]) !!}
		</div>
	{!! Form::close() !!}


@endsection
