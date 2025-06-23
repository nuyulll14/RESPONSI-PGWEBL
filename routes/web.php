<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PolylinesController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TableController;

// Rute ini PUBLIK, bisa diakses oleh siapa saja (tamu atau yang sudah login)
Route::get('/', [PublicController::class, 'index'])->name('home');

// Semua rute di dalam grup ini WAJIB LOGIN untuk diakses
Route::middleware(['auth', 'verified'])->group(function () {

    // =======================================================================
    // == INI ADALAH KODE PERBAIKANNYA ==
    // =======================================================================
    // Rute ini berfungsi sebagai "jaring pengaman". Jika ada bagian dari
    // aplikasi yang masih memanggil route('dashboard'), pengguna akan
    // secara otomatis diarahkan ke halaman utama.
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');
    // =======================================================================

    // Halaman Peta
    Route::get('/map', [PointsController::class, 'index'])->name('map');

    // Halaman Tabel
    Route::get('/table', [TableController::class, 'index'])->name('table');

    // Semua fungsi CRUD untuk Points, Polylines, dan Polygons
    Route::resource('points', PointsController::class);
    Route::resource('polylines', PolylinesController::class);
    Route::resource('polygons', PolygonsController::class);

    // Rute untuk manajemen profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Memuat rute untuk otentikasi (login, register, dll.)
require __DIR__.'/auth.php';
