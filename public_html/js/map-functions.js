
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