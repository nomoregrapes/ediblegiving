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
			<th>Held role since</th>
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
				<td>{{ date('dS M Y', strtotime($role->created_at)) }}</td>
				<td>Remove Role?</td>
			</tr>
		@endforeach
	@endif
	</table>



@endsection
