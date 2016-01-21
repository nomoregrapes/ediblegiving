@extends('layouts.mapfull-page')

@section('title')
	Map
@endsection

@section('extra-css')
@endsection
<script type="text/javascript">
	@if($org_specific == true)
		window.data_params = [];
		window.data_params['org'] = '{{$org->slug}}';
	@endif
</script>
@section('extra-js')
	{!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js') !!}
	{!! HTML::script('js/lib/opening_hours.min.js') !!}
	{!! HTML::script('js/map-functions.js') !!}
	{!! HTML::script('js/map-full.js') !!}
@endsection


@section('side-control')
	@if($org_specific == true)
		<h2>{{$org->name}}</h2>
		<p>{{$org->description}}</p>
	@endif
	<h2>Find your area...</h2>
	<div id="search">
	{!! Form::open(['id'=>'search-form']) !!}
		{!! Form::text('query', null, ['id'=>"query", 'class' => "form-control", 'size'=>"6", 'placeholder' => "City or area name"]) !!}
		<button type="button" onclick="placeSearch();">Find</button>
	{!! Form::close() !!}
		<div id="results"></div>
	</div>

	<h2>Map display</h2>
		<div class="map-filters">
			@if($org_specific == false)
			<div class="input-group" id="filter-foodtype">
				<span class="filter-intro">Show places if they accept...</span>
				<div>
					<label for="unopened-food">Non-perishable food
					<input type="checkbox" foodtype="unopened" id="unopened-food" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="fresh-food">Fresh food
					<input type="checkbox" foodtype="fresh" id="fresh-food" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<!-- unharvested produce -->
			</div>
			@endif
			<div class="input-group" id="filter-activity">
				<span class="filter-intro">Show places that...</span>
				<div>
					<label for="donation-points">you can Donate
					<input type="checkbox" activity="donation" id="donation-points" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				@if($org_specific == true)
				<div>
					<label for="distribution-points">you can get food and support
					<input type="checkbox" activity="distribution" id="distribution-points" checked="checked">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				@endif
				<div>
					<label for="volunteering-locations">you can Volunteer
					<input type="checkbox" activity="volunteering" id="volunteering-locations">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				<div>
					<label for="office-locations">is the organisation Office
					<input type="checkbox" activity="office" id="office-locations">
					<div class="checkbox-eye"></div>
					</label>
				</div>
			</div>
			<div class="input-group" id="filter-opening">
				{{-- this is not supported in the mapFilter yet
				<div>
					<label for="opening-today">is open Today
					<input type="checkbox" opening="{{}}" id="opening-today">
					<div class="checkbox-eye"></div>
					</label>
				</div>
				--}}
				<div>
					<label for="opening">open on
					<select id="opening-on">
						<option value="any" selected="selected">Any day</option>
						<option value="<?php echo date('d M Y 13:00'); ?>">Today ({{date('l')}})</option>
					<?php $next_date = new DateTime() ?>
					@for ($i = 0; $i < 6; $i++)
						<?php $next_date->modify('+1 day'); ?>
						<option value="<?php echo $next_date->format('d M Y 13:00'); ?>">{{$next_date->format('l')}}</option>
					@endfor
					</select>
					</label>
				</div>
			</div>
		</div>
	@if($org_specific == true)
		<hr>
		<p>The map is only showing locations for {{$org->name}}. More places to donate food are shown on the main <a href="http://ediblegiving.org">Edible Giving</a> website.</p>
	@endif
@endsection


@section('side-info')
		<div id="side-welcome">
			<h2>Welcome</h2>
			<p>Use Edible Giving to find {{ $org_specific==true ? 'where' : 'organisations that' }} you can donate food or your time to. </p>
			<p>
				First use the "map display" controls to change what markers are shown.
				Then click a marker to bring up further details.
			</p>
			@if($org_specific == false)
			<p>
				<div id="site-links" style="display: inline-block; padding: 0;">
				Head to the <a href="/about" id="about" style="margin-left:0;">About <span class="link-icon">About</span></a>
				 page, for information on how the locations are collected and the vision of Edible Giving.
				</div>
			</p>
			@endif
		</div>
		<div class="hide" id="map-marker-details">
			<h2 class="mmd-dynamic mmd-name"></h2>
			<p class="mmd-dynamic mmd-telephone"></p>
			<p class="mmd-dynamic mmd-address"></p>
			<p class="mmd-dynamic mmd-opening"></p>
			<p class="mmd-dynamic mmd-description"></p>
			<p class="mmd-links">
				<span class="mmd-addtolist"><a href="#">add to list</a></span> | 
				<span class="mmd-dynamic mmd-website"></span>
			</p>
		</div>
		<div class="location-list-heading hide">
			<hr>
			<strong>Your location list</strong>
		</div>
		<div class="" id="location-list">
		</div>
@endsection

