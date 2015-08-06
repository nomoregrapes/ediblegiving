@extends('layouts.manage')

@section('title')
	Defaults - Manage
@endsection

@section('content')
	<h1 class="cover-heading">Defaults</h1>
	<p>These are the default properties for new locations added in your organisation. They are not required, but it often makes adding new locations quicker and with the right information.</p>

	<table class="table table-condensed table-striped table-hover">
		<tr>
			<th>Key</th>
			<th>Default value</th>
			<th>Set/changed on</th>
			<th></th>
		</tr>
	@foreach($defaults as $tag)
		<tr>
			<td>{{$tag->label}}</td>
			<td>{{$tag->default_value}}</td>
			<td>{{ date('dS M Y', strtotime($tag->updated_at)) }}</td>
			<td>change?</td>
		</tr>
	@endforeach
	</table>


@endsection
