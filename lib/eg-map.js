
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
			//register click event again, because the option "onEachFeature: attachClickEvent" doesn't work.
			lyrStuff.on('click', function(e) {
				markerInfo(e.layer.feature);
			});
		}

		//when a marker is clicked
		function attachClickEvent(feature, layer)
		{
			//does this only work if when we load the initial (empty) geojson?
			layer.on('click', markerInfo, feature);
			//could we have passed the parent of "feature" so we can know the source details?
		}
		function markerInfo(thisFeature)
		{
			$('#map-marker-details').fadeOut(400, function() {
				//clear old details
				$('.mmd-dynamic').text('');
				//set details
				$('.mmd-name').text(thisFeature.properties.name);
				if(thisFeature.properties.telephone != undefined) {
					$('.mmd-telephone').text("Tel: "+ thisFeature.properties.telephone);
				}
				$('.mmd-address').text(thisFeature.properties.postal_address);
				if(thisFeature.properties.website != undefined) {
					$('.mmd-website').html('<a href="'+ thisFeature.properties.website +'">visit website</a>');
				}
				$('.mmd-opening').text(thisFeature.properties.opening_times);

				$('#map-marker-details').fadeIn();
			});
			
		}

		$( document ).ready(function() {
			//load map
			map = L.mapbox.map('map').setView([54.8, -1.6], 11);
			//geolocate
			//map.locate({setView: true, maxZoom: 10}); //causes browser to hang, just in Saddler St office?

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
				onEachFeature: attachClickEvent
			})
			.addTo(map);
			console.log(lyrStuff);


			getStuffLocations();



			$(".map-filters input").change(function(e){

				//define the function to filter each marker
				lyrStuff.setFilter(function(f) {
					tickedActivity = false; //shall we show this marker?

					//go through each of the CHECKED activity filters
					$('#filter-activity input:checked').each(function(index, thisCheck) {
						//for this filter, does the layer have that activity?
						var thisFilter = 'activity_' + $(thisCheck).attr('activity');
						if(f.properties[thisFilter] != undefined && f.properties[thisFilter] == true) {
							tickedActivity = true;
							//one filter being true is enough, skip out of the each loop
							return false;
						}
					});

					tickedFoodType = false;
					//go through each of the CHECKED food types
					$('#filter-foodtype input:checked').each(function(index, thisCheck) {
						//for this filter, does the layer have that activity?
						var thisFoodType = 'food_type_' + $(thisCheck).attr('foodtype');
						if(f.properties[thisFoodType] != undefined && f.properties[thisFoodType] == true) {
							tickedFoodType = true;
							//one filter being true is enough, skip out of the each loop
							return false;
						}
					});

					//if the marker is a checked activity AND a checked food type, show it
					if(tickedActivity && tickedFoodType) {
						return true; //show
					} else {
						return false; //hide
					}
				});

			}); //end filtering


		});