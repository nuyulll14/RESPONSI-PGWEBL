@extends('layouts.template')

@section('title', 'KARTEN – Kawan Sehat untuk Klaten Tangguh')

@section('content')
    <div class="font-sans antialiased text-slate-800 bg-slate-50">

        <!-- Hero Section -->
        <div class="w-full bg-white">
            <div
                class="container mx-auto px-6 lg:px-8 py-20 md:py-24 flex flex-col md:flex-row items-center justify-between gap-12">

                <!-- Kolom Teks -->
                <div class="md:w-1/2 text-center md:text-left">
                    <span class="text-cyan-600 font-semibold uppercase tracking-wider">Selamat Datang di KARTEN</span>
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-slate-900 mt-2 mb-4 leading-tight">
                        Kawan Sehat untuk <span class="text-cyan-600">Klaten Tangguh</span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 max-w-xl mx-auto md:mx-0">
                        Platform informasi dan pemetaan kesehatan terintegrasi untuk seluruh masyarakat Kabupaten Klaten.
                        Temukan layanan, data, dan komunitas di satu tempat.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-md mx-auto md:mx-0 md:max-w-lg">
                        <a href="/map"
                            class="inline-flex items-center justify-center gap-2 bg-cyan-600 text-white px-6 py-3 rounded-full font-semibold shadow-lg hover:bg-cyan-700 transition-all duration-300 transform hover:scale-105 text-center">
                            <span>Lihat Peta Kesehatan</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="/table"
                            class="inline-flex items-center justify-center gap-2 bg-slate-200 text-slate-800 px-6 py-3 rounded-full font-semibold hover:bg-slate-300 transition-colors duration-300 text-center">
                            <span>Lihat Data Tabel</span>
                        </a>
                    </div>
                </div>

                <!-- Kolom Gambar/Ilustrasi -->
                <div class="md:w-1/2">
                    <img src="{{ asset('images/ilustrasi-tim-kesehatan.svg') }}" alt="Ilustrasi Tim Kesehatan KARTEN"
                        class="w-full h-auto">
                </div>

            </div>
        </div>

        <!-- Seksi Statistik Kunci -->
        <div class="bg-slate-100">
            <div class="container mx-auto px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <i class="fa-solid fa-hospital-user text-4xl text-cyan-500 mb-3"></i>
                        <p class="text-4xl font-bold text-slate-800">120+</p>
                        <p class="text-slate-500">Fasilitas Kesehatan Terdata</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <i class="fa-solid fa-map-location-dot text-4xl text-cyan-500 mb-3"></i>
                        <p class="text-4xl font-bold text-slate-800">401</p>
                        <p class="text-slate-500">Desa/Kelurahan Terpetakan</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <i class="fa-solid fa-users text-4xl text-cyan-500 mb-3"></i>
                        <p class="text-4xl font-bold text-slate-800">1,500+</p>
                        <p class="text-slate-500">Kader Kesehatan Terlibat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fitur Unggulan Section -->
        <div class="min-h-screen bg-white flex items-center">
            <div class="container mx-auto px-6 lg:px-8 py-16 md:py-0">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-slate-900">Platform Kesehatan Terlengkap</h2>
                    <p class="mt-3 text-slate-600 max-w-2xl mx-auto">Kami menyediakan alat dan informasi yang Anda butuhkan
                        untuk membuat keputusan kesehatan yang lebih baik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Kartu Fitur 1 -->
                    <div
                        class="bg-slate-50/50 p-6 rounded-xl border border-slate-200 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-clinic-medical text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-slate-800 mb-2">Direktori Faskes</h3>
                        <p class="text-slate-500 text-sm">Temukan puskesmas, klinik, apotek, dan praktik dokter terdekat
                            dengan informasi lengkap dan lokasi akurat.</p>
                    </div>

                    <!-- Kartu Fitur 2 -->
                    <div
                        class="bg-slate-50/50 p-6 rounded-xl border border-slate-200 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-chart-pie text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-slate-800 mb-2">Dasbor Data</h3>
                        <p class="text-slate-500 text-sm">Akses data kesehatan publik, tren penyakit, dan cakupan program
                            vaksinasi yang divisualisasikan secara geografis.</p>
                    </div>

                    <!-- Kartu Fitur 3 -->
                    <div
                        class="bg-slate-50/50 p-6 rounded-xl border border-slate-200 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-people-group text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-slate-800 mb-2">Pusat Kolaborasi</h3>
                        <p class="text-slate-500 text-sm">Menjadi jembatan digital bagi warga, kader posyandu, dan tenaga
                            medis untuk berkoordinasi dan berbagi informasi.</p>
                    </div>

                    <!-- Kartu Fitur 4 -->
                    <div
                        class="bg-slate-50/50 p-6 rounded-xl border border-slate-200 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-map text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-xl text-slate-800 mb-2">Peta WebGIS Interaktif</h3>
                        <p class="text-slate-500 text-sm">Visualisasikan sebaran fasilitas, zona risiko penyakit, dan data
                            demografis langsung di atas peta Klaten.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seksi Panggilan untuk Aksi (CTA) -->
        <div class="bg-gradient-to-r from-cyan-600 to-teal-500">
            <div class="container mx-auto px-6 lg:px-8 py-20 text-center text-white">
                <h2 class="text-3xl font-bold mb-3">Siap Berkontribusi untuk Klaten Sehat?</h2>
                <p class="max-w-2xl mx-auto mb-8 opacity-90">
                    Baik Anda warga, kader kesehatan, atau tenaga medis, peran Anda sangat berarti. Mari bergabung dan
                    menjadi bagian dari perubahan.
                </p>
                <a href="{{ route('register') }}"
                    class="inline-block bg-white text-cyan-600 px-10 py-4 rounded-full font-bold shadow-2xl hover:bg-slate-100 transition-all duration-300 transform hover:scale-105">
                    Daftar & Mulai Berkontribusi
                </a>
            </div>
        </div>

    </div>
@endsection
