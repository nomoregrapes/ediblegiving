@extends('layouts.manage')

@section('title')
	Users - Manage
@endsection

@section('content')
	<h1 class="cover-heading">Users</h1>

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
			<td><a href="{{ URL::to('/manage/organisation/'. $org->slug .'/users/' . $user->username) }}">{{$user->name_full}}</a></td>
			<td>{{$user->email}}</td>
			<td>{{$user->display_name}}</td>
			<td>{{ date('dS M Y', strtotime($user->created_at)) }}</td>
		</tr>
	@endforeach
	</table>


@endsection
