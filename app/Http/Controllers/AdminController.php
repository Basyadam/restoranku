<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ==================== DASHBOARD ====================
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'settlement')->sum('grandtotal');
        $totalMenu = Item::count();
        $totalEmployees = User::count();
        $ordersToday = Order::whereDate('created_at', today())->count();
        $revenueToday = Order::where('status', 'settlement')->whereDate('created_at', today())->sum('grandtotal');

        // Order status counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $settlementOrders = Order::where('status', 'settlement')->count();
        $cookedOrders = Order::where('status', 'cooked')->count();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = [];
        $monthlyLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = Order::where('status', 'settlement')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('grandtotal');
            $monthlyRevenue[] = $revenue;
            $monthlyLabels[] = $month->format('M Y');
        }

        // Recent orders (last 5)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Top selling items
        $topItems = OrderItem::selectRaw('item_id, SUM(quantity) as total_qty, SUM(total_price) as total_revenue')
            ->with('item')
            ->groupBy('item_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Revenue today chart (hourly breakdown)
        $hourlyRevenue = [];
        $hourlyLabels = [];
        for ($h = 0; $h < 24; $h++) {
            $hourlyLabels[] = sprintf('%02d:00', $h);
            $revenue = Order::where('status', 'settlement')
                ->whereDate('created_at', today())
                ->whereRaw('HOUR(created_at) = ?', [$h])
                ->sum('grandtotal');
            $hourlyRevenue[] = $revenue;
        }

        return view('admin.index', compact(
            'totalOrders', 'totalRevenue', 'totalMenu', 'totalEmployees',
            'ordersToday', 'revenueToday',
            'pendingOrders', 'settlementOrders', 'cookedOrders',
            'monthlyRevenue', 'monthlyLabels',
            'recentOrders', 'topItems',
            'hourlyRevenue', 'hourlyLabels'
        ));
    }

    // ==================== CATEGORY CRUD ====================
    public function categories()
    {
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.category.index', compact('categories'));
    }

    public function categoryCreate()
    {
        return view('admin.category.create');
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'cat_name'    => 'required|string|max:255|unique:categories,cat_name',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create([
            'cat_name'    => $request->cat_name,
            'description' => $request->description ?? '',
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function categoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'cat_name'    => 'required|string|max:255|unique:categories,cat_name,' . $id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update([
            'cat_name'    => $request->cat_name,
            'description' => $request->description ?? '',
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);

        // Cek apakah kategori memiliki item
        if ($category->items()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Kategori tidak bisa dihapus karena masih memiliki menu.');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus.');
    }

    // ==================== ITEM / MENU CRUD ====================
    public function items()
    {
        $items = Item::with('category')->orderBy('name', 'asc')->get();
        return view('admin.item.index', compact('items'));
    }

    public function itemCreate()
    {
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.item.create', compact('categories'));
    }

    public function itemStore(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'price'        => 'required|numeric|min:0',
            'stok'         => 'nullable|numeric|min:0',
            'categories_id' => 'required|exists:categories,id',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'    => 'nullable|boolean',
        ]);

        $imgName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img_item_upload'), $imgName);
        }

        Item::create([
            'name'          => $request->name,
            'description'   => $request->description ?? '',
            'price'         => $request->price,
            'stok'          => $request->stok ?? 0,
            'categories_id' => $request->categories_id,
            'img'           => $imgName,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.items')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function itemEdit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.item.edit', compact('item', 'categories'));
    }

    public function itemUpdate(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'price'        => 'required|numeric|min:0',
            'stok'         => 'nullable|numeric|min:0',
            'categories_id' => 'required|exists:categories,id',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'    => 'nullable|boolean',
        ]);

        $imgName = $item->img;
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($item->img && file_exists(public_path('img_item_upload/' . $item->img))) {
                unlink(public_path('img_item_upload/' . $item->img));
            }
            $image = $request->file('image');
            $imgName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img_item_upload'), $imgName);
        }

        $item->update([
            'name'          => $request->name,
            'description'   => $request->description ?? '',
            'price'         => $request->price,
            'stok'          => $request->stok ?? 0,
            'categories_id' => $request->categories_id,
            'img'           => $imgName,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.items')->with('success', 'Menu berhasil diperbarui.');
    }

    public function itemDelete($id)
    {
        $item = Item::findOrFail($id);

        // Hapus file gambar
        if ($item->img && file_exists(public_path('img_item_upload/' . $item->img))) {
            unlink(public_path('img_item_upload/' . $item->img));
        }

        $item->delete();
        return redirect()->route('admin.items')->with('success', 'Menu berhasil dihapus.');
    }

    // ==================== ORDERS MANAGEMENT ====================
    public function orders()
    {
        $orders = Order::with('orderItems')->orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }

    public function orderUpdateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,settlement,cooked']);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

