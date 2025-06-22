{{--
  Navbar modern dengan Tailwind CSS dan Alpine.js
  - Sepenuhnya responsif (dengan menu hamburger di mobile)
  - Dropdown untuk menu 'Data'
  - Logika login/logout yang sama seperti sebelumnya
--}}
<nav x-data="{ open: false, dropdownOpen: false }" class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Nama Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <i class="fa-solid fa-heart-pulse text-2xl text-cyan-600"></i>
                    <span class="font-extrabold text-xl text-slate-800 tracking-tight">KARTEN</span>
                </a>
            </div>

            <!-- Menu untuk Desktop -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-cyan-600 font-medium transition-colors duration-200 {{ request()->is('/') ? 'text-cyan-600' : '' }}">Home</a>
                <a href="{{ route('map') }}" class="text-gray-600 hover:text-cyan-600 font-medium transition-colors duration-200 {{ request()->is('map*') ? 'text-cyan-600' : '' }}">Peta</a>
                <a href="{{ route('table') }}" class="text-gray-600 hover:text-cyan-600 font-medium transition-colors duration-200 {{ request()->is('table*') ? 'text-cyan-600' : '' }}">Tabel</a>

                @auth
                <!-- Dropdown Menu Data -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center text-gray-600 hover:text-cyan-600 font-medium transition-colors duration-200">
                        <span><i class="fa-solid fa-database mr-1"></i> Data</span>
                        <svg class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                        <a href="{{ route('api.points') }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-50">Points</a>
                        <a href="{{ route('api.polylines') }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-50">Polylines</a>
                        <a href="{{ route('api.polygons') }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-50">Polygons</a>
                    </div>
                </div>
                @endauth
            </div>

            <!-- Tombol Auth di Desktop -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition-colors duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-cyan-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-cyan-700 transition-all duration-300">
                        <i class="fa-solid fa-right-to-bracket"></i> Login
                    </a>
                @endguest
            </div>

            <!-- Tombol Hamburger untuk Mobile -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{'hidden': open, 'block': !open }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <svg :class="{'hidden': !open, 'block': open }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu untuk Mobile (muncul saat hamburger diklik) -->
    <div :class="{'block': open, 'hidden': !open}" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'bg-cyan-100 text-cyan-700' : 'text-gray-600 hover:bg-gray-50' }}">Home</a>
            <a href="{{ route('map') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('map*') ? 'bg-cyan-100 text-cyan-700' : 'text-gray-600 hover:bg-gray-50' }}">Peta</a>
            <a href="{{ route('table') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('table*') ? 'bg-cyan-100 text-cyan-700' : 'text-gray-600 hover:bg-gray-50' }}">Tabel</a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
            <div class="px-2 space-y-1">
                <p class="px-3 py-2 font-semibold">Data</p>
                <a href="{{ route('api.points') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Points</a>
                <a href="{{ route('api.polylines') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Polylines</a>
                <a href="{{ route('api.polygons') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Polygons</a>
            </div>
            <div class="mt-3 px-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Logout</button>
                </form>
            </div>
            @else
            <div class="px-2">
                <a href="{{ route('login') }}" class="block w-full bg-cyan-600 text-white text-center px-3 py-2 rounded-md font-semibold hover:bg-cyan-700">Login</a>
            </div>
            @endguest
        </div>
    </div>
</nav>
