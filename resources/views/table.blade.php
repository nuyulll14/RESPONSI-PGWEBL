@extends('layouts.template')

@section('title', 'Tabel Data Kesehatan')

@section('styles')
    {{-- Styling kustom untuk paginasi Laravel agar sesuai tema --}}
    <style>
        .pagination {
            @apply flex justify-center;
        }
        .pagination .page-item .page-link {
            @apply first:rounded-l-lg last:rounded-r-lg relative inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 bg-white ring-1 ring-inset ring-slate-300 hover:bg-cyan-50 focus:z-20 focus:outline-offset-0 transition-colors;
        }
        .pagination .page-item.active .page-link {
            @apply z-10 bg-cyan-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600 hover:bg-cyan-600;
        }
        .pagination .page-item.disabled .page-link {
            @apply text-slate-400 bg-slate-50 cursor-default;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

    <!-- TABEL DATA POINTS -->
    <div id="points-container" class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-map-pin text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Data Points</h2>
                <p class="text-sm text-slate-500">Kumpulan data titik fasilitas kesehatan.</p>
            </div>
        </div>
        <div class="p-4 sm:p-6 space-y-4">
            <!-- Search Input -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" id="pointsSearch" onkeyup="searchTable('pointsSearch', 'pointsTable')" placeholder="Cari data titik..." class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full md:w-80 p-2.5 pl-10">
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="pointsTable" class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-xs text-slate-600 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Created At</th>
                            <th scope="col" class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($points as $p)
                        <tr class="bg-white hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-mono text-slate-500">{{ $p->id }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $p->name }}</td>
                            <td class="px-6 py-4">
                                @if($p->image)
                                    <img src="{{ asset('storage/images/' . $p->image) }}" alt="Image" class="h-12 w-16 object-cover rounded-md shadow-sm border border-slate-200">
                                @else
                                    <span class="text-xs text-slate-400 italic">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $p->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('points.edit', $p->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-md hover:bg-yellow-200 transition-colors" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i><span>Edit</span>
                                    </a>
                                    <form action="{{ route('points.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-800 bg-red-100 rounded-md hover:bg-red-200 transition-colors" title="Delete">
                                            <i class="fa-solid fa-trash"></i><span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-500">
                                <i class="fa-solid fa-circle-xmark text-2xl mb-2"></i>
                                <p>Tidak ada data ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if ($points->hasPages())
                <div class="pt-4">
                    {{ $points->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Anda bisa duplikasi struktur di atas untuk Polylines dan Polygons --}}
    {{-- Contoh untuk Polylines --}}
    <div id="polylines-container" class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-road text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Data Polylines</h2>
                <p class="text-sm text-slate-500">Kumpulan data garis seperti jalan atau sungai.</p>
            </div>
        </div>
        <div class="p-4 sm:p-6 space-y-4">
             <!-- Search Input -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" id="polylinesSearch" onkeyup="searchTable('polylinesSearch', 'polylinesTable')" placeholder="Cari data garis..." class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full md:w-80 p-2.5 pl-10">
            </div>

             <!-- Table -->
            <div class="overflow-x-auto">
                <table id="polylinesTable" class="w-full text-sm text-left">
                    {{-- Thead, Tbody, Tfoot ... sama seperti tabel Points --}}
                    <thead class="bg-slate-50 text-xs text-slate-600 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Created At</th>
                            <th scope="col" class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($polylines as $pl)
                        <tr class="bg-white hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-mono text-slate-500">{{ $pl->id }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $pl->name }}</td>
                            <td class="px-6 py-4">
                                @if($pl->image)
                                    <img src="{{ asset('storage/images/' . $pl->image) }}" alt="Image" class="h-12 w-16 object-cover rounded-md shadow-sm border border-slate-200">
                                @else
                                    <span class="text-xs text-slate-400 italic">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $pl->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('polylines.edit', $pl->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-md hover:bg-yellow-200 transition-colors" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i><span>Edit</span>
                                    </a>
                                    <form action="{{ route('polylines.destroy', $pl->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-800 bg-red-100 rounded-md hover:bg-red-200 transition-colors" title="Delete">
                                            <i class="fa-solid fa-trash"></i><span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                             <td colspan="5" class="text-center py-10 text-slate-500">
                                <i class="fa-solid fa-circle-xmark text-2xl mb-2"></i>
                                <p>Tidak ada data ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
             @if ($polylines->hasPages())
                <div class="pt-4">
                    {{ $polylines->links() }}
                </div>
            @endif
        </div>
    </div>

     {{-- Contoh untuk Polygons --}}
    <div id="polygons-container" class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-draw-polygon text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Data Polygons</h2>
                <p class="text-sm text-slate-500">Kumpulan data area seperti batas administrasi atau zona.</p>
            </div>
        </div>
        <div class="p-4 sm:p-6 space-y-4">
             <!-- Search Input -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" id="polygonsSearch" onkeyup="searchTable('polygonsSearch', 'polygonsTable')" placeholder="Cari data area..." class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full md:w-80 p-2.5 pl-10">
            </div>

             <!-- Table -->
            <div class="overflow-x-auto">
                <table id="polygonsTable" class="w-full text-sm text-left">
                    {{-- Thead, Tbody, Tfoot ... sama seperti tabel Points --}}
                     <thead class="bg-slate-50 text-xs text-slate-600 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Created At</th>
                            <th scope="col" class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($polygons as $pg)
                        <tr class="bg-white hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-mono text-slate-500">{{ $pg->id }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $pg->name }}</td>
                            <td class="px-6 py-4">
                                @if($pg->image)
                                    <img src="{{ asset('storage/images/' . $pg->image) }}" alt="Image" class="h-12 w-16 object-cover rounded-md shadow-sm border border-slate-200">
                                @else
                                    <span class="text-xs text-slate-400 italic">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $pg->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('polygons.edit', $pg->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-md hover:bg-yellow-200 transition-colors" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i><span>Edit</span>
                                    </a>
                                    <form action="{{ route('polygons.destroy', $pg->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-800 bg-red-100 rounded-md hover:bg-red-200 transition-colors" title="Delete">
                                            <i class="fa-solid fa-trash"></i><span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                         @empty
                        <tr>
                             <td colspan="5" class="text-center py-10 text-slate-500">
                                <i class="fa-solid fa-circle-xmark text-2xl mb-2"></i>
                                <p>Tidak ada data ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if ($polygons->hasPages())
                <div class="pt-4">
                    {{ $polygons->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function searchTable(inputId, tableId) {
        // Deklarasi variabel
        let input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        // Loop melalui semua baris tabel, dan sembunyikan yang tidak cocok dengan pencarian
        for (i = 0; i < tr.length; i++) {
            // Kita akan cari di semua sel (td) pada baris tersebut
            let found = false;
            td = tr[i].getElementsByTagName("td");
            if (td.length > 0) { // Pastikan ini adalah baris data, bukan header
                 for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break; // Hentikan pencarian jika sudah ditemukan di salah satu sel
                        }
                    }
                }
                if(found){
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection
