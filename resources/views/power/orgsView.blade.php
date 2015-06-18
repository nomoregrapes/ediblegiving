@extends('layouts.power')

@section('title')
	{{$organisation->name}} - Organisations - Power
@endsection

@section('content')
	<h1 class="cover-heading">{{$organisation->name}}</h1>

	<h3>Users of {{$organisation->name}}</h3>
	<table class="table table-condensed table-striped table-hover">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Role</th>
			<th>Joined</th>
		</tr>
	@foreach($users as $user)
		<tr>
			<td>{{$user->id}}</td>
			<td>{{$user->username}}</td>
			<td>{{$user->email}}</td>
			<td>{{$user->display_name}}</td>
			<td>{{ date('dS M Y', strtotime($user->created_at)) }}</td>
		</tr>
	@endforeach
	</table>



	<h3>Update details</h3>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	{!! Form::model($organisation, ['method' => 'PATCH', 'url' => 'manage/power/orgs/'. $organisation->id]) !!}
		<div class="form-group">
			{!! Form::label('name', 'Name') !!}
			{!! Form::text('name', null, ['class' => "form-control", 'placeholder' => "Enter organisation name"]) !!}
		</div>
		<div class="form-group">
			{!! Form::label('slug', 'Slug') !!}
			Warning, do not change.
			{!! Form::text('slug', null, ['class' => "form-control", 'placeholder' => "Enter organisation slug"]) !!}
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
