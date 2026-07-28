@extends('admin.layouts.master')

@section('page-title', 'Chef - Daftar Pesanan')
@section('page-subtitle', 'Kelola pesanan yang perlu dimasak')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="rounded bg-light p-4">
            <h5 class="mb-3"><i class="fa fa-fire me-2 text-primary"></i>Pesanan Perlu Dimasak</h5>

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
                    <p class="text-muted">Tidak ada pesanan yang perlu dimasak.</p>
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="chefTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Kode</th>
                            <th width="12%">Tanggal</th>
                            <th width="8%">Meja</th>
                            <th width="30%">Item Pesanan</th>
                            <th width="15%">Catatan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $order->order_ccode }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">{{ $order->table_number }}</td>
                            <td>
                                <ul class="mb-0 ps-3">
                                    @foreach($order->orderItems as $item)
                                    <li>{{ $item->item->name ?? 'Menu #'.$item->item_id }} x {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $order->note ?? '-' }}</td>
                            <td>
                                <form action="{{ route('chef.orders.cook', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai pesanan {{ $order->order_ccode }} sudah selesai dimasak?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Selesai Dimasak
                                    </button>
                                </form>
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

@if($completedOrders->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="rounded bg-light p-4">
            <h5 class="mb-3"><i class="fa fa-history me-2 text-secondary"></i>Riwayat Pesanan Selesai Dimasak</h5>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Kode</th>
                            <th width="15%">Tanggal</th>
                            <th width="10%">Meja</th>
                            <th width="40%">Item</th>
                            <th width="10%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedOrders as $index => $order)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $order->order_ccode }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">{{ $order->table_number }}</td>
                            <td>
                                <ul class="mb-0 ps-3">
                                    @foreach($order->orderItems as $item)
                                    <li>{{ $item->item->name ?? 'Menu #'.$item->item_id }} x {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <span class="badge bg-primary">Selesai</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

