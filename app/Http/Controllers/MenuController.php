<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Item;

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

        return redirect()->route('cart')->with('success', 'Berhasil ditambahkan ke keranjang');
    }
}
