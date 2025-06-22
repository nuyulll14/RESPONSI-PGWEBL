@extends('layout/template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <style>
        #map {
            width: 100%;
            height: calc(100vh - 56px);
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>

    <!-- Modal Create Point -->
    <div class="modal fade" id="createpointModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Point</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('points.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill the point name">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="geom_point" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_point" name="geom_point" rows="3" readonly></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image_point" name="image"
                                onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-point" class="img-thumbnail"
                                width="500">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Create Polyline -->
    <div class="modal fade" id="createpolylineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Polyline</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('polylines.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill the polyline name">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="geom_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_polyline" name="geom_polyline" rows="3" readonly></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image_polyline" name="image"
                                onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polyline" class="img-thumbnail"
                                width="500">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Create Polygon -->
    <div class="modal fade" id="createpolygonModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Polygon</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('polygons.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill the polygon name">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="geom_polygon" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_polygon" name="geom_polygon" rows="3" readonly></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image_polygon" name="image"
                                onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polygon" class="img-thumbnail"
                                width="500">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <script>
        // Set Map
        var map = L.map('map').setView([-7.673, 110.622], 12); // Center di Klaten

        // Basemap
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3'],
            attribution: 'Google Satellite'
        });

        osm.addTo(map); // Default basemap

        /*
         * WMS LAYER FROM GEOSERVER
         */
        var wmsAdministrasi = L.tileLayer.wms('http://localhost:8080/geoserver/responsi_klaten/wms', {
            layers: 'responsi_klaten:ADMINISTRASIDESA_AR_25K',
            format: 'image/png',
            transparent: true,
            opacity: 0.7, // Style transparansi
            attribution: 'Administrasi Desa Klaten'
        });

        var wmsJalan = L.tileLayer.wms('http://localhost:8080/geoserver/responsi_klaten/wms', {
            layers: 'responsi_klaten:JALAN_LN_25K',
            format: 'image/png',
            transparent: true,
            attribution: 'Jalan Klaten'
        });


        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false // Diubah ke false agar konsisten dengan form input
            },
            edit: {
                featureGroup: drawnItems, // Edit hanya pada layer hasil digitasi
                remove: true
            }
        });
        map.addControl(drawControl);


        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            if (type === 'polyline') {
                $('#geom_polyline').val(objectGeometry);
                $('#createpolylineModal').modal('show');
            } else if (type === 'polygon' || type === 'rectangle') {
                $('#geom_polygon').val(objectGeometry);
                $('#createpolygonModal').modal('show');
            } else if (type === 'marker') {
                $('#geom_point').val(objectGeometry);
                $('#createpointModal').modal('show');
            }

            drawnItems.addLayer(layer);
        });

        // GeoJSON Point from Database
        var point = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var routedelete = "{{ route('points.destroy', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);
                var routeedit = "{{ route('points.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                var popupContent =
                    "<h5>" + feature.properties.name + "</h5>" +
                    "<b>Deskripsi:</b> " + feature.properties.description + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                    "' class='img-fluid mt-2' alt='...'>" + "<br>" +
                    "<hr>" +
                    "<div class='d-flex justify-content-between'>" +
                    "<a href='" + routeedit + "' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i> Edit</a>" +
                    "<form method='POST' action='" + routedelete + "'>" +
                    '@csrf' + '@method('DELETE')' +
                    "<button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'><i class='fa-solid fa-trash'></i> Hapus</button>" +
                    "</form>" +
                    "</div>";

                layer.on({
                    click: function(e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function(e) {
                        layer.bindTooltip(feature.properties.name).openTooltip();
                    },
                });
            },
        });
        $.getJSON("{{ route('api.points') }}", function(data) {
            point.addData(data);
        });

        // GeoJSON Polyline from Database
        var polyline = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var routedelete = "{{ route('polylines.destroy', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);
                var routeedit = "{{ route('polylines.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                var popupContent = "<h5>" + feature.properties.name + "</h5>" +
                    "<b>Deskripsi:</b> " + feature.properties.description + "<br>" +
                    "<b>Panjang:</b> " + feature.properties.length_km.toFixed(2) + " km" + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                    "' class='img-fluid mt-2' alt='...'>" + "<br>" +
                    "<hr>" +
                    "<div class='d-flex justify-content-between'>" +
                    "<a href='" + routeedit + "' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i> Edit</a>" +
                    "<form method='POST' action='" + routedelete + "'>" +
                    '@csrf' + '@method('DELETE')' +
                    "<button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'><i class='fa-solid fa-trash'></i> Hapus</button>" +
                    "</form>" +
                    "</div>";

                layer.on({
                    click: function(e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function(e) {
                        layer.bindTooltip(feature.properties.name).openTooltip();
                    },
                });
            },
        });
        $.getJSON("{{ route('api.polylines') }}", function(data) {
            polyline.addData(data);
        });

        // GeoJSON Polygon from Database
        var polygon = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var routedelete = "{{ route('polygons.destroy', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);
                var routeedit = "{{ route('polygons.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                var popupContent = "<h5>" + feature.properties.name + "</h5>" +
                    "<b>Deskripsi:</b> " + feature.properties.description + "<br>" +
                    "<b>Luas:</b> " + feature.properties.area_hektar.toFixed(2) + " Ha" + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                    "' class='img-fluid mt-2' alt='...'>" + "<br>" +
                    "<hr>" +
                     "<div class='d-flex justify-content-between'>" +
                    "<a href='" + routeedit + "' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i> Edit</a>" +
                    "<form method='POST' action='" + routedelete + "'>" +
                    '@csrf' + '@method('DELETE')' +
                    "<button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'><i class='fa-solid fa-trash'></i> Hapus</button>" +
                    "</form>" +
                    "</div>";

                layer.on({
                    click: function(e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function(e) {
                        layer.bindTooltip(feature.properties.name).openTooltip();
                    },
                });
            },
        });
        $.getJSON("{{ route('api.polygons') }}", function(data) {
            polygon.addData(data);
        });


        /* Layer Control */
        var baseMaps = {
            "OpenStreetMap": osm,
            "Google Satellite": satellite
        };

        var overlayMaps = {
            "Administrasi Desa (WMS)": wmsAdministrasi,
            "Jalan (WMS)": wmsJalan,
            "Titik (Database)": point,
            "Garis (Database)": polyline,
            "Area (Database)": polygon,
            "Data Digitasiku": drawnItems
        };

        L.control.layers(baseMaps, overlayMaps, {
            collapsed: false // Agar kontrol layer tidak terlipat
        }).addTo(map);

    </script>
@endsection
