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


	<h2>Add a new organisation</h2>
	<form>
		<div class="form-group">
			<label for="newOrgName">Name</label>
			<input type="text" class="form-control" id="newOrgName" placeholder="Enter organisation name">
		</div>
		<div class="form-group">
			<label for="newOrgDescription">Description</label>
			<input type="text" class="form-control" id="newOrgDescription" placeholder="Public description of the organisation">
		</div>
		<div class="form-group">
			<label for="newOrgNote">Note</label>
			<input type="text" class="form-control" id="newOrgNote" placeholder="Optional note about this organisation">
		</div>
		
		<button type="submit" class="btn btn-default">Add</button>
	</form>

@endsection
