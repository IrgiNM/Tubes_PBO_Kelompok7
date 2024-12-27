<?php 

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdukDelete extends Controller
{
    public function delete($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        return redirect()->route('admin');
    }
}
