<html>
	<head>
		<title>
			@if(!'title')
				Edible Giving
			@else
				@yield('title') - Edible Giving
			@endif
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- CSS are placed here -->
		{!! HTML::style('css/bootstrap.min.css') !!}
		{!! HTML::style('css/bootstrap-theme.min.css') !!}
		{!! HTML::style('css/manage.css') !!}
		@yield('extra-css')
	</head>

	<body>

		<nav class="navbar navbar-manage navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button> 
					<a class="navbar-brand" href="/">
						<div id="site-title"><img id="site-logo" src="/images/site-title.png"><h1>Edible Giving</h1></div>
					</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						
						@if (isset($org) && !Request::is( 'manage') )
							<li {{ Request::is( 'manage') ? 'class=active' : '' }}><a href="/manage">Management Dashboard</a></li>
							<li class="org-title">{{$org->name}}</li>
							{{-- TODO: list links depending what the user can manage in this org --}}
							<li {{ Request::is( 'manage/location/*') ? 'class=active' : '' }}><a href="{{ URL::to('/manage/location/' . $org->slug) }}">locations</a></li>
							<li {{ Request::is( 'manage/output/*') ? 'class=active' : '' }}><a href="{{ URL::to('/manage/output/' . $org->slug . '/') }}">export</a></li>
							<li {{ Request::is( 'manage/import/*') ? 'class=active' : '' }}><a href="{{ URL::to('/manage/import/' . $org->slug . '') }}">import</a></li>
							<li {{ Request::is( 'manage/organisation/*/defaults') ? 'class=active' : '' }}><a href="{{ URL::to('/manage/organisation/' . $org->slug . '/defaults') }}">defaults</a></li>
							<li {{ Request::is( 'manage/organisation/*/users') ? 'class=active' : '' }}><a href="{{ URL::to('/manage/organisation/' . $org->slug . '/users') }}">users</a></li>
						@endif
					</ul>
				</div>
			</div>
		</nav>

		@yield('precontent')

		<div class="container">
            <!-- Content -->
            @yield('content')
		</div> <!-- /container -->

		<hr>

		<footer>
			<p>Website by <a href="http://twitter.com/gregorymarler">Gregory Marler</a> of <a href="http://www.nomoregrapes.com">No More Grapes</a>.</p>
		</footer>


        <!-- Scripts are placed here -->
        {!! HTML::script('js/jquery-1.11.2.min.js') !!}
        {!! HTML::script('js/bootstrap.min.js') !!}
        @yield('extra-js')

		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-2841516-14', 'auto');
		ga('send', 'pageview');

		</script>

	</body>
</html>