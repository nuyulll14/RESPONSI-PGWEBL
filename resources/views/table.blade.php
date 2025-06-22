@extends('layout.template')

@section('title', 'Tabel Data Kesehatan')

@section('styles')
    {{-- Memuat CSS default DataTables, yang akan kita override --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">

    {{-- CSS Kustom untuk Integrasi Penuh DataTables & Tailwind --}}
    <style>
        /* Container utama DataTables */
        .dt-container {
            @apply font-sans;
        }

        /* Wrapper baris atas (search & length) dan bawah (info & paging) */
        .dt-layout-row {
            @apply flex justify-between items-center py-2;
        }

        /* Styling dropdown "Show entries" */
        .dt-length {
            @apply flex items-center gap-2;
        }
        .dt-length select {
            @apply bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2 pr-8;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
        .dt-length label {
             @apply text-sm text-slate-600;
        }

        /* Styling input pencarian (dibuat lebih spesifik) */
        .dt-search input {
            @apply bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2 w-64;
            /* Padding kiri akan ditambahkan oleh JS untuk ikon */
        }
        .dt-search label {
            display: none; /* Sembunyikan label "Search:" default */
        }

        /* Styling tombol paginasi */
        .dt-paging-button {
            @apply !bg-white !border-slate-300 !text-slate-600 hover:!bg-cyan-50 transition-colors duration-200;
        }
        .dt-paging-button.current, .dt-paging-button.current:hover {
            @apply !bg-cyan-600 !border-cyan-600 !text-white;
        }
        .dt-paging-button.disabled {
            @apply !opacity-50 !cursor-default;
        }

        /* Info "Showing 1 to X of Y entries" */
        .dt-info {
            @apply text-sm text-slate-500;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

    <!-- TABEL DATA POINTS -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-map-pin text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Data Points</h2>
                <p class="text-sm text-slate-500">Kumpulan data titik fasilitas kesehatan.</p>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <table id="pointsTable" class="display w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($points as $p)
                    <tr class="hover:bg-cyan-50/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-slate-500">{{ $p->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-800">{{ $p->name }}</td>
                        <td class="px-6 py-4">
                            @if($p->image)
                                <img src="{{ asset('storage/images/' . $p->image) }}" alt="Image for {{ $p->name }}" class="h-14 w-20 object-cover rounded-md shadow-sm border border-slate-200">
                            @else
                                <span class="text-xs text-slate-400 italic">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('points.edit', $p->id) }}" class="p-2 rounded-full text-yellow-600 bg-yellow-100 hover:bg-yellow-200 transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('points.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full text-red-600 bg-red-100 hover:bg-red-200 transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABEL DATA POLYLINES -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-road text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Data Polylines</h2>
                <p class="text-sm text-slate-500">Kumpulan data garis seperti jalan atau sungai.</p>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <table id="polylinesTable" class="display w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($polylines as $p)
                    <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-slate-500">{{ $p->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-800">{{ $p->name }}</td>
                        <td class="px-6 py-4">
                            @if($p->image)
                                <img src="{{ asset('storage/images/' . $p->image) }}" alt="Image for {{ $p->name }}" class="h-14 w-20 object-cover rounded-md shadow-sm border border-slate-200">
                            @else
                                <span class="text-xs text-slate-400 italic">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('polylines.edit', $p->id) }}" class="p-2 rounded-full text-yellow-600 bg-yellow-100 hover:bg-yellow-200 transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('polylines.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full text-red-600 bg-red-100 hover:bg-red-200 transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABEL DATA POLYGONS -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-draw-polygon text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Data Polygons</h2>
                <p class="text-sm text-slate-500">Kumpulan data area seperti batas administrasi atau zona.</p>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <table id="polygonsTable" class="display w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($polygons as $p)
                    <tr class="hover:bg-emerald-50/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-slate-500">{{ $p->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-800">{{ $p->name }}</td>
                        <td class="px-6 py-4">
                             @if($p->image)
                                <img src="{{ asset('storage/images/' . $p->image) }}" alt="Image for {{ $p->name }}" class="h-14 w-20 object-cover rounded-md shadow-sm border border-slate-200">
                            @else
                                <span class="text-xs text-slate-400 italic">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('polygons.edit', $p->id) }}" class="p-2 rounded-full text-yellow-600 bg-yellow-100 hover:bg-yellow-200 transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('polygons.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full text-red-600 bg-red-100 hover:bg-red-200 transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Memuat jQuery dan DataTables JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Opsi language untuk mengganti label default dan menambahkan placeholder
        const dataTableOptions = {
            language: {
                search: "", // Kosongkan label default
                searchPlaceholder: "Search records..." // Tambahkan placeholder
            }
        };

        // Inisialisasi setiap tabel dengan DataTables
        $('#pointsTable').DataTable(dataTableOptions);
        $('#polylinesTable').DataTable(dataTableOptions);
        $('#polygonsTable').DataTable(dataTableOptions);

        // --- SCRIPT UNTUK MENAMBAHKAN IKON SEARCH SECARA DINAMIS ---
        // Ini adalah cara yang paling andal untuk memastikan ikon selalu muncul.
        $('.dt-search input').each(function() {
            // Bungkus input dalam div relative
            $(this).wrap('<div class="relative"></div>');
            // Tambahkan ikon di dalam wrapper, sebelum input
            $(this).before('<span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none"><i class="fa-solid fa-magnifying-glass"></i></span>');
            // Tambahkan padding kiri ke input agar teks tidak tumpang tindih dengan ikon
            $(this).addClass('pl-10');
        });
    });
</script>
@endsection
