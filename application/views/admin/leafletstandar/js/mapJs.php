	<link rel="stylesheet" href="<?= base_url('assets/js/leaflet-compass-master/src/leaflet-compass.css') ?>" />
	<!-- Make sure you put this AFTER Leaflet's CSS -->
	<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin=""></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHqhgVQmhdp3XAJ91LHRdXJ3YOjP1V2Gs" async defer></script>
	<script src="<?= base_url('assets/js/leaflet-panel-layers-master/src/leaflet-panel-layers.js') ?>"></script>
	<script src="<?= base_url('assets/js/leaflet.ajax.js') ?>"></script>
	<script src="<?= base_url('assets/js/leaflet-compass-master/src/leaflet-compass.js') ?>"></script>
	<script src="<?= base_url('assets/js/Leaflet.GoogleMutant.js') ?>"></script>
	<script src="<?= site_url('admin/api/data/kecamatan') ?>"></script>

	<script type="text/javascript">
		var map = L.map('map').setView([-5.375879, 105.3014113], 12);
		var layersKecamatan = [];
		var Layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 18,
		});
		var roadMutant = L.gridLayer.googleMutant({
			maxZoom: 24,
			type: 'roadmap'
		});

		map.addLayer(Layer);

		
		var myStyle2 = {
			"color": "#ffff00",
			"weight": 1,
			"opacity": 0.9
		};

		function getColorKecamatan(NAMOBJ) {
			for (i = 0; i < dataKecamatan.length; i++) {
				var data = dataKecamatan[i];
				if (data.nm_kecamatan == NAMOBJ) {
					return data.warna_kecamatan;
				}
			}
		}

function popUp(f, l) {
    var html = '';
    if (f.properties) {
        html += '<table>';
        html += '<tr>';
        html += '<td colspan="3"><img src="<?= base_url('assets/icon-map.png') ?>" width="50%"></td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>' + f.properties['NAMOBJ'] + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td>' + f.properties['WADMKC'] + '</td>';
        html += '</tr>';
        html += '</tr>';
        html += '</table>';
        l.bindPopup(html);
        l.bindTooltip(f.properties['KECAMATAN'], {
            permanent: true,
            direction: "center",
            className: "no-background"
        });
    }
}


		// legend

		function iconByName(name) {
			return '<i class="icon" style="background-color:' + name + ';border-radius:100%"></i>';
		}


				var baseLayers = [{
			name: 'Satelite Google',
			layer: L.gridLayer.googleMutant({
				maxZoom: 24,
				type: 'satellite'
			})
		}, 
		{
			name: 'OpenStreetMap',
			layer: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			})
		}];

		for (i = 0; i < dataKecamatan.length; i++) {
			var data = dataKecamatan[i];
			var layer = {
				name: data.nm_kecamatan,
				icon: iconByName(data.warna_kecamatan),
				layer: new L.GeoJSON.AJAX(["<?= base_url() ?>assets/unggah/geojson/" + data.geojson_kecamatan], {
					onEachFeature: popUp,
					style: function(feature) {
						var NAMOBJ = feature.properties.NAMOBJ;
						return {
							"color": getColorKecamatan(NAMOBJ),
							"weight": 1,
							"opacity": 1
						}

					},
				}).addTo(map)
			}
			layersKecamatan.push(layer);
		}

		var overLayers = [{
			group: "Layer Pola Ruang",
			layers: layersKecamatan
		}];

		var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers, {
			collapsibleGroups: true
		});

		map.addControl(panelLayers);
	</script>
