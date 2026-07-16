@extends('customer.layouts.master')

@section('content')
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @php
                $cartItems = session('cart', []);
            @endphp

            @if(empty($cartItems))
                <div class="text-center py-5">
                    <h4 class="mb-3">Keranjang belanja kosong</h4>
                    <p class="text-muted mb-4">Belum ada menu yang Anda pilih.</p>
                    <a href="{{ route('menu') }}" class="btn btn-primary">Lihat Menu</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Gambar</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cartItems as $item)
                                @php
                                    $itemTotal = $item['price'] * $item['qty'];
                                    $total += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        @php
                                            $imagePath = !empty($item['image']) ? $item['image'] : 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=300&q=80';
                                            $imageSrc = filter_var($imagePath, FILTER_VALIDATE_URL) ? $imagePath : asset($imagePath);
                                        @endphp
                                        <img src="{{ $imageSrc }}" class="img-fluid rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $item['name'] ?? 'Menu' }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=300&q=80';">
                                    </td>
                                    <td>{{ $item['name'] ?? 'Menu' }}</td>
                                    <td>Rp{{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $item['qty'] ?? 0 }}</td>
                                    <td>Rp{{ number_format($itemTotal, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-sm rounded-circle bg-light border">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row g-4 justify-content-end mt-3">
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded p-4">
                            <h4 class="mb-4">Total Pesanan</h4>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal</span>
                                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>PPN (10%)</span>
                                <span>Rp{{ number_format($total * 0.1, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-3">
                                <strong>Total</strong>
                                <strong>Rp{{ number_format($total + ($total * 0.1), 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('checkout') }}" class="btn border-secondary py-3 text-primary text-uppercase">Lanjut ke Pembayaran</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection