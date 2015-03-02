
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

/*
			$("#slider").dateRangeSlider({
				bounds: {min: new Date(-4000, 0, 1),
					max: new Date(2014, 5, 1)
				},
				defaultValues: {min: new Date(-3200, 0, 1),
					max: new Date(1776, 6, 4)}
			});

			$("#slider").bind("valuesChanged", function(e, data){
				//console.log("Values just changed. min: " + data.values.min + " max: " + data.values.max);

				//odd value fixes
				var rangeMin = data.values.min.getYear() + 1900;
				var rangeMax = data.values.max.getYear() + 1900;

				lyrStuff.setFilter(function(f) {
					//check if it's in date
					if(f.properties['earliest_date'] != undefined) {
						if(f.properties['earliest_date'] > (rangeMin) ) {
							afterMin = true;
						} else {
							afterMin = false; //before range
						}
					} else {
						afterMin = true; //assume
					}

					if(f.properties['latest_date'] != undefined) {
						if(f.properties['latest_date'] < (rangeMax) ) {
							beforeMax = true;
						} else {
							beforeMax = false; //before range
						}
						if(f.properties['earliest_date'] == undefined) {
							if(f.properties['latest_date'] < (rangeMin) ) {
								afterMin = false; //overwrite our assumption
							}
						}
					} else {
						beforeMax = true; //assume
					}


					if(f.properties['latest_date'] == undefined && f.properties['earliest_date'] != undefined) {
						if(f.properties['earliest_date'] > (rangeMax) ) {
							beforeMax = false; //overwrite our assumption
						}
					}
					
					//old style checks
					afterStart = (f.properties['earliest_date'] >= (rangeMin) );
					beforeEnd =  (f.properties['earliest_date'] <= (rangeMax) );


					//make the changes
					return afterMin && beforeMax;
				});
			});
*/


		});