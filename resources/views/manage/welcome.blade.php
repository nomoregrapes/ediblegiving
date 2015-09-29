@extends('layouts.manage')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management Area</h1>
	<p class="lead">
		Welcome, {!! $user->name_first; !!}! To manage locations on Edible Giving, you need to be authorised by an organisation
	</p>
	{{-- orgs can authorise people yet.
	<p>
		If a charity or organisation has told you to login, contact them directly as they will now be able to give you access to the management area.
	</p>
	--}}

	<p>
		Are you the lead person in your organisation that will be using Edible Giving? Contact the Edible Giving administrators to give you access to the management area.
		We'll help you with adding locations where donations can be made, and keeping all infomation up-to-date.
	</p>


	@if($errors->any())
	<ul class="alert alert-danger">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	@endif

	{!! Form::open(['url' => '/manage/newcontact/', 'class'=>'form-horizontal new-user-contact-form']) !!}
		<div class="control-group row">
			{!! Form::label('name', 'Your Name', ['class'=>"col-md-3 control-label"]) !!}
			<div class="col-md-4">
				{!! Form::text('name', $user->name_full, ['class' => "form-control", 'placeholder' => "Albert Brown"]) !!}
			</div>
			<div class="col-md-4">
				@if(isset($user->name_full))
				<small>Enter your real name, if it is not correct on {{$user->provider}}.</small>
				@endif
			</div>
		</div>
		<div class="control-group row">
			{!! Form::label('email', 'Your e-mail address', ['class'=>"col-md-3 control-label"]) !!}
			<div class="col-md-4">
				{!! Form::text('email', $user->email, ['class' => "form-control", 'placeholder' => "albert@example.com"]) !!}
			</div>
			<div class="col-md-4">
				@if(isset($user->email))
				<small>If {{$user->provider}} does not have the e-mail address you use, change this.</small>
				@endif
			</div>
		</div>
		<div class="control-group row">
			{!! Form::label('organisation', 'Organisation ', ['class'=>"col-md-3 control-label"]) !!}
			<div class="col-md-4">
				{!! Form::text('organisation', null, ['class' => "form-control", 'placeholder' => "Countryshire Food Banks"]) !!}
			</div>
		</div>
		<div class="control-group row">
			{!! Form::label('message', 'Message ', ['class'=>"col-md-3 control-label"]) !!}
			<div class="col-md-4">
				{!! Form::textarea('message', null, ['class' => "form-control", 'placeholder' => "Optional"]) !!}
			</div>
			<div class="col-md-4">
				<small>Please explain your role in the organisation, to make it quicker to understand and deal with your request. If your organisation is not yet on Edible Giving, it is helpful to mention details of size, and give a sentence or URL that explains the nature of the organisation.</small>
			</div>
		</div>

		{{-- TODO: but in extra spam checking blocks --}}

		<div class="control-group row">
			<div class="col-md-4 col-md-offset-3">
				{!! Form::submit('Send details, to request Edible Giving access', ['class' => "btn btn-default"]) !!}
			</div>
		</div>
	{!! Form::close() !!}

@endsection
