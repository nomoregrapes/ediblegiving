@extends('layouts.power')

@section('title')
	Create Organisation - Power
@endsection

@section('content')
	<h1 class="cover-heading">Add a new organisation</h1>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	{!! Form::open(['url' => 'manage/power/orgs']) !!}
		<div class="form-group">
			{!! Form::label('name', 'Name') !!}
			{!! Form::text('name', null, ['class' => "form-control", 'placeholder' => "Enter organisation name"]) !!}
		</div>
		<div class="form-group">
			{!! Form::label('description', 'Description') !!}
			{!! Form::text('description', null, ['class' => "form-control", 'placeholder' => "Public description of the organisation"]) !!}
		</div>
		<div class="form-group">
			{!! Form::label('admin_note', 'Note') !!}
			{!! Form::text('admin_note', null, ['class' => "form-control", 'placeholder' => "Optional note, for admins, about this organisation"]) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Add', ['class' => "btn btn-default"]) !!}
		</div>
	{!! Form::close() !!}

@endsection
