<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $orderService;
    protected $productService;

    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    public function index()
    {
        $nama = Auth::user()->username;
        $orders = $this->orderService->getAllOrdersWithDetails();
        $products = $this->productService->getAllProducts();
        
        return view('home', compact('products', 'orders', 'nama'));
    }
}
