<html>
	<head>
		<title>
			@section('title')
				Edible Giving
			@show
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- CSS are placed here -->
		{!! HTML::style('css/bootstrap.min.css') !!}
		{!! HTML::style('css/bootstrap-theme.min.css') !!}
		{!! HTML::style('css/bootstrap-cover.css') !!}
		<!-- {!! HTML::style('css/app.css') !!} -->

	</head>

	<body>

		<div class="site-wrapper">

			<div class="site-wrapper-inner">

				<div class="cover-container">

					<div class="masthead clearfix">
						<div class="inner">
							<h3 class="masthead-brand">Edible Giving .org</h3>
							<!--
							<nav>
							<ul class="nav masthead-nav">
							<li class="active"><a href="#">Home</a></li>
							<li><a href="#">Features</a></li>
							<li><a href="#">Contact</a></li>
							</ul>
							</nav>
							-->
						</div>
					</div>

					<div class="inner cover">
						@yield('content')
					</div>

					<div class="mastfoot">
						<div class="inner">
							<p>Website by <a href="http://twitter.com/gregorymarler">Gregory Marler</a> of <a href="http://www.nomoregrapes.com">No More Grapes</a>.</p>
						</div>
					</div>

				</div>

			</div>

		</div>


        <!-- Scripts are placed here -->
        {!! HTML::script('js/jquery-1.11.2.min.js') !!}
        {!! HTML::script('js/bootstrap.min.js') !!}

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