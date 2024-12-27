<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(UserService $userService, OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function beli(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        $data = $request->all();
        $data['id_customer'] = Auth::user()->id;

        $order = $this->orderService->createOrder($data);

        return redirect()->back();
    }
}
