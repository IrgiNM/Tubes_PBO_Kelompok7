<?php

namespace App\Services;

use App\Models\Produk;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductService
{
    public function storeProduct($data, $imagePath)
    {
        try {
            // Simpan ke database
            $produk = new Produk();
            $produk->nama_produk = $data['nama'];
            $produk->gambar_produk = $imagePath;
            $produk->harga = $data['harga'];
            $produk->save();

            // Simpan ke JSON
            $this->storeProductJson($produk);

            return $produk;
        } catch (Exception $e) {
            Log::error('Failed to store product: ' . $e->getMessage());
            throw new Exception('Unable to store product at this time.');
        }
    }

    public function storeProductJson($produk)
    {
        try {
            $productData = $produk->toArray();  // Mengonversi data produk menjadi array
            $jsonPath = storage_path('app/public/products/products' . $produk->id . '.json');

            // Pastikan direktori ada, jika tidak maka buat
            $directory = dirname($jsonPath);
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Menulis data produk ke file JSON
            if (file_put_contents($jsonPath, json_encode($productData, JSON_PRETTY_PRINT)) === false) {
                throw new Exception('Failed to write product data to JSON file.');
            }

            Log::info("Product data saved to JSON at: " . $jsonPath);
        } catch (Exception $e) {
            Log::error('Error saving product data to JSON: ' . $e->getMessage());
            throw new Exception('Unable to save product data to JSON file.');
        }
    }

    public function getAllProducts()
    {
        try {
            return Produk::all();
        } catch (Exception $e) {
            Log::error('Error retrieving products: ' . $e->getMessage());
            throw new Exception('Unable to fetch products at this time.');
        }
    }
}
