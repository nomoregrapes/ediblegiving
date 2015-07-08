@extends('layouts.power')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management index</h1>
	<p class="lead">
		Welcome back, {!! Auth::user()->name_first; !!}!
	</p>
	<p>
		Now we display some links to the areas you can manage.
	</p>
@endsection
