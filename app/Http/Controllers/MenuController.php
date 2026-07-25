<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('meja');
        if ($tableNumber) {
            Session::put('table_number', $tableNumber);
        }

        $items = Item::where('is_active', 1)->with('category')->orderBy('name', 'asc')->get();

        return view('customer.menu', compact('items', 'tableNumber'));
    }

    public function cart()
    {
        return view('customer.cart');
    }

    public function addToCart(Request $request, $itemId = null)
    {
        $menuId = $request->input('item_id', $request->route('item_id', $itemId));

        if (!$menuId) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID item tidak valid.',
            ], 400);
        }

        $menu = Item::find($menuId);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan.',
            ], 404);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += 1;
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'image' => $menu->img,
                'qty' => 1,
            ];
        }

        Session::put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil ditambahkan ke keranjang',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->route('cart')->with('success', 'Berhasil ditambahkan ke keranjang');
    }

    public function updateCart(Request $request)
    {
        $itemId = $request->input('id');
        $newQty = (int) $request->input('qty');

        // qty minimal 1 -- kalau ingin 0, arahkan ke removeFromCart di frontend
        if ($newQty <= 0) {
            return response()->json(['success' => false, 'message' => 'Jumlah tidak valid.']);
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$itemId])) {
            $cart[$itemId]['qty'] = $newQty;
            Session::put('cart', $cart);

            $subtotal = 0;
            foreach ($cart as $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['qty'];
            }
            $itemTotal = $cart[$itemId]['price'] * $newQty;
            $ppn = $subtotal * 0.1;
            $grandTotal = $subtotal + $ppn;

            return response()->json([
                'success' => true,
                'item_total' => $itemTotal,
                'item_total_formatted' => 'Rp' . number_format($itemTotal, 0, ',', '.'),
                'subtotal' => $subtotal,
                'subtotal_formatted' => 'Rp' . number_format($subtotal, 0, ',', '.'),
                'ppn' => $ppn,
                'ppn_formatted' => 'Rp' . number_format($ppn, 0, ',', '.'),
                'grand_total' => $grandTotal,
                'grand_total_formatted' => 'Rp' . number_format($grandTotal, 0, ',', '.'),
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan di keranjang.']);
    }

    public function removeFromCart(Request $request)
    {
        $itemId = $request->input('id');

        $cart = Session::get('cart', []);
        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);

            $subtotal = 0;
            foreach ($cart as $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['qty'];
            }
            $ppn = $subtotal * 0.1;
            $grandTotal = $subtotal + $ppn;

            return response()->json([
                'success' => true,
                'cart_empty' => empty($cart),
                'subtotal' => $subtotal,
                'subtotal_formatted' => 'Rp' . number_format($subtotal, 0, ',', '.'),
                'ppn' => $ppn,
                'ppn_formatted' => 'Rp' . number_format($ppn, 0, ',', '.'),
                'grand_total' => $grandTotal,
                'grand_total_formatted' => 'Rp' . number_format($grandTotal, 0, ',', '.'),
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan di keranjang.']);
    }

    public function checkout()
    {
        $cartItems = Session::get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $tax = $subtotal * 0.1;
        $grandTotal = $subtotal + $tax;

        return view('customer.checkout', compact('cartItems', 'subtotal', 'tax', 'grandTotal'));
    }

    public function placeOrder(Request $request)
    {
        $cartItems = Session::get('cart', []);

        if (empty($cartItems)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.']);
        }

        $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:20',
            'payment_method'  => 'required|in:tunai,qris',
            'note'            => 'nullable|string|max:500',
        ]);

        // Hitung total
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $tax = $subtotal * 0.1;
        $grandTotal = $subtotal + $tax;

        // Generate order code
        $orderCode = 'ORD-' . strtoupper(Str::random(8));

        // Buat order
        $order = Order::create([
            'order_ccode'     => $orderCode,
            'user_id'         => Auth::id() ?? 1, // fallback guest, sesuaikan kalau perlu logika lain
            'subtotal'        => $subtotal,
            'tax'             => $tax,
            'grandtotal'      => $grandTotal,
            'status'          => 'pending',
            'table_number'    => Session::get('table_number', 0),
            'payment_method'  => $request->payment_method,
            'note'            => $request->note,
        ]);

        // Simpan order items
        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['qty'];
            OrderItem::create([
                'order_id'    => $order->id,
                'item_id'     => $item['id'],
                'quantity'    => $item['qty'],
                'price'       => $item['price'],
                'tax'         => $tax,
                'total_price' => $itemTotal,
            ]);
        }

        // Simpan order_code di session untuk halaman sukses
        Session::put('last_order_code', $orderCode);

        // Hapus cart dari session
        Session::forget('cart');

        if ($request->payment_method === 'tunai') {
            return response()->json([
                'success' => true,
            ]);
        }

        // Pembayaran QRIS via Midtrans
        $isProduction = config('midtrans.is_production');
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = $isProduction;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $itemDetails = [];
        foreach ($cartItems as $item) {
            $itemDetails[] = [
                'id'       => $item['id'],
                'price'    => (int) $item['price'],
                'quantity' => $item['qty'],
                'name'     => $item['name'],
            ];
        }
        // Tambahkan item pajak agar total item_details sama dengan gross_amount
        $itemDetails[] = [
            'id'       => 'TAX',
            'price'    => (int) $tax,
            'quantity' => 1,
            'name'     => 'PPN 10%',
        ];

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_ccode,
                'gross_amount' => (int) $order->grandtotal,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'phone'      => $request->customer_phone,
            ],
            'item_details'  => $itemDetails,
            'enabled_payments' => ['qris'],
            'callbacks' => [
                'finish' => route('order.success'),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'order_code' => $order->order_ccode,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function orderSuccess()
    {
        $orderCode = Session::pull('last_order_code');

        if (!$orderCode) {
            return redirect()->route('menu');
        }

        $order = Order::where('order_ccode', $orderCode)->with('orderItems')->first();

        if (!$order) {
            return redirect()->route('menu');
        }

        return view('customer.order-success', compact('order'));
    }
}
