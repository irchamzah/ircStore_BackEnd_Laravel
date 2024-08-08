<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // OrderController.php
    public function confirm(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = $this->getOrderDetails($orderId);

        return view('order.confirm', compact('order'));
    }

    private function getOrderDetails($orderId)
    {
        // Logika untuk mengambil data pesanan
        return Order::with('items.product')->findOrFail($orderId);
    }

    public function complete()
    {
        // Logika untuk menyelesaikan pesanan
        return view('checkout.complete');
    }
}
