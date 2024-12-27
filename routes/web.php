<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserFileController;
use Illuminate\Support\Facades\File; 

// Halaman utama Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Route yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Route untuk halaman login
Route::get('/', function () {
    return view('login');
})->name('login');

// Route untuk proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.user');

// Route untuk halaman registrasi
Route::get('/register', function () {
    return view('signup');
})->name('signup');

// Route untuk proses registrasi
Route::post('/register', [AuthController::class, 'daftar'])->name('daftar.user');

// Route untuk logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');





