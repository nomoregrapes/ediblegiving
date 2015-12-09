@extends('layouts.manage')

@section('title')
	Export - Locations - Manage
@endsection

@section('content')
	<h1 class="cover-heading">Locations</h1>
	<p>Your organisation has <strong>??</strong> locations in Edible Giving.</p>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	<div class="row">
		<div class="col-md-8">
			<p>Leave this page open while the CSV file is being generated.</p>
			<button>Generate CSV file</button>

			<p>When a CSV file has been generated, it will be here for you to save to your computer.</p>
			<p><a href="{{$csvLatest}}">fresh CSV file</a></p>
		</div>
	</div>

	<h2>Coming Soon</h2>
	<p>It is planned that outputs will be available in the following forms. If these are important to you and you wish to help development of them, please <a href="/about">get in touch</a>.
	<ul>
		<li>Map on your website - a simple bit of HTML iframe code to add once & updates automatically</li>
		<li>geoJSON feed - for use programming the live data into other systems</li>
		<li>Defaults & org info - export not just your locations, but other information saved on Edible Giving</li>
	</ul>


@endsection