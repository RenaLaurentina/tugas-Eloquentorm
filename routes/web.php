<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/hello', function () {
    return 'Hello World';
});

Route::get('/about', function () {
    return 'NIM = 23.51.0035, Nama = Rena Laurentina';
});

/* ================= DATA MASTER ================= */
Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);

/* ================= USER ================= */
Route::prefix('user')->group(function () {

    // Halaman utama user
    Route::get('/', [UserController::class, 'index']);

    // Ambil data json untuk Datatables (Wajib POST)
    Route::post('/list', [UserController::class, 'list']);

    // Proses Tambah Data
    Route::get('/create', [UserController::class, 'create']); // Menampilkan form tambah
    Route::post('/', [UserController::class, 'store']);       // Menyimpan data baru (Action URL: /user)

    // Route Parameter (Wajib diletakkan paling bawah agar tidak bentrok)
    Route::get('/{id}', [UserController::class, 'show']);       // Menampilkan detail
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // Menampilkan form edit
    Route::put('/{id}', [UserController::class, 'update']);     // Menyimpan perubahan data
    Route::delete('/{id}', [UserController::class, 'destroy']); // Menghapus data
});