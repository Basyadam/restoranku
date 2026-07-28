@extends('admin.layouts.master')

@section('title', 'Dashboard - Restoranku')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . (Auth::user()->fullname ?? 'Admin') . '!')

@section('content')
<!-- Stats Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm bg-gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="card-text opacity-75 mb-1">Total Pesanan</p>
                        <h3 class="card-title fw-bold mb-0">{{ $totalOrders }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 d-flex align-items-center gap-2 small opacity-75">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                    <span>{{ $ordersToday }} pesanan hari ini</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm bg-gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="card-text opacity-75 mb-1">Pendapatan</p>
                        <h3 class="card-title fw-bold mb-0">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 d-flex align-items-center gap-2 small opacity-75">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                    <span>Rp{{ number_format($revenueToday, 0, ',', '.') }} hari ini</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm bg-gradient-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="card-text opacity-75 mb-1">Menu Tersedia</p>
                        <h3 class="card-title fw-bold mb-0">{{ $totalMenu }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-egg-fried fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 d-flex align-items-center gap-2 small opacity-75">
                    <i class="bi bi-people-fill"></i>
                    <span>{{ $totalEmployees }} karyawan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm bg-gradient-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="card-text opacity-75 mb-1">Status Pesanan</p>
                        <h3 class="card-title fw-bold mb-0">{{ $pendingOrders }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                </div>
                <div class="mt-3 d-flex align-items-center gap-2 small opacity-75">
                    <span class="badge bg-light text-dark me-1">{{ $settlementOrders }} lunas</span>
                    <span class="badge bg-light text-dark">{{ $cookedOrders }} selesai</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <!-- Monthly Revenue Chart -->
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-graph-up-arrow text-primary me-2"></i>Grafik Pendapatan Bulanan
                </h5>
                <span class="badge bg-primary bg-opacity-10 text-primary">6 Bulan Terakhir</span>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="280"></canvas>
            </div>
        </div>
    </div>

    <!-- Order Status Pie -->
    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pie-chart text-success me-2"></i>Status Pesanan
                </h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="280"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Today's Revenue Chart & Top Items Row -->
<div class="row g-3 mb-4">
    <!-- Hourly Revenue Today -->
    <div class="col-12 col-xl-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-bar-chart-line text-warning me-2"></i>Pendapatan Hari Ini (Per Jam)
                </h5>
                <span class="text-muted small">{{ now()->isoFormat('DD MMMM YYYY') }}</span>
            </div>
            <div class="card-body">
                <canvas id="hourlyChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Selling Items -->
    <div class="col-12 col-xl-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-trophy text-danger me-2"></i>Menu Terlaris
                </h5>
            </div>
            <div class="card-body p-0">
                @if($topItems->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($topItems as $index => $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold text-muted {{ $index < 3 ? 'text-primary' : '' }}" style="width: 24px;">
                                @if($index == 0)
                                    <i class="bi bi-trophy-fill text-warning"></i>
                                @elseif($index == 1)
                                    <i class="bi bi-award-fill text-secondary"></i>
                                @elseif($index == 2)
                                    <i class="bi bi-award-fill text-danger"></i>
                                @else
                                    #{{ $index + 1 }}
                                @endif
                            </span>
                            <div>
                                <span class="fw-semibold d-block">{{ $item->item->name ?? 'Unknown' }}</span>
                                <small class="text-muted">{{ $item->total_qty }}x terjual</small>
                            </div>
                        </div>
                        <span class="fw-semibold text-success">Rp{{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <span>Belum ada data penjualan</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="row g-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-clock-history text-primary me-2"></i>Pesanan Terbaru
                </h5>
                <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                @if($recentOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Kode</th>
                                <th>Pelanggan</th>
                                <th>Meja</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="pe-4">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-semibold">{{ $order->order_ccode }}</span>
                                </td>
                                <td>{{ $order->user->fullname ?? 'Guest' }}</td>
                                <td>Meja {{ $order->table_number }}</td>
                                <td>
                                    <span class="fw-semibold text-success">Rp{{ number_format($order->grandtotal, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if($order->status == 'settlement')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($order->status == 'cooked')
                                        <span class="badge bg-info">Selesai</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-muted small">
                                    {{ $order->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <span>Belum ada pesanan</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Card Gradients */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
    }

    .card {
        border-radius: 0.75rem;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .btn-outline-success, .btn-outline-warning, .btn-outline-info, .btn-outline-primary {
        border-width: 2px;
        transition: all 0.2s;
    }
    .btn-outline-success:hover,
    .btn-outline-warning:hover,
    .btn-outline-info:hover,
    .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // === Monthly Revenue Chart (Bar) ===
        const monthCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(monthCtx, {
            type: 'bar',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($monthlyRevenue),
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + Number(context.raw).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: { display: true, color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // === Order Status Pie Chart ===
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Lunas (Settlement)', 'Selesai (Cooked)'],
                datasets: [{
                    data: [{{ $pendingOrders }}, {{ $settlementOrders }}, {{ $cookedOrders }}],
                    backgroundColor: ['#f6c23e', '#1cc88a', '#36b9cc'],
                    borderWidth: 3,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15, usePointStyle: true }
                    }
                },
                cutout: '65%',
            }
        });

        // === Hourly Revenue Chart (Line) ===
        const hourCtx = document.getElementById('hourlyChart').getContext('2d');
        new Chart(hourCtx, {
            type: 'line',
            data: {
                labels: @json($hourlyLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($hourlyRevenue),
                    fill: true,
                    backgroundColor: 'rgba(246, 194, 62, 0.15)',
                    borderColor: '#f6c23e',
                    borderWidth: 3,
                    pointBackgroundColor: '#f6c23e',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + Number(context.raw).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { maxTicksLimit: 8 }
                    }
                }
            }
        });
    });
</script>
@endpush

