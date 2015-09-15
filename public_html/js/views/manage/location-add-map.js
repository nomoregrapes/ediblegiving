
/* needed vars */
	var map;
	var lyrStuff;
	var locationAdded = 0;

	/* overwrite getting/updating locations */
	function getEGLocations() {
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
		//colour marker that we're editing -, don't IT'S A NEW ONE
/*		
		lyrStuff.eachLayer(function(marker) {
			if (marker.toGeoJSON().properties.id == -1) {
				marker.setIcon(L.mapbox.marker.icon({
					'marker-color': '#551a8b',
					'marker-size': 'large'
				}));
				marker.dragging.enable();
				marker.on('dragend', locationMoved);
			}
		});
*/
	}
	function locationMoved(e) {
		//update the location in the form (to 6 decimal places)
		$('#hidden-location').html(+e.target.getLatLng().lat.toFixed(6) + ", " + +e.target.getLatLng().lng.toFixed(6)); //display
		$('input[name="lat"]').val( +e.target.getLatLng().lat.toFixed(6) );
		$('input[name="lon"]').val( +e.target.getLatLng().lng.toFixed(6) );
	}

	$( document ).ready(function() {
		//load map
		//no location = no place to start. //COULDDO: start with view of all the orgs locations?
		map = L.mapbox.map('map').setView([52.92, -1.08], 6); //UK
		//geolocate attempt
		map.locate({setView: true, maxZoom: 10}); //causes browser to hang, just in Saddler St office?

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


		//if the map is clicked, add this new marker
		map.on('click', function(e){
			if(locationAdded == 0) {
				locationAdded = 1;
				newLocation = L.mapbox.featureLayer({
					"type": "Feature",
					"properties": {
						"id": -1,
						'marker-color': '#551a8b',
						'marker-size': 'large',
						"draggable": "true"
					},
					"geometry": {
						"type": "Point",
						"coordinates": [e.latlng.lng, e.latlng.lat]
					}
				})
				.addTo(lyrStuff)
				.eachLayer(function(marker) {
					marker.dragging.enable();
					marker.on('dragend', locationMoved);
				});
				//set that initial location in the form (to 6 decimal places)
				$('#hidden-location').html(+e.latlng.lat.toFixed(6) + ", " + +e.latlng.lng.toFixed(6)); //display
				$('input[name="lat"]').val( +e.latlng.lat.toFixed(6) );
				$('input[name="lon"]').val( +e.latlng.lng.toFixed(6) );
			}
		});

		getEGLocations();


	});