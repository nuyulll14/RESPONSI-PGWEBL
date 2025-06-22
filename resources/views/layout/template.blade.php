<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Menggunakan @yield untuk judul yang dinamis, dengan judul default 'KARTEN' --}}
    <title>@yield('title', 'KARTEN')</title>

    {{-- Memuat Font Poppins untuk desain modern --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Memuat Font Awesome (ini bisa berdampingan dengan Tailwind) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{--
        BAGIAN PALING PENTING:
        Menghapus link Bootstrap CDN dan menggantinya dengan direktif Vite.
        Vite akan secara otomatis memuat file CSS (termasuk Tailwind) dan JS yang sudah dikompilasi.
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tetap sediakan @yield('styles') untuk CSS spesifik per halaman (seperti Leaflet) --}}
    @yield('styles')
</head>

{{-- Menambahkan class dasar dari Tailwind ke body untuk default styling --}}
<body class="font-sans antialiased bg-slate-50 text-slate-800">

    {{-- Navbar Anda akan tetap berfungsi --}}
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    {{--
        Menghapus script Bootstrap CDN. Jika ada komponen JS dari Bootstrap yang
        Anda gunakan, perlu diganti dengan alternatif (misal: Alpine.js) atau
        diinstal via NPM. Untuk saat ini, kita hapus agar tidak konflik.
    --}}

    {{-- Tetap sediakan @yield('scripts') untuk JS spesifik per halaman (seperti Leaflet) --}}
    @yield('scripts')

    {{-- Toast/notifikasi Anda akan tetap berfungsi --}}
    @include('components.toast')
</body>

</html>
