@extends('layouts.power')

@section('title')
	Users - Power
@endsection

@section('content')
	<h1 class="cover-heading">Users</h1>

	<table class="table table-condensed table-striped table-hover">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Organisation(s)</th>
			<th>Joined</th>
		</tr>
	@foreach($users as $user)
		<tr>
			<td>{{$user->id}}</td>
			<td><a href="{{ URL::to('/manage/power/users/' . $user->username) }}">{{$user->username}}</a></td>
			<td>{{$user->email}}</td>
			<td>
			@foreach($user->orgs as $num => $org)
				{{$org->name}} ({{$org->display_name}})
				@if($num < count($user->orgs)-1 )
					<br>
				@endif
			@endforeach
			</td>
			<td>{{ date('dS M Y', strtotime($user->created_at)) }}</td>
		</tr>
	@endforeach
	</table>


@endsection
