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


@endsection
