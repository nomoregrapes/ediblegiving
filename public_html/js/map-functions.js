
	/* utility function adjusted from https://github.com/shramov/leaflet-plugins/blob/master/control/Permalink.js */
	function round_point(point) {
		var bounds = map.getBounds(), size = map.getSize();
		var ne = bounds.getNorthEast(), sw = bounds.getSouthWest();

		var round = function (x, p) {
			if (p === 0) return x;
			var shift = 1;
			while (p < 1 && p > -1) {
				x *= 10;
				p *= 10;
				shift *= 10;
			}
			return Math.floor(x)/shift;
		};
		point.lat = round(point.lat, (ne.lat - sw.lat) / size.y);
		point.lng = round(point.lng, (ne.lng - sw.lng) / size.x);
		return point;
	}

	function updatePermalink() {
		var centre = round_point(map.getCenter());
		var url = window.location.origin + $('base').attr('href') + "map"; //need the base due to dev machine weidness
		var urlHash = "location=" + map.getZoom() + "/" + centre.lat + "/" + centre.lng;
		//console.log(url);
		window.location.hash = urlHash;
		$('#permalink-map').attr('href', url + '/#' + urlHash );
	}


	function getEGLocations() {
		//TODO: update this to get from the Db
		var data = 'bbox=' + map.getBounds().toBBoxString();
		$.ajax({
				url: window.location.origin + '/data/simpledata.json',
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


	function placeSearch() {
		$('#results').html('Loading...');
		var inp = document.getElementById("query");
 		$.getJSON('http://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + inp.value, function(data) {
			var items = [];
			$.each(data, function(key, val) {
				items.push(
					"<li><a href='#' onclick='placeChoose(" +
					val.lat + ", " + val.lon + ");return false;'>" + val.display_name +
					'</a></li>'
				);
			});
			$('#results').empty();
			if (items.length != 0) {
				items.push(
					"<li><a href='#' onclick='placeResultClose();return false;'>" + " [Close search results]" +
					"</a></li>"
				);
				//$('<p>', { html: "Search results:" }).appendTo('#results');
				$('<ul/>', {
					'class': 'searchResultsList',
					html: items.join('')
				}).appendTo('#results');
			} else {
				$('<p>', { html: "No places found" }).appendTo('#results');
			}
			$('#results').fadeIn();
		});
	}
	$('#search-form').on('submit', function() {
		placeSearch();
		return false;
	});
	$('#results').hide(); //bug fix?

	function placeChoose(lat, lng, type) {
		var location = new L.LatLng(lat, lng);
		map.panTo(location);
		if (type == 'city' || type == 'administrative') {
			map.setZoom(11);
		} else {
			map.setZoom(13);
		}
	}

	function placeResultClose() {
		$('#results').fadeOut(400, function() {
			$('#results').empty();
		});
	}