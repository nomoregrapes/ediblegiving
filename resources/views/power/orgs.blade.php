@extends('layouts.power')

@section('title')
	Orgs - Power
@endsection

@section('content')
	<h1 class="cover-heading">Organisations</h1>

	<table class="table table-condensed table-striped table-hover">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Description</th>
			<th>Note</th>
			<th>User count</th>
			<th>Date created</th>
		</tr>
	@foreach($organisations as $org)
		<tr>
			<td>{{$org->id}}</td>
			<td>{{$org->name}}</td>
			<td>{{$org->description}}</td>
			<td>{{$org->admin_note}}</td>
			<td>{{$org->user_count}}</td>
			<td>{{ date('dS M Y', strtotime($org->created_at)) }}</td>
		</tr>
	@endforeach
	</table>

@endsection
