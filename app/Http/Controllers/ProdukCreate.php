<?php 

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdukCreate extends Controller
{
    protected $productService;

    // Menggunakan dependency injection untuk memasukkan ProductService
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $imagePath = null;
        if ($request->hasFile('gambar')) {
            Log::info('Image file is present.');
            $imagePath = $request->file('gambar')->store('images', 'public');
            Log::info('Image stored at: ' . $imagePath);
        } else {
            Log::warning('No image file found in the request.');
        }

        // Gunakan ProductService untuk menyimpan produk ke database dan JSON
        $produk = $this->productService->storeProduct($request->all(), $imagePath);

        return redirect()->back()->with('success', 'Produk berhasil disimpan');
    }
}
