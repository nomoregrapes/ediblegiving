
/* needed vars */
	var map;
	var lyrStuff;


	$( document ).ready(function() {
		//load map
		if( location.hash != undefined && location.hash != '') {
			var thehash = location.hash.substr(1),
			hashlocation = thehash.substr(thehash.indexOf('location=')).split('&')[0].split('=')[1];
			locparts = hashlocation.split('/');
			map = L.mapbox.map('map').setView([locparts[1], locparts[2]], locparts[0]); //from URL
		} else {
			//map = L.mapbox.map('map').setView([54.8, -1.6], 11); //Durham
			map = L.mapbox.map('map').setView([52.92, -1.08], 6); //UK

			//geolocate attempt
			map.locate({setView: true, maxZoom: 10}); //causes browser to hang, just in Saddler St office?
		}

		//more base layers
		var OSMLayer = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: 'Base map © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		});
		map.addLayer(OSMLayer);

		var baseJson = {
			"type":"FeatureCollection",
			"features":[
			]
		};

		lyrStuff = L.mapbox.featureLayer(baseJson, {
			//onEachFeature: attachClickEvent
		})
		.addTo(map);

		getEGLocations();

	});