@extends('layouts.power')

@section('title')
	{{$user->username}} - Users - Power
@endsection

@section('content')
	<h1 class="cover-heading">{{$user->username}}</h1>

	<h3>Details of {{$user->username}}</h3>
	<dl class="dl-horizontal">
		<dt>ID</dt>
			<dd>{{$user->id}}</dd>
		<dt>Username</dt>
			<dd>{{$user->username}}</dd>
		<dt>Email</dt>
			<dd>{{$user->email}}</dd>
		<dt>Signed Up</dt>
			<dd>{{ date('dS M Y', strtotime($user->created_at)) }}</dd>
	</dl>

	<h3>Roles of {{$user->username}}</h3>
	<table class="table table-condensed table-striped table-hover">
		<tr>
			<th>Organisation</th>
			<th>Role</th>
			<th>Actions</th>
		</tr>
	@if (count($user_roles) < 1)
		<tr>
			<td colspan="4">No roles held</td>
		</tr>
	@else
		@foreach($user_roles as $role)
			<tr>
				<td>{{$role->name}}</td>
				<td title="{{$role->description}}">{{$role->display_name}}</td>
				<td>Remove Role?</td>
			</tr>
		@endforeach
	@endif
	</table>



	<h3>Add Role</h3>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	{!! Form::open(['method' => 'post', 'url' => 'manage/power/users/'. $user->username]) !!}
		{!! Form::hidden('user_id', $user->id) !!}
		<div class="form-group">
			{!! Form::label('organisation_id', 'Organisation') !!}
			<select name="organisation_id">
			@foreach($organisations as $org)
				<option value="{!! $org->id !!}">{!! $org->name !!}</option>
			@endforeach
			</select>
		</div>
		<div class="form-group">
			{!! Form::label('role_id', 'Role') !!}
			<select name="role_id">
			@foreach($roles as $role)
				<option value="{!! $role->id !!}">{!! $role->display_name !!}</option>
			@endforeach
			</select>
		</div>
		<div class="form-group">
			{!! Form::submit('Add', ['class' => "btn btn-default"]) !!}
		</div>
	{!! Form::close() !!}



@endsection
