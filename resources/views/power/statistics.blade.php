@extends('layouts.power')

@section('title')
	Stats - Power
@endsection

@section('content')
	<h1 class="cover-heading">Statistics</h1>
	<p class="lead">
		Hello {{Auth::user()['attributes']['username']}}.
	</p>
@endsection
