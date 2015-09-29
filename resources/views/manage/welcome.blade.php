@extends('layouts.manage')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management Area</h1>
	<p class="lead">
		Welcome, {!! Auth::user()->name_first; !!}! To manage locations on Edible Giving, you need to be authorised by an organisation
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


@endsection
