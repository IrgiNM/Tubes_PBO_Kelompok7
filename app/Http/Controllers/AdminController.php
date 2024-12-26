<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\ProductService;

class AdminController extends Controller
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
        $orders = $this->orderService->getAllOrdersWithDetails();
        $products = $this->productService->getAllProducts();
        
        return view('admin', compact('products', 'orders'));
    }
}
