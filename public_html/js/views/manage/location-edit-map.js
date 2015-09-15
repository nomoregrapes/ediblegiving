
/* needed vars */
	var map;
	var lyrStuff;

	/* overwrite getting/updating locations */
	function getEGLocations() {
		//TODO: update this to get from the Db
		var data = 'bbox=' + map.getBounds().toBBoxString();
		$.ajax({
				url: mapDataURL,
				dataType: 'json',
				data: data,
				success: showLocations
		});
	}

	/* overwrite show locations, so we can colour the marker of interest */
	function showLocations(ajaxresponse) {
		lyrStuff.clearLayers();
		lyrStuff.setGeoJSON(ajaxresponse);
		//(on click removed)
		//register click event again, because the option "onEachFeature: attachClickEvent" doesn't work.
		lyrStuff.on('dragend', function(e) {
			console.log('dragged');
			markerInfo(e.layer.feature);
		});
		//colour marker that we're editing
		lyrStuff.eachLayer(function(marker) {
			if (marker.toGeoJSON().properties.id == mapCurrentLocation.id) {
				marker.setIcon(L.mapbox.marker.icon({
					'marker-color': '#551a8b',
					'marker-size': 'large'
				}));
				marker.dragging.enable();
				marker.on('dragend', locationMoved);
			}
		});
	}
	function locationMoved(e) {
		//update the location in the form (to 6 decimal places)
		$('#hidden-location').html(+e.target.getLatLng().lat.toFixed(6) + ", " + +e.target.getLatLng().lng.toFixed(6)); //display
		$('input[name="lat"]').val( +e.target.getLatLng().lat.toFixed(6) );
		$('input[name="lon"]').val( +e.target.getLatLng().lng.toFixed(6) );
	}

	$( document ).ready(function() {
		//load map
		//no predefined location or geolocate, zoom to one were editing
		map = L.mapbox.map('map').setView([mapCurrentLocation.lat, mapCurrentLocation.lon], 14);

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