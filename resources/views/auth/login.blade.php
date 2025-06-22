<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'KARTEN') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">

<div class="min-h-screen flex items-center justify-center bg-slate-100 p-4">
    <div class="w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl md:grid md:grid-cols-2 overflow-hidden">

        <!-- Kolom Kiri: Branding & Welcome -->
        <div class="hidden md:flex flex-col justify-center items-center p-12 bg-gradient-to-br from-cyan-500 to-teal-600 text-white text-center">
            <i class="fa-solid fa-heart-pulse text-6xl mb-4"></i>
            <h1 class="text-4xl font-extrabold tracking-tight">KARTEN</h1>
            <p class="mt-2 text-cyan-100">Kawan Sehat untuk Klaten Tangguh.</p>
            <p class="mt-8 text-sm text-cyan-200 border-t border-cyan-400/50 pt-4">
                Platform terintegrasi untuk informasi dan layanan kesehatan masyarakat Klaten.
            </p>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="p-8 md:p-12">
            <div class="text-center md:hidden mb-8">
                 <h1 class="text-3xl font-bold text-cyan-600">KARTEN</h1>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Selamat Datang Kembali!</h2>
            <p class="text-slate-500 mb-8">Silakan login untuk melanjutkan.</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block mb-2 text-sm font-medium text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"
                           placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-slate-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-cyan-600 shadow-sm focus:ring-cyan-500" name="remember">
                        <span class="ms-2 text-sm text-slate-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-cyan-600 hover:underline" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Tombol Login -->
                <div class="mt-8">
                    <button type="submit" class="w-full text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors duration-300">
                        Login
                    </button>
                </div>

                <!-- Link ke Halaman Register -->
                <p class="text-sm text-slate-500 text-center mt-8">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-cyan-600 hover:underline">
                        Daftar di sini
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>

</body>
</html>
