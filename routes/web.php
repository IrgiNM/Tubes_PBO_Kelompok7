<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;

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



Route::get('/users/{filename}', function ($filename) {
    $path = storage_path('app/public/users/' . $filename);

    // Memastikan file ada
    if (!file_exists($path)) {
        abort(404, 'File not found');
    }

    return response()->json(json_decode(file_get_contents($path)));
});

Route::post('/users', function (Request $request) {
    $request->validate([
        'filename' => 'required|string',
        'data' => 'required|array'
    ]);

    $filename = $request->filename;
    $path = storage_path('app/public/users/' . $filename);

    // Menyimpan data ke file JSON
    try {
        file_put_contents($path, json_encode($request->data, JSON_PRETTY_PRINT));
        return response()->json(['message' => 'File created and data saved successfully'], 201);
    } catch (Exception $e) {
        return response()->json(['error' => 'Failed to save data: ' . $e->getMessage()], 500);
    }
});

Route::put('/users/{filename}', function (Request $request, $filename) {
    $path = storage_path('app/public/users/' . $filename);

    // Memastikan file ada
    if (!file_exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    // Mengambil data yang ada dan menggabungkannya dengan data baru
    try {
        $currentData = json_decode(file_get_contents($path), true);

        // Gabungkan data yang lama dengan data baru
        $updatedData = array_merge($currentData, $request->all());

        // Menyimpan data yang diperbarui
        file_put_contents($path, json_encode($updatedData, JSON_PRETTY_PRINT));

        return response()->json(['message' => 'File updated successfully'], 200);
    } catch (Exception $e) {
        return response()->json(['error' => 'Failed to update data: ' . $e->getMessage()], 500);
    }
});

Route::delete('/users/{filename}', function ($filename) {
    $path = storage_path('app/public/users/' . $filename);

    // Memastikan file ada
    if (!file_exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    // Menghapus file
    try {
        unlink($path);  // Menghapus file
        return response()->json(['message' => 'File deleted successfully'], 200);
    } catch (Exception $e) {
        return response()->json(['error' => 'Failed to delete file: ' . $e->getMessage()], 500);
    }
});

