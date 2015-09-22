@extends('layouts.manage')

@section('title')
	Import - Locations - Manage
@endsection

@section('content')
	<h1 class="cover-heading">Import Locations</h1>
	<p>These import systems are experimental and should only be used with proper understanding.</p>

	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	<div class="row">
		{!! Form::open(['url' => '/manage/import/' . $org->slug . '/geojson', 'class'=>'form-horizontal']) !!}
			<div class="col-md-8">
				<h3>Import geoJSON file</h3>
				<div class="control-group row">
					{!! Form::label('jsonurl', 'Online geoJSON URL', ['class'=>"col-md-3 control-label"]) !!}
					<div class="col-md-4">
						{!! Form::text('jsonurl', null, ['class' => "form-control", 'placeholder' => "http://www. ... .json"]) !!}
					</div>
				</div>


				<div class="form-group">
					{!! Form::submit('Preview data', ['class' => "btn btn-default"]) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>


@endsection