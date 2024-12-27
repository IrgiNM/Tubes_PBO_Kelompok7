<?php 

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdukController extends Controller
{
    protected $productService;

    // Menggunakan dependency injection untuk memasukkan ProductService
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(Request $request)
    {
        return app(ProdukCreate::class)->create($request);
    }

    public function delete($id)
    {
        return app(ProdukDelete::class)->delete($id);
    }
}
