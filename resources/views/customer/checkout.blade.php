@extends('customer.layouts.master')

@section('content')
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">Detail Pembayaran</h1>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

@php
                    // Data dikirim dari MenuController@checkout
                @endphp

                @if(empty($cartItems))
                    <div class="text-center py-5">
                        <h4 class="mb-3">Keranjang belanja kosong</h4>
                        <p class="text-muted mb-4">Tidak ada item untuk checkout.</p>
                        <a href="{{ route('menu') }}" class="btn btn-primary">Lihat Menu</a>
                    </div>
                @else
                <form id="checkout-form">
                    @csrf
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-6">
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Nama Lengkap<sup>*</sup></label>
                                        <input type="text" name="customer_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Nomor WhatsApp<sup>*</sup></label>
                                        <input type="text" name="customer_phone" class="form-control" required>
                                    </div>
                                </div>
                            </div>   
                            <br>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-item">
                                        <textarea name="note" class="form-control" spellcheck="false" cols="30" rows="5" placeholder="Catatan pesanan (Opsional)"></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <br><br>
                                    <h4 class="mb-4">Detail Pesanan</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Gambar</th>
                                                <th scope="col">Menu</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $item)
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center mt-2">
                                                        <img src="{{ asset('img_item_upload/' . $item['image']) }}" class="img-fluid rounded-circle" style="width: 100px; height: 90px; object-fit: cover;" alt="" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=300&q=80';">
                                                    </div>
                                                </th>
                                                <td class="py-5">{{ $item['name'] }}</td>
                                                <td class="py-5">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                                <td class="py-5">{{ $item['qty'] }}</td>
                                                <td class="py-5">Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6 col-xl-6">
                            <div class="row g-4 align-items-center py-3">
                                <div class="col-lg-12">
                                    <div class="bg-light rounded">
                                        <div class="p-4">
                                            <h3 class="display-6 mb-4">Total <span class="fw-normal">Pesanan</span></h3>
                                            <div class="d-flex justify-content-between mb-4">
                                                <h5 class="mb-0 me-4">Subtotal</h5>
                                                <p class="mb-0">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-0 me-4">Pajak (10%)</p>
                                                <div class="">
                                                    <p class="mb-0">Rp{{ number_format($tax, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                            <h4 class="mb-0 ps-4 me-4">Total</h4>
                                            <h5 class="mb-0 pe-4">Rp{{ number_format($grandTotal, 0, ',', '.') }}</h5>
                                        </div>

<div class="py-4 mb-4">
                                            <h5 class="mb-3 ps-4 me-4">Metode Pembayaran</h5>
                                            
                                            <!-- QRIS Option -->
                                            <div class="form-check mb-1 ps-4">
                                                <input type="radio" class="form-check-input bg-primary border-0" id="qris" name="payment_method" value="qris" checked>
                                                <label class="form-check-label fw-bold" for="qris">QRIS</label>
                                                <p class="text-muted small mb-0 ms-1">Scan QR code untuk membayar</p>
                                            </div>

                                            <!-- QRIS Preview -->
                                            <div id="qris-preview" class="text-center mb-3" style="display: none;">
                                                <div class="d-inline-block p-3 bg-white rounded shadow-sm">
                                                    <div style="width: 200px; height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 2px solid #333;">
                                                        <div style="display: grid; grid-template-columns: repeat(10, 1fr); gap: 2px; width: 160px; height: 160px;">
                                                            <div style="background: #000; grid-column: span 3; grid-row: span 3;"></div>
                                                            <div style="grid-column: span 4;"></div>
                                                            <div style="background: #000; grid-column: span 3; grid-row: span 3;"></div>
                                                            <div style="grid-column: span 3;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 2;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 3;"></div>
                                                            <div style="background: #000; grid-column: span 3; grid-row: span 3;"></div>
                                                            <div style="grid-column: span 4;"></div>
                                                            <div style="background: #000; grid-column: span 3; grid-row: span 3;"></div>
                                                            <div style="grid-column: span 1;"></div>
                                                            <div style="background: #000; grid-column: span 2; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 4;"></div>
                                                            <div style="background: #000; grid-column: span 2; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 1;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 1;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 1;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 5;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 2;"></div>
                                                            <div style="grid-column: span 1;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 1;"></div>
                                                            <div style="background: #000; grid-column: span 3; grid-row: span 3;"></div>
                                                            <div style="grid-column: span 1;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 2;"></div>
                                                            <div style="background: #000; grid-column: span 1; grid-row: span 1;"></div>
                                                            <div style="grid-column: span 2;"></div>
                                                            <div style="background: #000; grid-column: span 3; grid-row: span 3;"></div>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0 mt-2 fw-bold text-dark">Rp{{ number_format($grandTotal, 0, ',', '.') }}</p>
                                                    <p class="mb-0 text-muted small">Scan untuk membayar</p>
                                                </div>
                                            </div>

                                            <!-- Cash Option -->
                                            <div class="form-check ps-4">
                                                <input type="radio" class="form-check-input bg-primary border-0" id="cash" name="payment_method" value="tunai">
                                                <label class="form-check-label fw-bold" for="cash">Tunai</label>
                                                <p class="text-muted small mb-0 ms-1">Bayar langsung di kasir</p>
                                            </div>
                                            <div id="cash-info" class="alert alert-info mt-3 mb-0" style="display: none;">
                                                <i class="fa fa-info-circle me-2"></i>
                                                Silakan melakukan pembayaran langsung di kasir. Pesanan Anda akan diproses setelah pembayaran dikonfirmasi.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn border-secondary py-3 text-uppercase text-primary" id="confirm-btn">Konfirmasi Pesanan</button> 
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();

var $btn = $('#confirm-btn');
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Memproses...');

                $.ajax({
                    url: "{{ route('checkout.place') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('✅ ' + response.message + '\nKode Pesanan: ' + response.order_code);
                            window.location.href = "{{ route('order.success') }}";
                        } else {
                            alert('❌ ' + response.message);
                            $btn.prop('disabled', false).text('Konfirmasi Pesanan');
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = Object.values(xhr.responseJSON.errors).flat();
                            msg = errors.join('\n');
                        }
                        alert('❌ ' + msg);
                        $btn.prop('disabled', false).text('Konfirmasi Pesanan');
                    }
                });
            });
        });
    </script>
@endsection
