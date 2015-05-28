@extends('layouts.power')

@section('title')
	Users - Power
@endsection

@section('content')
	<h1 class="cover-heading">Users</h1>
	<p class="lead">
		Hello {{Auth::user()['attributes']['username']}}.
	</p>
@endsection
