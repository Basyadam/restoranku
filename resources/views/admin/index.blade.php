@extends('admin.layouts.master')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Selamat datang, ' . (Auth::user()->fullname ?? 'Admin') . '!')

@section('content')
<!-- Stats Cards Start -->
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
        <div class="rounded bg-light p-4 text-center">
            <div class="mb-3">
                <i class="fa fa-shopping-cart fa-3x text-primary"></i>
            </div>
            <h5 class="text-muted">Total Pesanan</h5>
            <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="rounded bg-light p-4 text-center">
            <div class="mb-3">
                <i class="fa fa-calendar-day fa-3x text-success"></i>
            </div>
            <h5 class="text-muted">Pesanan Hari Ini</h5>
            <h2 class="fw-bold mb-0">{{ $ordersToday }}</h2>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="rounded bg-light p-4 text-center">
            <div class="mb-3">
                <i class="fa fa-utensils fa-3x text-warning"></i>
            </div>
            <h5 class="text-muted">Jumlah Menu</h5>
            <h2 class="fw-bold mb-0">{{ $totalMenu }}</h2>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="rounded bg-light p-4 text-center">
            <div class="mb-3">
                <i class="fa fa-money-bill-wave fa-3x text-info"></i>
            </div>
            <h5 class="text-muted">Total Revenue</h5>
            <h2 class="fw-bold mb-0">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>
    </div>
</div>
<!-- Stats Cards End -->

<!-- Additional Info Row -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="rounded bg-light p-4">
            <h5 class="mb-3"><i class="fa fa-info-circle me-2 text-primary"></i>Ringkasan</h5>
            <div class="d-flex justify-content-between mb-2">
                <span>Total Karyawan:</span>
                <strong>{{ $totalEmployees }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Revenue Hari Ini:</span>
                <strong class="text-success">Rp{{ number_format($revenueToday, 0, ',', '.') }}</strong>
            </div>
            <hr>
            <a href="{{ route('admin.orders') }}" class="btn btn-primary btn-sm w-100">
                <i class="fa fa-arrow-right me-1"></i> Lihat Semua Pesanan
            </a>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="rounded bg-light p-4">
            <h5 class="mb-3"><i class="fa fa-cog me-2 text-primary"></i>Akses Cepat</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.items') }}" class="btn btn-outline-success btn-sm">
                    <i class="fa fa-utensils me-1"></i> Kelola Menu
                </a>
                <a href="{{ route('admin.categories') }}" class="btn btn-outline-warning btn-sm">
                    <i class="fa fa-tags me-1"></i> Kelola Kategori
                </a>
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-info btn-sm">
                    <i class="fa fa-clipboard-list me-1"></i> Kelola Pesanan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

