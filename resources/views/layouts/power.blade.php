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
		{!! HTML::style('css/app.css') !!}
		@yield('extra-css')
	</head>

	<body>

		<nav class="navbar navbar-inverse navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button> 
					<a class="navbar-brand" href="/">Edible Giving .org</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li {{ Request::is( 'manage/power/users*') ? 'class=active' : '' }}><a href="/manage/power/users">Users</a></li>
						<li {{ Request::is( 'manage/power/orgs*') ? 'class=active' : '' }}><a href="/manage/power/orgs">Organisations</a></li>
						<li {{ Request::is( 'manage/power/statistics*') ? 'class=active' : '' }}><a href="/manage/power/statistics">Statistics</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="alert alert-danger" role="alert">! admin area !</div>

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