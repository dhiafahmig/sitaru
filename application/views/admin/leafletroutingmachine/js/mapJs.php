<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/leaflet-search/dist/leaflet-search.min.css') ?>">

<style type="text/css">
    #map {
        width: 100%;
        height: 600px;
    }
    .search-tip b {
        display: inline-block;
        clear: left;
        float: right;
        padding: 0 4px;
        margin-left: 4px;
    }

    .Banjir.search-tip b,
    .Banjir.leaflet-marker-icon {
        background: #f66;
    }

    /* Media query for mobile devices */
    @media (max-width: 768px) {
        .leaflet-routing-container {
            display: none;
        }
    }
</style>

<!-- Pastikan ini dipanggil SETELAH CSS Leaflet -->
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="<?= base_url('assets/js/leaflet-routing-machine/examples/Control.Geocoder.js') ?>"></script>
<script src="<?= base_url('assets/js/leaflet-search/dist/leaflet-search.src.js') ?>"></script>
<script src="<?= site_url('admin/api/data/hotspot/varpoint') ?>"></script>

<div id="map"></div>

<script type="text/javascript">
var map = L.map('map').setView([-5.375879, 105.3014113], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    getLocation();

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    // Define control variable in a higher scope
    var control;

    function showPosition(position) {
        $("[name=latNow]").val(position.coords.latitude);
        $("[name=lngNow]").val(position.coords.longitude);

        // Add user location marker
        var userIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.3.4/dist/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.3.4/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        var userMarker = L.marker([position.coords.latitude, position.coords.longitude], { icon: userIcon }).addTo(map);
        userMarker.bindPopup("You are here").openPopup();

        // Calculate distance to each hotspot
        layersHotspotPoint.eachLayer(function(layer) {
            let userLatLng = L.latLng(position.coords.latitude, position.coords.longitude);
            let hotspotLatLng = layer.getLatLng();
            let distance = userLatLng.distanceTo(hotspotLatLng); // distance in meters

            // Add distance to popup content
            let popupContent = layer.getPopup().getContent();
            popupContent += "<br>Distance: " + (distance / 1000).toFixed(2) + " km"; // Convert to km and format
            layer.setPopupContent(popupContent);
        });

        // Create routing control
        control = L.Routing.control({
            waypoints: [
                L.latLng(position.coords.latitude, position.coords.longitude),
                // Placeholder for destination, will be updated on marker click
            ],
            routeWhileDragging: true,
            geocoder: L.Control.Geocoder.nominatim()
        }).addTo(map);

        // Update routing control on marker click
        layersHotspotPoint.eachLayer(function(layer) {
            layer.on('click', function() {
                if (control) {
                    control.spliceWaypoints(0, 1, L.latLng(position.coords.latitude, position.coords.longitude));
                    control.spliceWaypoints(control.getWaypoints().length - 1, 1, layer.getLatLng());
                }
            });
        });
    }

    // Hotspot
    var layersHotspotPoint = L.geoJSON(hotspotPoint, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: new L.icon({
                    iconUrl: feature.properties.icon,
                    iconSize: [38, 45]
                })
            });
        },
        onEachFeature: function(feature, layer) {
            let coord = feature.geometry.coordinates;
            if (feature.properties && feature.properties.name) {
                console.log(feature);
                let detailUrl = '<?= base_url("admin/hotspot/detail/lihat/") ?>' + feature.properties.id;
                let status = feature.properties.status ? feature.properties.status : 'Status tidak ada'; // Periksa apakah status ada
                let googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${coord[1]},${coord[0]}`; // Google Maps URL
                let popupContent = feature.properties.popUp +
                    "<br>Status: " + status + // Menambahkan status
                    "<br><br> <a href='" + detailUrl + "' class='btn btn-primary' style='margin-left: 5px; color: white;'> Detail</a>" +
                    "<br><br> <a href='" + googleMapsUrl + "' target='_blank' class='btn btn-success' style='margin-left: 5px; color: white;'> Open in Google Maps</a>"; // Add Google Maps button with green color

                layer.bindPopup(popupContent);
            }
        }
    }).addTo(map);

    // Add click event to start routing from user location to hotspot
    layersHotspotPoint.eachLayer(function(layer) {
        layer.on('click', function() {
            if (control) {
                control.spliceWaypoints(0, 1, L.latLng($("[name=latNow]").val(), $("[name=lngNow]").val()));
                control.spliceWaypoints(control.getWaypoints().length - 1, 1, layer.getLatLng());
            }
        });
    });
</script>