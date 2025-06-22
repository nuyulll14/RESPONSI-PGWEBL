@extends('layout/template')

@section('title', 'Peta Sebaran Kesehatan Klaten')

@section('styles')
    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    {{-- Leaflet Draw --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    {{-- Styling Kustom untuk Leaflet dengan Tailwind --}}
    <style>
        #map {
            width: 100%;
            /* h-16 di navbar adalah 4rem atau 64px */
            height: calc(100vh - 64px);
            z-index: 10; /* Pastikan peta di bawah UI lain seperti navbar */
        }

        /* Styling Layer Control */
        .leaflet-control-layers {
            @apply bg-white/70 backdrop-blur-sm rounded-lg shadow-lg p-4 border border-slate-200;
        }
        .leaflet-control-layers-base label,
        .leaflet-control-layers-overlays label {
            @apply font-medium text-slate-700;
        }

        /* Styling Popup */
        .leaflet-popup-content-wrapper {
            @apply bg-white rounded-xl shadow-xl border-none;
        }
        .leaflet-popup-content {
            @apply text-slate-700;
        }
        .leaflet-popup-tip {
            @apply bg-white;
        }

        /* Styling Tooltip */
        .leaflet-tooltip {
            @apply bg-slate-800 text-white border-none rounded-md shadow-md;
        }

        /* Styling Draw Toolbar */
        .leaflet-draw-toolbar {
            @apply bg-white/70 backdrop-blur-sm rounded-lg shadow-lg border border-slate-200;
        }
        .leaflet-draw-toolbar a {
            @apply bg-transparent text-slate-800;
        }
        .leaflet-draw-toolbar a:hover {
            @apply bg-cyan-100;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>

    <!-- MODAL CREATE POINT (TAILWIND + ALPINE.JS) -->
    <div x-data="{ open: false }" @open-point-modal.window="open = true" @close-modal.window="open = false" x-show="open"
        class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="open = false" x-show="open" x-transition
            class="bg-white rounded-xl shadow-xl w-full max-w-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-xl font-bold text-slate-800">Create Point</h3>
                <button @click="open = false" class="text-slate-500 hover:text-slate-800">×</button>
            </div>
            <!-- Body -->
            <form method="POST" action="{{ route('points.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-slate-700">Name</label>
                        <input type="text" id="name" name="name"
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"
                            placeholder="Fill the point name" required>
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-slate-700">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"></textarea>
                    </div>
                    <div>
                        <label for="geom_point" class="block mb-2 text-sm font-medium text-slate-700">Geometry</label>
                        <textarea id="geom_point" name="geom" rows="2"
                            class="bg-slate-200 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5"
                            readonly></textarea>
                    </div>
                    <div>
                        <label for="image_point" class="block mb-2 text-sm font-medium text-slate-700">Photo</label>
                        <input type="file" id="image_point" name="image"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100"
                            onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                        <img src="" alt="Image Preview" id="preview-image-point"
                            class="mt-2 rounded-lg" width="200">
                    </div>
                </div>
                <!-- Footer -->
                <div class="flex items-center justify-end p-4 border-t space-x-2">
                    <button @click="open = false" type="button"
                        class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg">Close</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CREATE POLYLINE (TAILWIND + ALPINE.JS) -->
    <div x-data="{ open: false }" @open-polyline-modal.window="open = true" @close-modal.window="open = false" x-show="open"
        class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="open = false" x-show="open" x-transition
            class="bg-white rounded-xl shadow-xl w-full max-w-2xl">
             <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-xl font-bold text-slate-800">Create Polyline</h3>
                <button @click="open = false" class="text-slate-500 hover:text-slate-800">×</button>
            </div>
            <!-- Body -->
            <form method="POST" action="{{ route('polylines.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-slate-700">Name</label>
                        <input type="text" id="name" name="name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Fill the polyline name" required>
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-slate-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"></textarea>
                    </div>
                    <div>
                        <label for="geom_polyline" class="block mb-2 text-sm font-medium text-slate-700">Geometry</label>
                        <textarea id="geom_polyline" name="geom" rows="2" class="bg-slate-200 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" readonly></textarea>
                    </div>
                    <div>
                        <label for="image_polyline" class="block mb-2 text-sm font-medium text-slate-700">Photo</label>
                        <input type="file" id="image_polyline" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100" onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                        <img src="" alt="Image Preview" id="preview-image-polyline" class="mt-2 rounded-lg" width="200">
                    </div>
                </div>
                <!-- Footer -->
                <div class="flex items-center justify-end p-4 border-t space-x-2">
                    <button @click="open = false" type="button" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg">Close</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CREATE POLYGON (TAILWIND + ALPINE.JS) -->
    <div x-data="{ open: false }" @open-polygon-modal.window="open = true" @close-modal.window="open = false" x-show="open"
        class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="open = false" x-show="open" x-transition
            class="bg-white rounded-xl shadow-xl w-full max-w-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-xl font-bold text-slate-800">Create Polygon</h3>
                <button @click="open = false" class="text-slate-500 hover:text-slate-800">×</button>
            </div>
            <!-- Body -->
            <form method="POST" action="{{ route('polygons.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                     <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-slate-700">Name</label>
                        <input type="text" id="name" name="name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Fill the polygon name" required>
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-slate-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"></textarea>
                    </div>
                    <div>
                        <label for="geom_polygon" class="block mb-2 text-sm font-medium text-slate-700">Geometry</label>
                        <textarea id="geom_polygon" name="geom" rows="2" class="bg-slate-200 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" readonly></textarea>
                    </div>
                    <div>
                        <label for="image_polygon" class="block mb-2 text-sm font-medium text-slate-700">Photo</label>
                        <input type="file" id="image_polygon" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100" onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">
                        <img src="" alt="Image Preview" id="preview-image-polygon" class="mt-2 rounded-lg" width="200">
                    </div>
                </div>
                <!-- Footer -->
                <div class="flex items-center justify-end p-4 border-t space-x-2">
                    <button @click="open = false" type="button" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg">Close</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <script>
        // Set Map
        var map = L.map('map').setView([-7.673, 110.622], 12);

        // Basemap
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        });
        var satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: 'Google Satellite'
        });
        osm.addTo(map);

        /* WMS LAYER FROM GEOSERVER */
        var wmsAdministrasi = L.tileLayer.wms('http://localhost:8080/geoserver/responsi_klaten/wms', {
            layers: 'responsi_klaten:ADMINISTRASIDESA_AR_25K',
            format: 'image/png',
            transparent: true,
            opacity: 0.7,
            attribution: 'Administrasi Desa Klaten'
        }).addTo(map); // Langsung tambahkan ke peta

        var wmsJalan = L.tileLayer.wms('http://localhost:8080/geoserver/responsi_klaten/wms', {
            layers: 'responsi_klaten:JALAN_LN_25K',
            format: 'image/png',
            transparent: true,
            attribution: 'Jalan Klaten'
        }).addTo(map); // Langsung tambahkan ke peta

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            draw: {
                polyline: true, polygon: true, rectangle: true, marker: true,
                circle: false, circlemarker: false
            },
            edit: { featureGroup: drawnItems, remove: true }
        });
        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;
            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            if (type === 'polyline') {
                $('#geom_polyline').val(objectGeometry);
                window.dispatchEvent(new CustomEvent('open-polyline-modal'));
            } else if (type === 'polygon' || type === 'rectangle') {
                $('#geom_polygon').val(objectGeometry);
                window.dispatchEvent(new CustomEvent('open-polygon-modal'));
            } else if (type === 'marker') {
                $('#geom_point').val(objectGeometry);
                window.dispatchEvent(new CustomEvent('open-point-modal'));
            }
            drawnItems.addLayer(layer);
        });

        /* GeoJSON Layers from Database */
        // Point
        var point = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var popupContent = `
                    <div class="p-2">
                        <h3 class="font-bold text-lg mb-2">${feature.properties.name}</h3>
                        ${feature.properties.image ? `<img src="{{ asset('storage/images') }}/${feature.properties.image}" class="w-full h-auto rounded-md mb-2" alt="Feature Image">` : ''}
                        <p class="text-sm text-slate-600 mb-3">${feature.properties.description || 'No description available.'}</p>
                        <div class="flex justify-between items-center border-t pt-2">
                            <a href="/admin/points/${feature.properties.id}/edit" class="inline-flex items-center gap-1 text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form method="POST" action="/admin/points/${feature.properties.id}" onsubmit="return confirm('Are you sure you want to delete this point?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs font-semibold transition-colors">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>`;
                layer.bindPopup(popupContent);
                layer.on('mouseover', function(e) { this.openPopup(); });
                layer.on('mouseout', function(e) { this.closePopup(); });
            },
        });
        $.getJSON("{{ route('api.points') }}", function(data) {
            point.addData(data);
            map.addLayer(point); // Langsung tambahkan ke peta
        });

        // Polyline
        var polyline = L.geoJson(null, {
            style: { color: "#3388ff", weight: 3 },
            onEachFeature: function(feature, layer) {
                var popupContent = `
                    <div class="p-2">
                        <h3 class="font-bold text-lg mb-2">${feature.properties.name}</h3>
                        ${feature.properties.image ? `<img src="{{ asset('storage/images') }}/${feature.properties.image}" class="w-full h-auto rounded-md mb-2" alt="Feature Image">` : ''}
                        <p class="text-sm text-slate-600 mb-2">${feature.properties.description || 'No description available.'}</p>
                        <p class="text-xs text-slate-500 font-mono">Length: ${parseFloat(feature.properties.length_km).toFixed(2)} km</p>
                        <div class="flex justify-between items-center border-t pt-2 mt-2">
                            <a href="/admin/polylines/${feature.properties.id}/edit" class="inline-flex items-center gap-1 text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form method="POST" action="/admin/polylines/${feature.properties.id}" onsubmit="return confirm('Are you sure you want to delete this polyline?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs font-semibold transition-colors">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>`;
                layer.bindPopup(popupContent);
                layer.on('mouseover', function(e) { this.openPopup(); });
                layer.on('mouseout', function(e) { this.closePopup(); });
            },
        });
        $.getJSON("{{ route('api.polylines') }}", function(data) {
            polyline.addData(data);
            map.addLayer(polyline); // Langsung tambahkan ke peta
        });

        // Polygon
        var polygon = L.geoJson(null, {
            style: { color: "#28a745", weight: 2, fillColor: "#28a745", fillOpacity: 0.3 },
            onEachFeature: function(feature, layer) {
                var popupContent = `
                    <div class="p-2">
                        <h3 class="font-bold text-lg mb-2">${feature.properties.name}</h3>
                        ${feature.properties.image ? `<img src="{{ asset('storage/images') }}/${feature.properties.image}" class="w-full h-auto rounded-md mb-2" alt="Feature Image">` : ''}
                        <p class="text-sm text-slate-600 mb-2">${feature.properties.description || 'No description available.'}</p>
                        <p class="text-xs text-slate-500 font-mono">Area: ${parseFloat(feature.properties.area_hektar).toFixed(2)} Ha</p>
                         <div class="flex justify-between items-center border-t pt-2 mt-2">
                            <a href="/admin/polygons/${feature.properties.id}/edit" class="inline-flex items-center gap-1 text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form method="POST" action="/admin/polygons/${feature.properties.id}" onsubmit="return confirm('Are you sure you want to delete this polygon?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs font-semibold transition-colors">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>`;
                layer.bindPopup(popupContent);
                layer.on('mouseover', function(e) { this.openPopup(); });
                layer.on('mouseout', function(e) { this.closePopup(); });
            },
        });
        $.getJSON("{{ route('api.polygons') }}", function(data) {
            polygon.addData(data);
            map.addLayer(polygon); // Langsung tambahkan ke peta
        });

        /* Layer Control */
        var baseMaps = {
            "OpenStreetMap": osm,
            "Google Satellite": satellite
        };
        var overlayMaps = {
            "<span class='text-black-600'>Administrasi Desa (WMS)</span>": wmsAdministrasi,
            "<span class='text-black-600'>Jalan (WMS)</span>": wmsJalan,
            "<i class='fa-solid fa-map-pin mr-2 text-blue-500'></i> Titik (Database)": point,
            "<i class='fa-solid fa-road mr-2 text-indigo-500'></i> Garis (Database)": polyline,
            "<i class='fa-solid fa-draw-polygon mr-2 text-green-500'></i> Area (Database)": polygon,
            "<i class='fa-solid fa-pencil mr-2 text-orange-500'></i> Data Digitasiku": drawnItems
        };
        L.control.layers(baseMaps, overlayMaps, {
            collapsed: false,
            position: 'topright'
        }).addTo(map);

    </script>
@endsection
