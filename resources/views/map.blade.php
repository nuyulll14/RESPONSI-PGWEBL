@extends('layouts/template')

@section('title', 'Peta Sebaran Kesehatan Klaten')

@section('styles')
    {{-- Leaflet & Leaflet Draw --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    {{-- Styling Kustom untuk Leaflet & Fitur Baru --}}
    <style>
        #map { width: 100%; height: calc(100vh - 64px); z-index: 10; }
        .leaflet-control-layers { @apply bg-white/80 backdrop-blur-sm rounded-lg shadow-lg p-4 border border-slate-200; }
        .leaflet-control-layers-base label, .leaflet-control-layers-overlays label { @apply font-medium text-slate-700; }
        .leaflet-popup-content-wrapper { @apply bg-white rounded-xl shadow-xl border-none; }
        .leaflet-popup-content { @apply text-slate-700; }
        .leaflet-popup-tip { @apply bg-white; }
        .leaflet-draw-toolbar { @apply bg-white/80 backdrop-blur-sm rounded-lg shadow-lg border border-slate-200; }
        .leaflet-draw-toolbar a { @apply bg-transparent text-slate-800 hover:bg-cyan-100; }
    </style>
@endsection

@section('content')
    <div id="map"></div>

    <!-- MODAL CREATE POINT (TAILWIND + ALPINE.JS) -->
    <div x-data="{ open: false, name: '', geom: '' }"
        @open-point-modal.window="
            open = true;
            name = event.detail.name || '';
            geom = event.detail.geom || '';
            document.getElementById('form-point').reset();
            document.getElementById('preview-image-point').src = '';
        "
        @close-modal.window="open = false" x-show="open"
        class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="open = false" x-show="open" x-transition class="bg-white rounded-xl shadow-xl w-full max-w-2xl">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-xl font-bold text-slate-800">Create Point</h3>
                <button @click="open = false" class="text-slate-500 hover:text-slate-800">×</button>
            </div>
            <form id="form-point" method="POST" action="{{ route('points.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="point-name" class="block mb-2 text-sm font-medium text-slate-700">Name</label>
                        <input type="text" id="point-name" name="name" x-model="name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Fill the point name" required>
                    </div>
                    <div>
                        <label for="point-description" class="block mb-2 text-sm font-medium text-slate-700">Description</label>
                        <textarea id="point-description" name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"></textarea>
                    </div>
                    <div>
                        <label for="point-geom" class="block mb-2 text-sm font-medium text-slate-700">Geometry</label>
                        <!-- PERUBAHAN DI SINI: Mengubah name="geom" menjadi "geom_point" agar sesuai dengan validasi di Controller -->
                        <textarea id="point-geom" name="geom_point" rows="2" x-model="geom" class="bg-slate-200 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" readonly></textarea>
                    </div>
                    <div>
                        <label for="image_point" class="block mb-2 text-sm font-medium text-slate-700">Photo</label>
                        <input type="file" id="image_point" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100" onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                        <img src="" alt="Image Preview" id="preview-image-point" class="mt-2 rounded-lg" width="200">
                    </div>
                </div>
                <div class="flex items-center justify-end p-4 border-t space-x-2">
                    <button @click="open = false" type="button" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg">Close</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL CREATE POLYLINE --}}
    <div x-data="{ open: false, geom: '' }" @open-polyline-modal.window="open = true; geom = event.detail.geom" x-show="open" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="open = false" x-show="open" x-transition class="bg-white rounded-xl shadow-xl w-full max-w-2xl">
            <div class="flex items-center justify-between p-4 border-b"><h3 class="text-xl font-bold text-slate-800">Create Polyline</h3><button @click="open = false" class="text-slate-500 hover:text-slate-800">×</button></div>
            <form method="POST" action="{{ route('polylines.store') }}" enctype="multipart/form-data">
                <div class="p-6 space-y-4">
                    @csrf
                    <input type="text" name="name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Fill the polyline name" required>
                    <textarea name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Description"></textarea>
                    <!-- PERUBAHAN DI SINI: Mengubah name="geom" menjadi "geom_polyline" (Asumsi nama field di backend) -->
                    <textarea name="geom_polyline" rows="2" x-model="geom" class="bg-slate-200 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" readonly></textarea>
                    <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                </div>
                <div class="flex items-center justify-end p-4 border-t space-x-2">
                    <button @click="open = false" type="button" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg">Close</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL CREATE POLYGON --}}
    <div x-data="{ open: false, geom: '' }" @open-polygon-modal.window="open = true; geom = event.detail.geom" x-show="open" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.away="open = false" x-show="open" x-transition class="bg-white rounded-xl shadow-xl w-full max-w-2xl">
            <div class="flex items-center justify-between p-4 border-b"><h3 class="text-xl font-bold text-slate-800">Create Polygon</h3><button @click="open = false" class="text-slate-500 hover:text-slate-800">×</button></div>
            <form method="POST" action="{{ route('polygons.store') }}" enctype="multipart/form-data">
                <div class="p-6 space-y-4">
                    @csrf
                    <input type="text" name="name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Fill the polygon name" required>
                    <textarea name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Description"></textarea>
                    <!-- PERUBAHAN DI SINI: Mengubah name="geom" menjadi "geom_polygon" (Asumsi nama field di backend) -->
                    <textarea name="geom_polygon" rows="2" x-model="geom" class="bg-slate-200 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" readonly></textarea>
                    <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                </div>
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
        $(document).ready(function() {
            var map = L.map('map').setView([-7.673, 110.622], 12);
            var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);
            var satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], attribution: 'Google Satellite' });
            var wmsAdministrasi = L.tileLayer.wms('http://localhost:8080/geoserver/responsi_klaten/wms', { layers: 'responsi_klaten:ADMINISTRASIDESA_AR_25K', format: 'image/png', transparent: true, opacity: 0.7, attribution: 'Administrasi Desa Klaten' }).addTo(map);
            var wmsJalan = L.tileLayer.wms('http://localhost:8080/geoserver/responsi_klaten/wms', { layers: 'responsi_klaten:JALAN_LN_25K', format: 'image/png', transparent: true, attribution: 'Jalan Klaten' }).addTo(map);

            var drawnItems = new L.FeatureGroup().addTo(map);
            var drawControl = new L.Control.Draw({ edit: { featureGroup: drawnItems } }).addTo(map);

            map.on(L.Draw.Event.CREATED, function (e) {
                var layer = e.layer;
                var drawnJSONObject = layer.toGeoJSON();
                var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);
                let detail = { geom: objectGeometry };

                if (e.layerType === 'marker') window.dispatchEvent(new CustomEvent('open-point-modal', { detail }));
                else if (e.layerType === 'polyline') window.dispatchEvent(new CustomEvent('open-polyline-modal', { detail }));
                else if (e.layerType === 'polygon' || e.layerType === 'rectangle') window.dispatchEvent(new CustomEvent('open-polygon-modal', { detail }));

                drawnItems.addLayer(layer);
            });

            var searchResultLayer = L.featureGroup().addTo(map);
            var searchMarkerIcon = L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });

            var debounceTimer;
            $('#globalSearchInput').on('keyup', function() { clearTimeout(debounceTimer); debounceTimer = setTimeout(performSearch, 500); });
            $('#globalSearchForm').on('submit', function(e) { e.preventDefault(); performSearch(); });

            function performSearch() {
                var query = $('#globalSearchInput').val();
                var resultsContainer = $('#globalSearchResults');
                if (query.length < 3) { resultsContainer.html('<div class="p-4 text-center text-sm text-slate-400">Ketik minimal 3 huruf.</div>'); return; }
                resultsContainer.html('<div class="p-4 text-center text-sm text-slate-500"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Mencari...</div>');

                fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&countrycodes=id&limit=10`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.empty();
                        searchResultLayer.clearLayers();
                        if (data && data.length > 0) {
                            data.forEach(item => {
                                var marker = L.marker([item.lat, item.lon], { icon: searchMarkerIcon }).addTo(searchResultLayer);
                                var popupContent = `<div class="p-1 w-60"><p class="font-bold text-base mb-1">${item.display_name.split(',')[0]}</p><p class="text-xs text-slate-500 mb-3 leading-tight">${item.display_name.substring(item.display_name.indexOf(',') + 1).trim()}</p><button class="w-full text-white bg-cyan-600 hover:bg-cyan-700 font-medium rounded-lg text-sm px-4 py-2 text-center" onclick="saveSearchResult('${item.display_name.replace(/'/g, "\\'")}', ${item.lat}, ${item.lon})"><i class="fa-solid fa-plus mr-1"></i> Tambah Lokasi Ini</button></div>`;
                                marker.bindPopup(popupContent);
                                const resultHtml = `<div class="flex items-start gap-3 p-3 cursor-pointer hover:bg-cyan-50 border-b border-slate-100"><div class="pt-1 text-cyan-600"><i class="fa-solid fa-location-dot"></i></div><div><p class="font-semibold text-slate-800">${item.display_name.split(',')[0]}</p><p class="text-xs text-slate-500">${item.display_name.substring(item.display_name.indexOf(',') + 1).trim()}</p></div></div>`;
                                $(resultHtml).on('click', function() {
                                    map.flyTo([item.lat, item.lon], 17);
                                    marker.openPopup();
                                    var searchContainer = document.querySelector('#globalSearchForm').closest('[x-data]');
                                    if(searchContainer) searchContainer.__x.getUnwrappedData('searchOpen').searchOpen = false;
                                }).appendTo(resultsContainer);
                            });
                        } else {
                            resultsContainer.html('<div class="p-4 text-center text-sm text-slate-500"><i class="fa-solid fa-circle-xmark mr-2"></i>Tidak ada hasil ditemukan.</div>');
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        resultsContainer.html('<div class="p-4 text-center text-sm text-red-500"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Gagal melakukan pencarian.</div>');
                    });
            }
            window.saveSearchResult = function(name, lat, lon) {
                var wktGeom = `POINT(${lon} ${lat})`;
                window.dispatchEvent(new CustomEvent('open-point-modal', { detail: { name: name, geom: wktGeom } }));
            }

            function createPopupForFeature(baseUrl) {
                return function(feature, layer) {
                    var props = feature.properties;
                    var popupContent = `<div class="p-2 w-64"><h3 class="font-bold text-lg mb-2">${props.name}</h3>${props.image ? `<img src="{{ asset('storage/images') }}/${props.image}" class="w-full h-auto rounded-md mb-2" alt="Feature Image">` : ''}<p class="text-sm text-slate-600 mb-3">${props.description || 'No description.'}</p><div class="flex justify-between items-center border-t pt-2"><a href="${baseUrl}/${props.id}/edit" class="inline-flex items-center gap-1 text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs font-semibold transition-colors"><i class="fa-solid fa-pen-to-square"></i> Edit</a><form method="POST" action="${baseUrl}/${props.id}" onsubmit="return confirm('Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center gap-1 text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs font-semibold transition-colors"><i class="fa-solid fa-trash"></i> Hapus</button></form></div></div>`;
                    layer.bindPopup(popupContent);
                };
            }
            var pointsLayer = L.geoJson(null, { onEachFeature: createPopupForFeature('/points') });
            var polylinesLayer = L.geoJson(null, { style: { color: "#3388ff", weight: 3 }, onEachFeature: createPopupForFeature('/polylines') });
            var polygonsLayer = L.geoJson(null, { style: { color: "#28a745", weight: 2, fillColor: "#28a745", fillOpacity: 0.3 }, onEachFeature: createPopupForFeature('/polygons') });

            $.getJSON("{{ route('api.points') }}", function(data) { pointsLayer.addData(data).addTo(map); });
            $.getJSON("{{ route('api.polylines') }}", function(data) { polylinesLayer.addData(data).addTo(map); });
            $.getJSON("{{ route('api.polygons') }}", function(data) { polygonsLayer.addData(data).addTo(map); });

            L.control.layers({ "OpenStreetMap": osm, "Google Satellite": satellite }, {
                "Administrasi Desa (WMS)": wmsAdministrasi, "Jalan (WMS)": wmsJalan,
                "<i class='fa-solid fa-map-pin mr-2 text-blue-500'></i> Titik Tersimpan": pointsLayer,
                "<i class='fa-solid fa-road mr-2 text-indigo-500'></i> Garis Tersimpan": polylinesLayer,
                "<i class='fa-solid fa-draw-polygon mr-2 text-green-500'></i> Area Tersimpan": polygonsLayer,
                "<i class='fa-solid fa-pencil mr-2 text-orange-500'></i> Data Digitasiku": drawnItems,
                "<i class='fa-solid fa-magnifying-glass-location mr-2 text-emerald-500'></i> Hasil Pencarian": searchResultLayer
            }, { collapsed: false, position: 'topright' }).addTo(map);
        });
    </script>
@endsection
