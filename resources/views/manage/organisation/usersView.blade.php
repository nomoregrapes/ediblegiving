@extends('layouts.manage')

@section('title')
	{{$user->username}} - Users - Power
@endsection

@section('content')
	<h1 class="cover-heading">{{$user->name_full}}</h1>

	<h3>Details of {{$user->name_full}}</h3>
	<dl class="dl-horizontal">
		<dt>ID</dt>
			<dd>{{$user->id}}</dd>
		<dt>Username</dt>
			<dd>{{$user->username}}</dd>
		<dt>Email</dt>
			<dd>{{$user->email}}</dd>
		<dt>Signed Up</dt>
			<dd>{{ date('dS M Y', strtotime($user->created_at)) }}</dd>
		<dt>Logs in with</dt>
			<dd>{{$user->provider}}</dd>
		<dt>Picture</dt>
			<dd><img src="{{$user->avatar_url}}" style="max-width:150px;"></dd>
		<dt>Role within '{{$org->name}}'</dt>
			<dd>
			@foreach($user_roles as $role)
				{{$role->display_name}}
				{{-- 
					{!! Form::open(['method' => 'post', 'url' => 'manage/organisation/'. $org->slug.'/usersrole/'. $user->username, 'class' => 'form-inline form-table-row']) !!}
						{!! Form::hidden('user_id', $user->id) !!}
						{!! Form::hidden('organisation_id', $role->organisation_id) !!}
						{!! Form::hidden('role_id', $role->role_id) !!}
						{!! Form::hidden('task', 'remove') !!}
						{!! Form::submit('Remove Role', ['class' => "btn btn-default"]) !!}
					{!! Form::close() !!}
				--}}
				@if (count($user_roles) < 1)
					<br>
				@endif
			@endforeach
			</dd>
	</dl>


	{{-- 
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
	--}}


@endsection
