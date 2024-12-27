<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class OrderService
{
    public function createOrder($data)
    {
        try {
            $order = new Order();
            $order->id_customer = $data['id_customer'];
            $order->status = "lunas";
            $order->id_produk = $data['id'];
            $order->jumlah = $data['jumlah'];
            $order->total_harga = $data['harga'];
            $order->save();

            $this->storeOrderJson($order);

            return $order;
        } catch (Exception $e) {
            Log::error('Failed to create order: ' . $e->getMessage());
            throw new Exception('Unable to create order at this time.');
        }
    }

    public function storeOrderJson($order)
    {
        try {
            $orderData = $order->toArray();
            $jsonPath = storage_path('app/public/orders/orders' . $order->id . '.json');
            
            // Check if directory exists, create if it doesn't
            $directory = dirname($jsonPath);
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            
            // Write order data to JSON file
            if (file_put_contents($jsonPath, json_encode($orderData, JSON_PRETTY_PRINT)) === false) {
                throw new Exception('Failed to write order data to JSON file.');
            }

            Log::info("Order data saved to JSON at: " . $jsonPath);
        } catch (Exception $e) {
            Log::error('Error saving order data to JSON: ' . $e->getMessage());
            throw new Exception('Unable to save order data to JSON file.');
        }
    }

    public function getAllOrdersWithDetails()
    {
        try {
            return Order::join('users', 'order.id_customer', '=', 'users.id')
                        ->join('produk', 'order.id_produk', '=', 'produk.id')
                        ->select('order.*', 'users.username as nama', 'produk.nama_produk as produk')
                        ->get();
        } catch (Exception $e) {
            Log::error('Error retrieving orders: ' . $e->getMessage());
            throw new Exception('Unable to fetch orders at this time.');
        }
    }
}
