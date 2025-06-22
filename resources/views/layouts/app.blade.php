<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cafe POS' }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- Ikon --}}
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Vite Assets --}}
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 text-white flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-slate-700">
                <h1 class="text-2xl font-display font-bold">Cafe<span class="text-amber-500">POS</span></h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ url('/home') }}" class="flex items-center px-4 py-2.5 rounded-lg transition duration-200 {{ request()->is('home*') ? 'bg-amber-500' : 'hover:bg-slate-700' }}">
                    <i data-feather="home" class="w-5 h-5 mr-3"></i> Dashboard
                </a>
                <a href="{{ url('/menu') }}" class="flex items-center px-4 py-2.5 rounded-lg transition duration-200 {{ request()->is('menu*') ? 'bg-amber-500' : 'hover:bg-slate-700' }}">
                    <i data-feather="book-open" class="w-5 h-5 mr-3"></i> Menu
                </a>
                <a href="{{ url('/kategori') }}" class="flex items-center px-4 py-2.5 rounded-lg transition duration-200 {{ request()->is('kategori*') ? 'bg-amber-500' : 'hover:bg-slate-700' }}">
                    <i data-feather="tag" class="w-5 h-5 mr-3"></i> Kategori
                </a>
                <a href="{{ url('/pelanggan') }}" class="flex items-center px-4 py-2.5 rounded-lg transition duration-200 {{ request()->is('pelanggan*') ? 'bg-amber-500' : 'hover:bg-slate-700' }}">
                    <i data-feather="users" class="w-5 h-5 mr-3"></i> Pelanggan
                </a>
                <a href="{{ url('/transaksi') }}" class="flex items-center px-4 py-2.5 rounded-lg transition duration-200 {{ request()->is('transaksi*') ? 'bg-amber-500' : 'hover:bg-slate-700' }}">
                    <i data-feather="shopping-cart" class="w-5 h-5 mr-3"></i> Transaksi
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-slate-700">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center px-4 py-2.5 rounded-lg hover:bg-red-500 transition duration-200">
                    <i data-feather="log-out" class="w-5 h-5 mr-3"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6">
                <h2 class="text-xl font-bold text-slate-700 font-display">@yield('title', 'Dashboard')</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-slate-600">Selamat datang, {{ Auth::user()->name }}</span>
                    <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=F59E0B&color=fff" alt="Avatar">
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Script untuk render ikon --}}
    <script>
        feather.replace()
    </script>
</body>
</html>
