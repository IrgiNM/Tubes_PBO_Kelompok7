<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserFileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users/{filename}', function ($filename) {
    $path = storage_path('app/public/users/' . $filename);

    // Memastikan file ada
    if (!file_exists($path)) {
        abort(404, 'File not found');
    }

    return response()->json(json_decode(file_get_contents($path)));
});

Route::post('/users', function (Request $request) {
    // Validasi input
    $validatedData = $request->validate([
        'filename' => 'required|string',
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:5|confirmed',
    ]);

    $filename = $validatedData['filename'];
    $path = storage_path('app/public/users/' . $filename);

    // Data yang akan disimpan
    $data = [
        'username' => $validatedData['username'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']), // Enkripsi password sebelum menyimpan
    ];

    // Menyimpan data ke file JSON
    try {
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
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

    // Mengambil data yang ada
    try {
        $currentData = json_decode(file_get_contents($path), true);

        // Validasi data baru (sesuaikan dengan kebutuhan)
        $request->validate([
            'username' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $currentData['email'],
            'password' => 'sometimes|required|string|min:5|confirmed',
        ]);

        // Gabungkan data yang lama dengan data baru
        $updatedData = array_merge($currentData, $request->only(['username', 'email', 'password']));

        // Encrypt password if it's being updated
        if ($request->filled('password')) {
            $updatedData['password'] = bcrypt($request->password);
        }

        // Hapus file JSON lama
        unlink($path);

        // Membuat file JSON baru dengan data yang diperbarui
        file_put_contents($path, json_encode($updatedData, JSON_PRETTY_PRINT));

        return response()->json(['message' => 'File updated successfully', 'data' => $updatedData], 200);
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