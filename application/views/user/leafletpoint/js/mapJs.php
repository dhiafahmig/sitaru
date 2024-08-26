	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/leaflet-search/dist/leaflet-search.min.css') ?>">
	<style type="text/css">
		.search-tip b {
			display: inline-block;
			clear: left;
			float: right;
			padding: 0 4px;
			margin-left: 4px;
		}

		.Banjir.search-tip b,
		.Banjir.leaflet-marker-icon {
			background: #f66
		}
	</style>
	<!-- Make sure you put this AFTER Leaflet's CSS -->
	<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin=""></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHqhgVQmhdp3XAJ91LHRdXJ3YOjP1V2Gs" async defer></script>
	<script src="<?= base_url('assets/js/leaflet-panel-layers-master/src/leaflet-panel-layers.js') ?>"></script>
	<script src="<?= base_url('assets/js/leaflet.ajax.js') ?>"></script>
	<script src="<?= base_url('assets/js/Leaflet.GoogleMutant.js') ?>"></script>
	<script src="<?= base_url('assets/node_modules/leaflet-easyprint/dist/bundle.js') ?>"></script>
	<script src="<?= base_url('assets/js/leaflet-search/dist/leaflet-search.src.js') ?>"></script>
	<script src="<?= site_url('admin/api/data/hotspot') ?>"></script>
	<script src="<?= site_url('admin/api/data/polaruang') ?>"></script>
	<script src="<?= site_url('admin/api/data/kategorihotspot') ?>"></script>

	<script type="text/javascript">
		var map = L.map('map').setView([-5.375879, 105.3014113], 10);
		var layersKecamatan = [];
		var layersKategorihotspot = [];
		var Layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
			maxZoom: 18,
		});

		map.addLayer(Layer);
		// easy print
		L.easyPrint({
			title: 'Leaflet EasyPrint',
			position: 'topleft',
			exportOnly: true,
			filename: 'WebGIS CI',
			sizeModes: ['Current', 'A4Portrait', 'A4Landscape']
		}).addTo(map);
		// pengaturan legend

		function iconByName(name) {
			return '<i class="icon" style="background-color:' + name + ';border-radius:50%"></i>';
		}


		function iconByImage(image) {
			return '<img src="' + image + '" style="width:16px">';
		}


		var baseLayers = [{
				name: "OpenStreetMap",
				layer: Layer
			},
			{
				name: "OpenCycleMap",
				layer: L.tileLayer('http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png')
			},
			{
				name: "Outdoors",
				layer: L.tileLayer('http://{s}.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png')
			},
			{
				name: 'Satelite Google',
				layer: L.gridLayer.googleMutant({
					maxZoom: 24,
					type: 'satellite'
				})
			},
			{
				name: "Roadmap Google",
				layer: roadMutant
			}
		];
		// Akhir konfigurasi

		//kategori hotspot
		for (i = 0; i < dataKategorihotspot.length; i++) {
			var data = dataKategorihotspot[i];
			var layer = {
				name: data.nm_kategori_hotspot,
				icon: iconByImage(data.icon),
				layer: new L.GeoJSON.AJAX(["<?= site_url('admin/api/data/hotspot/point') ?>/" + data.id_kategori_hotspot], {
					pointToLayer: function(feature, latlng) {
						// console.log(feature)
						return L.marker(latlng, {
							icon: new L.icon({
								iconUrl: feature.properties.icon,
								iconSize: [38, 45]
							})
						});
					},
					onEachFeature: function(feature, layer) {
						if (feature.properties && feature.properties.name) {
							layer.bindPopup(feature.properties.popUp);
						}
					}
				}).addTo(map)
			}
			layersKategorihotspot.push(layer);
		}
		// end pengaturan untuk layer kecamatan

		// akhir dari hotspot
		// pencarian
		// var poiLayers = L.layerGroup([
		// 	layersHotspotPoint
		// ]);
		// L.control.search({
		// 	layer: poiLayers,
		// 	initial: false,
		// 	propertyName: 'name',
		// 	buildTip: function(text, val) {
		// 		// var jenis = val.layer.feature.properties.jenis;
		// 		// return '<a href="#" class="'+jenis+'">'+text+'<b>'+jenis+'</b></a>';
		// 		return '<a href="#" >'+text+'</a>';
		// 	},
		// 	marker: {
		// 		icon: "",
		// 		circle: {
		// 			radius: 20,
		// 			color: '#f32',
		// 			opacity: 1,
		// 			weight:5
		// 		}
		// 	}
		// }).addTo(map);
		// end pencarian



		// registrasikan untuk panel layer
		var overLayers = [{
			group: "Layer Kecamatan",
			layers: layersKecamatan
		}, {
			group: "Kategori Hotspot",
			layers: layersKategorihotspot
		}];

		var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers, {
			collapsibleGroups: true
		});

		map.addControl(panelLayers);
		// end registrasikan untuk panel layer
	</script>
