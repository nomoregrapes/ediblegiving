<html>
<head>
	<title>Add locations, Edible Giving .org</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" />


</head>

<body>

    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Edible Giving .org</a>
			<ul class="nav navbar-nav">
				<li><a href="map.php">Map</a></li>
				<li><a href="about.php">About</a></li>
				<li class="active"><a href="data.php">Add Locations</a></li>
			</ul>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div><!--/.navbar-collapse -->
    </nav>


	<div class="container">
		<div class="page-header">
			<h1>Add Locations</h1>
		</div>
		<p class="lead">The aims of this website can only be achieved if other organisations bring their locations to it.</p>
		<p>The website is in progress and it is planned to make it easier for you to add and manage locations, however there are already a number of ways to supply locations. You may need to talk to your organisation's website developer or IT expert to follow these methods, or get in touch with me yourself by e-mailing info[at]ediblegiving.org</p>
		<p>If you already manage your locations in a database or online system, can you generate a geojson file containing the expected properties? Then send me an e-mail with the URL and I'll add it to the sources list for automatic retrival.</p>
		<p>Supplying other geospatial file formats is possible, but I'll probably have to convert these manually and so it won;t be possible to update so frequently. Get in touch to talk about it.</p>
		<p>You can use a third-party website, <a href="http://geojson.io/">geojson.io</a> to create the locations with the required properties (ask me for an example!) and then save the geojson file to e-mail it to me. You can also use that to add the map with markers to your own website.</p>
		<p>The code is on <a href="http://www.github.com">Github</a> including some geojson files. Fork the code, add or edit a geojson file, then the sources file. Send a pull request and I'll try to work out how to accept/merge it.</p>

		<h2>Current sources</h2>
		<ul>
		<?php
			//use our data source array here
			require_once('data/sources.php');
			foreach($sources as $s) {
				echo '<li>';
				echo '<strong>' . $s['name'] . '</strong>';
				if(isset($s['updated_date'])) {
					echo ', last update '. $s['updated_date'] .'';
				}
				if(isset($s['source_desc'])) {
					echo ' - '. $s['source_desc'] .'';
				}
				echo ' <a href="'. $s['url'] .'">geojson</a>';
				if(isset($s['desc_url'])) {
					echo ' | <a href="'. $s['desc_url'] .'">information</a>';
				}
				echo '</li>';
			}
		?>
		</ul>
	</div> <!-- /container -->

      <hr>

      <footer>
        <p>Website by <a href="http://twitter.com/gregorymarler">Gregory Marler</a> of <a href="http://www.nomoregrapes.com">No More Grapes</a>.</p>
      </footer>



	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js" />

</body>
</html>