@extends('layouts.manage')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management dashboard</h1>
	<p class="lead">
		Welcome back, {!! Auth::user()->name_first; !!}!
	</p>
	<p>
		@if(count($orgs) > 1)
			The list below gives you various options for the organisations that you are associated with.
		@else
			The following options are available for you to manage {{$orgs[0]->name}} on Edible Giving.
		@endif

		<table class="table table-condensed table-striped table-hover">
		@foreach($orgs as $org)
			<tr>
				<td>{{$org->name}}</td>
				@if(array_key_exists('org-locations-view', $org->permissions))
					<td><a href="{{ URL::to('/manage/location/' . $org->slug) }}">locations</a></td>
					@else <td>-</td>
				@endif
				@if(array_key_exists('org-locations-view', $org->permissions))
					<td><a href="{{ URL::to('/manage/output/' . $org->slug . '/') }}">export</a></td>
					@else <td>-</td>
				@endif
				@if(array_key_exists('org-locations-edit', $org->permissions))
					<td><a href="{{ URL::to('/manage/import/' . $org->slug . '') }}">import</a></td>
					@else <td>-</td>
				@endif
				@if(array_key_exists('org-defaults-edit', $org->permissions))
					<td><a href="{{ URL::to('/manage/organisation/' . $org->slug . '/defaults') }}">defaults</a></td>
					@else <td>-</td>
				@endif
				@if(array_key_exists('org-users-view', $org->permissions) || array_key_exists('org-users-full', $org->permissions))
				<td><a href="{{ URL::to('/manage/organisation/' . $org->slug . '/users') }}">users</a></td>
					@else <td>-</td>
				@endif
			</tr>
		@endforeach
		</table>

	</p>
@endsection
