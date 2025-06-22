@extends('layout.template')

@section('title', 'KARTEN – Kawan Sehat Klaten')

@section('content')
<div class="font-sans antialiased text-slate-800 bg-slate-50">

    <!-- Hero Section -->
    <div class="w-full min-h-screen flex items-center bg-white">
        <div class="container mx-auto px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-12">

            <!-- Kolom Teks -->
            <div class="md:w-1/2 text-center md:text-left">
                <span class="text-cyan-600 font-semibold uppercase tracking-wider">Selamat Datang di KARTEN</span>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-slate-800 mt-2 mb-4 leading-tight">
                    Kawan Sehat untuk Klaten Tangguh
                </h1>
                <p class="text-lg text-slate-600 mb-8">
                    Sebuah gerakan kolaboratif untuk mewujudkan masyarakat Klaten yang sehat, aktif, dan terinformasi. Mari jaga masa depan, mulai dari sekarang.
                </p>
                <a href="/map" class="inline-flex items-center gap-2 bg-cyan-600 text-white px-8 py-4 rounded-full font-semibold shadow-lg hover:bg-cyan-700 transition-all duration-300 transform hover:scale-105">
                    <span>Lihat Peta Kesehatan</span>
                    <!-- Icon panah -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <!-- Kolom Gambar/Ilustrasi -->
            <div class="md:w-1/2">
                <!-- Ganti 'src' dengan link ke ilustrasi Anda sendiri -->
                <!-- Anda bisa mencari ilustrasi gratis bertema kesehatan/komunitas di situs seperti undraw.co atau storyset.com -->
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/medical-team-5338573-4467554.png" alt="Ilustrasi Tim Kesehatan KARTEN" class="w-full h-auto">
            </div>

        </div>
    </div>

    <!-- Fitur Unggulan Section -->
    <div class="py-20">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800">Kenapa KARTEN Penting?</h2>
                <p class="mt-2 text-slate-600 max-w-2xl mx-auto">Kami menyediakan platform terintegrasi untuk semua kebutuhan informasi kesehatan Anda di Klaten.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Kartu Fitur 1 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-2">Layanan Kesehatan</h3>
                    <p class="text-slate-500 text-sm">Informasi lengkap puskesmas, klinik, dan layanan kesehatan lainnya di seluruh wilayah Klaten.</p>
                </div>

                <!-- Kartu Fitur 2 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-2">Data Kesehatan</h3>
                    <p class="text-slate-500 text-sm">Visualisasi data kesehatan, tren penyakit, dan cakupan program vaksinasi secara geografis.</p>
                </div>

                <!-- Kartu Fitur 3 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-2">Komunitas Sehat</h3>
                    <p class="text-slate-500 text-sm">Menjadi jembatan kolaborasi antar warga, kader, dan tenaga medis untuk aksi nyata di lapangan.</p>
                </div>

                <!-- Kartu Fitur 4 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                     <div class="bg-cyan-100 text-cyan-600 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-2">Peta WebGIS Kesehatan</h3>
                    <p class="text-slate-500 text-sm">Temukan lokasi faskes terdekat, program imunisasi, dan pemetaan zona risiko dengan mudah.</p>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
