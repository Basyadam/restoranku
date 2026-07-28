@extends('admin.layouts.master')

@section('page-title', 'Kasir - Konfirmasi Pesanan')
@section('page-subtitle', 'Konfirmasi pembayaran pesanan pelanggan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="rounded bg-light p-4">
            <h5 class="mb-3"><i class="fa fa-cash-register me-2 text-primary"></i>Daftar Pesanan Menunggu Pembayaran</h5>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="text-center py-5">
                    <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted">Tidak ada pesanan yang menunggu konfirmasi.</p>
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="cashierTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Kode</th>
                            <th width="12%">Tanggal</th>
                            <th width="12%">Total</th>
                            <th width="10%">Metode</th>
                            <th width="8%">Status</th>
                            <th width="8%">Meja</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $order->order_ccode }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>Rp{{ number_format($order->grandtotal, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $order->payment_method == 'qris' ? 'bg-success' : 'bg-info' }}">
                                    {{ $order->payment_method == 'qris' ? 'QRIS' : 'Tunai' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = $order->status == 'pending' ? 'bg-warning text-dark' : 'bg-success';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="text-center">{{ $order->table_number }}</td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    @if($order->status == 'pending')
                                    <form action="{{ route('cashier.orders.confirm', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Konfirmasi pembayaran untuk pesanan {{ $order->order_ccode }}?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-check-circle"></i> Konfirmasi Bayar
                                        </button>
                                    </form>
                                    @endif
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $order->id }}">
                                        <i class="fa fa-eye"></i> Detail
                                    </button>
                                </div>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Pesanan {{ $order->order_ccode }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-1"><strong>Kode:</strong> {{ $order->order_ccode }}</p>
                                                        <p class="mb-1"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                                        <p class="mb-1"><strong>Metode:</strong> {{ $order->payment_method == 'qris' ? 'QRIS' : 'Tunai' }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-1"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                                        <p class="mb-1"><strong>Meja:</strong> {{ $order->table_number }}</p>
                                                        @if($order->note)
                                                            <p class="mb-1"><strong>Catatan:</strong> {{ $order->note }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold">Item Pesanan</h6>
                                                <table class="table table-sm table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Menu</th>
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-end">Harga</th>
                                                            <th class="text-end">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->orderItems as $item)
                                                        <tr>
                                                            <td>{{ $item->item->name ?? 'Menu #'.$item->item_id }}</td>
                                                            <td class="text-center">{{ $item->quantity }}</td>
                                                            <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
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
                                                            <th colspan="3" class="text-end">PPN 10%</th>
                                                            <th class="text-end">Rp{{ number_format($order->tax, 0, ',', '.') }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="3" class="text-end">Grand Total</th>
                                                            <th class="text-end">Rp{{ number_format($order->grandtotal, 0, ',', '.') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

