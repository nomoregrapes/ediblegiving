@extends('layouts.power')

@section('title')
	Orgs - Power
@endsection

@section('content')
	<h1 class="cover-heading">Organisations</h1>
	<p class="lead">
		Hello {{Auth::user()['attributes']['username']}}.
	</p>
@endsection
