@extends('customer.layouts.master')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <div class="mb-4">
                <i class="fa fa-check-circle text-success" style="font-size: 80px;"></i>
            </div>
            <h1 class="display-5 fw-bold">Pesanan Berhasil! 🎉</h1>
            <p class="text-muted fs-5">Terima kasih, pesanan Anda telah diterima.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Order Code -->
                        <div class="text-center mb-4 p-4 bg-light rounded">
                            <p class="text-muted mb-1">Kode Pesanan</p>
                            <h2 class="fw-bold text-primary mb-0" style="letter-spacing: 3px;">{{ $order->order_ccode }}</h2>
                        </div>

                        <!-- Order Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status:</strong> 
                                    <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                </p>
                                <p class="mb-1"><strong>Metode Bayar:</strong> 
                                    {{ $order->payment_method == 'qris' ? 'QRIS' : 'Tunai' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Subtotal:</strong> Rp{{ number_format($order->subtotal, 0, ',', '.') }}</p>
                                <p class="mb-1"><strong>PPN (10%):</strong> Rp{{ number_format($order->tax, 0, ',', '.') }}</p>
                                <p class="mb-0 fw-bold fs-5"><strong>Total:</strong> Rp{{ number_format($order->grandtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <h5 class="mb-3">Detail Pesanan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Menu</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->item->name ?? 'Menu #' . $item->item_id }}</td>
                                        <td class="text-center">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Subtotal</th>
                                        <th class="text-end">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">PPN (10%)</th>
                                        <th class="text-end">Rp{{ number_format($order->tax, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Grand Total</th>
                                        <th class="text-end fs-5">Rp{{ number_format($order->grandtotal, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Payment Method Info -->
                        @if($order->payment_method == 'qris')
                        <div class="alert alert-success mt-3">
                            <i class="fa fa-qrcode me-2"></i>
                            Silakan scan QRIS untuk menyelesaikan pembayaran. Pesanan akan diproses setelah pembayaran dikonfirmasi.
                        </div>
                        @else
                        <div class="alert alert-info mt-3">
                            <i class="fa fa-money me-2"></i>
                            Silakan melakukan pembayaran di kasir. Pesanan Anda akan diproses setelah pembayaran dikonfirmasi.
                        </div>
                        @endif

                        @if($order->note)
                        <div class="mt-3 p-3 bg-light rounded">
                            <strong>Catatan:</strong> {{ $order->note }}
                        </div>
                        @endif

                        <div class="text-center mt-4">
                            <a href="{{ route('menu') }}" class="btn btn-primary btn-lg px-5">
                                <i class="fa fa-arrow-left me-2"></i>Kembali ke Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
