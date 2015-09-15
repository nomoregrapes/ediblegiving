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
		@yield('extra-css')
	</head>

	<body>

	<div id="content">
		<div id="site-title-container">
			<div id="site-title"><img id="site-logo" src="/images/site-title.png"><h1>Edible Giving</h1></div>
		</div>
		<div id="map"></div>
	</div>

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