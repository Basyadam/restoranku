# TODO: Perbaikan Keranjang - Checkout Page

## Completed Steps

### Perbaikan Cart (sebelumnya)
- [x] Perbaiki HTML tabel + quantity buttons
- [x] Tambah route cart.remove + method removeFromCart()
- [x] Update harga dinamis via AJAX (tanpa reload)
- [x] Fix `@section('scripts')` bug

### Checkout Page
- [x] **routes/web.php** - `checkout` + `checkout.place` route
- [x] **MenuController.php** - `checkout()` method (ambil data cart, hitung total)
- [x] **MenuController.php** - `placeOrder()` method (validasi, simpan Order + OrderItems, hapus cart)
- [x] **checkout.blade.php** - Tampilkan item cart dinamis
- [x] **checkout.blade.php** - Form nama, WA, catatan, metode bayar
- [x] **checkout.blade.php** - AJAX submit + success/error handling

