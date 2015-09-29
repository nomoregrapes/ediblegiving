@extends('layouts.manage')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management Area</h1>
	<p class="lead">
		Thank you, {!! $user->name_first; !!}! We will get in touch about managing locations and information for Edible Giving.
	</p>


	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif


@endsection
