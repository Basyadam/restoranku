<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function orders()
    {
        $orders = Order::with('orderItems')
            ->whereIn('status', ['pending', 'settlement'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cashier.orders', compact('orders'));
    }

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Status pesanan tidak valid untuk konfirmasi pembayaran.');
        }

        $order->update(['status' => 'settlement']);

        return redirect()->route('cashier.orders')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function orderDetail($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        return response()->json($order);
    }
}

