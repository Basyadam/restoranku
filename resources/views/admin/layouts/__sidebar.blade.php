@php
    $user = Auth::user();
@endphp

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <h4 class="pt-2">
                        <a href="{{ url('index') }}" class="">Restoranku</a>
                    </h4>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <!-- Theme toggle code here -->
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders') }}" class='sidebar-link'>
                        <i class="bi bi-cart-fill"></i>
                        <span>Kelola Pesanan</span>
                    </a>
                </li>
                @auth
                @if(Auth::user()->role && Auth::user()->role->role_name == 'admin')


                    <li class="sidebar-item {{ request()->routeIs('admin.items*') ? 'active' : '' }}">
                        <a href="{{ route('admin.items') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-text-fill"></i>
                            <span>Daftar Menu</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories') }}" class='sidebar-link'>
                            <i class="bi bi-tags-fill"></i>
                            <span>Manajemen Kategori</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a href="{{ route('menu') }}" class='sidebar-link' target="_blank">
                        <i class="bi bi-shop"></i>
                        <span>Lihat Menu Customer</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <form method="POST" action="{{ route('admin.logout') ?? '#' }}">
                        @csrf
                        <a href="#" class='sidebar-link' onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</div>