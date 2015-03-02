<html>
<head>
	<title>Food Giving</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" />

  <!-- for the map -->
	<link rel="stylesheet" href="lib/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.min.css" />
	<link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css" />
	<link rel="stylesheet" href="lib/eg-styles.css" />
	<script src="lib/jquery-ui-1.10.4/js/jquery-1.10.2.js"></script>
	<script src="https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js"></script>
	<script src="lib/eg-map.js"></script>

</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Edible Giving</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container map-filters">
        <h2>Hello, world!</h2>
        	<div class="input-group" id="filter-activity">
				<label for="donation-points">Donation points</label>
				<input type="checkbox" activity="donation" id="donation-points" checked="checked">

				<label for="distribution-points">Distribution points</label>
				<input type="checkbox" activity="distribution" id="distribution-points" checked="checked">

				<label for="volunteering-locations">Volunteering locations</label>
				<input type="checkbox" activity="volunteering" id="volunteering-locations" checked="checked">

				<label for="office-locations">Office locations</label>
				<input type="checkbox" activity="office" id="office-locations" checked="checked">
			</div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-8">
        	<div id="map"></div>
        </div>
        <!-- side column of detailed info -->
        <div class="col-md-4">
          <h2></h2>
          <p>.</p>
       </div>

      <hr>

      <footer>
        <p>Website by <a href="http://twitter.com/gregorymarler">Gregory Marler</a> of <a href="http://www.nomoregrapes.com">No More Grapes</a>.</p>
      </footer>
    </div> <!-- /container -->



	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js" />

</body>
</html>