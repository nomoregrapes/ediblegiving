@extends('layouts.power')

@section('title')
	Power
@endsection

@section('content')
	<h1 class="cover-heading">Power index</h1>
	<p class="lead">
		Hello {{Auth::user()['attributes']['name_first']}}.
	</p>
@endsection
