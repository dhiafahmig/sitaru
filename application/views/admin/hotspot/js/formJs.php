	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
	<!-- Make sure you put this AFTER Leaflet's CSS -->
	<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin=""></script>

	<!-- Load Esri Leaflet from CDN -->
	<script src="https://unpkg.com/esri-leaflet@2.3.3/dist/esri-leaflet.js" integrity="sha512-cMQ5e58BDuu1pr9BQ/eGRn6HaR6Olh0ofcHFWe5XesdCITVuSBiBZZbhCijBe5ya238f/zMMRYIMIIg1jxv4sQ==" crossorigin=""></script>


	<!-- Load Esri Leaflet Geocoder from CDN -->
	<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.css" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
	<script src="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.js" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
	<link rel="stylesheet" href="assets\dist\L.Control.Locate.min.css">
	<script src="assets\dist\L.Control.Locate.min.js"></script>
	<script src="<?= base_url('assets/js/leaflet.ajax.js') ?>"></script>

	<script type="text/javascript">
		var latInput = document.querySelector("[name=lat]");
		var lngInput = document.querySelector("[name=lng]");
		var lokasiInput = document.querySelector("[name=lokasi]");
		var idKecamatanInput = document.querySelector("[name=id_kecamatan]");
		var geocodeService = L.esri.Geocoding.geocodeService();
		var marker;
		var map = L.map('map').setView([-5.375879, 105.3014113], 12);

		var Layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
			maxZoom: 18,
			id: 'mapbox.streets',
			accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
		});
		map.addLayer(Layer);

		///
		var kabupaten = new L.GeoJSON.AJAX("<?= base_url() ?>assets/geojson/bandarlampung.geojson").addTo(map);
		kabupaten.on("click", function(e) {
			var lat = e.latlng.lat;
			var lng = e.latlng.lng;
			if (!marker) {
				marker = L.marker(e.latlng).addTo(map)
			} else {
				marker.setLatLng(e.latlng);
			}


			latInput.value = lat;
			lngInput.value = lng;

			$.ajax({
				url: "https://nominatim.openstreetmap.org/reverse",
				data: "lat=" + lat +
					"&lon=" + lng +
					"&format=json",
				dataType: "JSON",
				success: function(data) {
					console.log(data);
					lokasiInput.value = data.display_name;
				}
			})



			geocodeService.reverse().latlng(e.latlng).run(function(error, result) {
				if (error) {
					return;
				}
				console.log(result);
				var district = result.address.District;
				idKecamatanInput.selectedIndex = 0;
				for (i = 0; i < idKecamatanInput.options.length; i++) {
					if (idKecamatanInput.options[i].text == district) {
						idKecamatanInput.selectedIndex = i;
						break;
					}
				}
			});
		});

		// draw
		// FeatureGroup is to store editable layers

		    // Mendapatkan lokasi pengguna menggunakan geolokasi dari browser
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

      function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    // Menampilkan lokasi pengguna di peta
    function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;

        if (!marker) {
            marker = L.marker([lat, lng]).addTo(map);
        } else {
            marker.setLatLng([lat, lng]);
        }

        map.setView([lat, lng], 12);
    }

    // Membuat tombol untuk mendapatkan live location
    var liveLocationButton = L.control({ position: 'topright' });

    liveLocationButton.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
        div.innerHTML = '<a href="#" onclick="getLocation()"></a>';
        return div;
    };

    liveLocationButton.addTo(map);
		
	</script>
