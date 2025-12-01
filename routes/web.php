<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Welcome');
});

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/hello', function () {
    return 'Hello World';
});

Route::get('/about', function () {
    return 'Nim = 23.51.0035, Nama = Rena Laurentina';
});

// Route::get('/user/{name?}', function ($name='Paijo') {
//     return 'Hallo Nama Saya '.$name;
// });

// Route::get('/user/{name}', function ($name) {
//     return 'Hallo Nama Saya '.$name;
// });

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::get('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::get('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);