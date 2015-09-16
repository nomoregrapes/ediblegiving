
var map;
var lyrStuff;


function getEGLocations() {
	var data = 'bbox=' + map.getBounds().toBBoxString();
	$.ajax({
			url: 'data/simpledata.json',
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
		$('#map-marker-details .mmd-dynamic').text('');
		//set details
		$('#map-marker-details .mmd-name').text(thisFeature.properties.name);
		if(thisFeature.properties.telephone != undefined) {
			$('#map-marker-details .mmd-telephone').text("Tel: "+ thisFeature.properties.telephone);
		}
		$('#map-marker-details .mmd-address').text(thisFeature.properties.postal_address);
		if(thisFeature.properties.website != undefined) {
			$('#map-marker-details .mmd-website').html('<a href="'+ thisFeature.properties.website +'">visit website</a>');
		}
		$('#map-marker-details .mmd-opening').text(thisFeature.properties.opening_times);

		$('#map-marker-details .mmd-description').text(thisFeature.properties.loc_text);

		$('#map-marker-details').removeClass('hide').fadeIn();
	});
	
}

//when they want to add a location to the temp list
function addToList(e)
{
	e.preventDefault();
	$newItem = $('#map-marker-details').clone();
	$newItem.removeClass().removeAttr('id'); 
	$newItem.find('.mmd-dynamic').removeClass('mmd-dynamic');
	//TODO: change the h2 to something smaller by way of a clss of lots of js?
	$newItem.find('.mmd-addtolist').addClass('mmd-removefromlist').removeClass('mmd-addtolist');
	$newItem.find('.mmd-removefromlist a').text('Remove from list');
	$('#location-list').append( $newItem );
	
	$('.location-list-heading').removeClass('hide').show(); //incase that hasn't happened yet
}
//and when they want to remove it
function removeFromList(e)
{
	e.preventDefault();
	$($(this).context).parentsUntil('#location-list').remove();
}

//
function filterMarkers() {
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

		//first colour it?
		f.properties['marker-color'] = '#551a8b';

		//if the marker is a checked activity AND a checked food type, show it
		if(tickedActivity && tickedFoodType) {
			return true; //show
		} else {
			return false; //hide
		}
	});
} //end filterMarkers function

$( document ).ready(function() {
	//load map
	var mapSettings = {zoomControl: false};
	if( location.hash != undefined && location.hash != '') {
		var thehash = location.hash.substr(1),
		hashlocation = thehash.substr(thehash.indexOf('location=')).split('&')[0].split('=')[1];
		locparts = hashlocation.split('/');
		map = L.mapbox.map('map', null, mapSettings).setView([locparts[1], locparts[2]], locparts[0]); //from URL
	} else {
		//map = L.mapbox.map('map').setView([54.8, -1.6], 11); //Durham
		map = L.mapbox.map('map', null, mapSettings).setView([52.92, -1.08], 6); //UK

		//geolocate attempt
		map.locate({setView: true, maxZoom: 10}); //causes browser to hang, just in Saddler St office?
	}

	//more base layers
	var OSMLayer = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	attribution: 'Base map © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	});
	//map.addLayer(OSMLayer);
	var mapboxStyles = [
		'mapbox.streets', 'mapbox.light', 'mapbox.dark', 'mapbox.satellite', 'mapbox.streets-satellite', //5
		'mapbox.wheatpaste', 'mapbox.streets-basic', 'mapbox.comic', 'mapbox.outdoors', 'mapbox.run-bike-hike', //10
		'mapbox.pencil', 'mapbox.pirates', 'mapbox.emerald', 'mapbox.high-contrast' //14
		];
	var MapboxLayer = L.tileLayer('https://api.mapbox.com/v4/'+ mapboxStyles[0] +'/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoibm9tb3JlZ3JhcGVzIiwiYSI6IjBCZTk3eVUifQ.No55nZtxByLYKNnyKMglbA', {
	attribution: 'Base map © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, with Mapbox style',
	});
	map.addLayer(MapboxLayer);

	//add a layer switcher
	var baseMaps = {
		"OpenStretMap": OSMLayer
	};
	//L.control.layers(baseMaps).addTo(map);



	var baseJson = {
		"type":"FeatureCollection",
		"features":[
		]
	};

	lyrStuff = L.mapbox.featureLayer(baseJson, {
		onEachFeature: attachClickEvent
	})
	.addTo(map);


	getEGLocations();

	//when the map get panned
	map.on('moveend', function(e){
		updatePermalink();
	});

	$(".map-filters input").change(function(e){
		filterMarkers();
	});
	filterMarkers();

	//js links...
	$('#map-marker-details').on('click', '.mmd-addtolist a', addToList);
	$('#location-list').on('click', '.mmd-removefromlist a', removeFromList);

	//some display stuff for startup...
	$('.hide').hide();
	updatePermalink();

});