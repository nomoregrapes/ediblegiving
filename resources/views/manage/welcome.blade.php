@extends('layouts.power')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management index</h1>
	<p class="lead">
		Welcome, {!! Auth::user()->username; !!}!
	</p>
	<p>
		We should tell you instructions on what to do next. You need to be part of an organisation.
	</p>
@endsection
