<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class UserFileController extends Controller
{
    public function show($filename)
    {
        $path = 'app/public/users/' . $filename;

        if (!Storage::exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $fileContent = Storage::get($path);
        return response()->json(json_decode($fileContent, true));
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
            'data' => 'required|array'
        ]);

        $filename = $request->filename;
        $path = 'app/public/users/' . $filename;

        try {
            Storage::put($path, json_encode($request->data, JSON_PRETTY_PRINT));
            return response()->json(['message' => 'File created and data saved successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $filename)
    {
        $path = storage_path('app/public/users/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        try {
            $currentData = json_decode(file_get_contents($path), true);
            $updatedData = array_merge($currentData, $request->all());
            file_put_contents($path, json_encode($updatedData, JSON_PRETTY_PRINT));

            return response()->json(['message' => 'File updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($filename)
    {
        $path = 'app/public/users/' . $filename;

        if (!Storage::exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        try {
            Storage::delete($path);
            return response()->json(['message' => 'File deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete file: ' . $e->getMessage()], 500);
        }
    }
}
