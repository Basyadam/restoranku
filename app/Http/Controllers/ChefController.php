<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function orders()
    {
        $orders = Order::with('orderItems')
            ->whereIn('status', ['settlement'])
            ->orderBy('created_at', 'asc')
            ->get();

        $completedOrders = Order::with('orderItems')
            ->where('status', 'cooked')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('chef.orders', compact('orders', 'completedOrders'));
    }

    public function markAsCooked($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'settlement') {
            return redirect()->back()->with('error', 'Pesanan harus dikonfirmasi pembayaran terlebih dahulu.');
        }

        $order->update(['status' => 'cooked']);

        return redirect()->route('chef.orders')->with('success', 'Pesanan selesai dimasak.');
    }
}

