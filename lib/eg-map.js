
		var map;
		var lyrStuff;

		function getStuffLocations() {
			var data = 'bbox=' + map.getBounds().toBBoxString();
			$.ajax({
					url: 'data/uk-foodbanks-durham.geojson',
					dataType: 'json',
					data: data,
					success: showLocations
			});
		}
		function showLocations(ajaxresponse) {
			lyrStuff.clearLayers();
			lyrStuff.setGeoJSON(ajaxresponse);
			lyrStuff.eachLayer(function(layer) {
			    var content = '<h2>' + layer.feature.properties.name + '<\/h2>' +
			        '<p>Earliest date: ' + layer.feature.properties.earliest_date + '<br \/>' +
			        'category: ' + layer.feature.properties.category + '<\/p>' + 
			        '<p><a href="http://www.openhistoricalmap.org/#map=' + layer.feature.properties.zoom_recomendation + '/' + layer.feature.geometry.coordinates[1] + '/' + layer.feature.geometry.coordinates[0] + '&layers=H" target="_blank">view on OHM';
			    layer.bindPopup(content);
			});
		}
		function attachClickEvent(feature, layer)
		{
			//layer.on('click', visitCam, feature.properties.refCode);
		}
		function visitCam()
		{
			//console.log("hello"+ this);
			window.location = "selfie.php?cam=" + this;
		}
		$( document ).ready(function() {
			//load map
			map = L.mapbox.map('map').setView([50, 0], 2);
			//geolocate
			map.locate({setView: true, maxZoom: 10});
			//add cams
			//var camerasFile = 'getcams.php';

			//more base layers
			var OSMLayer = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: 'Maps from <a href="http://wiki.openstreetmap.org/wiki/OHM">OHM</a>',
			});
			map.addLayer(OSMLayer);

			//add a layer switcher
			var baseMaps = {
				"OpenStretMap": OSMLayer
			};
			L.control.layers(baseMaps).addTo(map);



			var baseJson = {
				"type":"FeatureCollection",
				"features":[
				]
			};

			lyrStuff = L.mapbox.featureLayer(baseJson, {
				//onEachFeature: attachClickEvent
			})
			.addTo(map);


			getStuffLocations();



			$("#filter-activity input").change(function(e){

				//define the function to filter each marker
				lyrStuff.setFilter(function(f) {
					thisMarker = false; //shall we show this marker?
					//go through each of the CHECKED activity filters
					$('#filter-activity input:checked').each(function(index, thisCheck) {
						//for this filter, does the layer have that activity?
						var thisFilter = 'activity_' + $(thisCheck).attr('activity');
						if(f.properties[thisFilter] != undefined && f.properties[thisFilter] == true) {
							thisMarker = true;
							//one filter being true is enough, skip out of the each loop
							return false;
						}
					});
					if(thisMarker == false) {
						return false; //hide
					} else {
						return true; //show
					}
				});

			});


		});