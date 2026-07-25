@include('customer.layouts.__header')

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar start (Customer style) -->
        <div class="container-fluid fixed-top">
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                        <h1 class="text-primary display-6">Restoranku</h1>
                        <small class="text-muted">Admin Panel</small>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarAdmin">
                        <div class="navbar-nav mx-auto">
                            <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fa fa-chart-pie me-1"></i>Dashboard
                            </a>
                            <a href="{{ route('admin.orders') }}" class="nav-item nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                                <i class="fa fa-clipboard-list me-1"></i>Pesanan
                            </a>
                            @auth
                            @if(Auth::user()->role && Auth::user()->role->role_name == 'admin')
                            <a href="{{ route('admin.items') }}" class="nav-item nav-link {{ request()->routeIs('admin.items*') ? 'active' : '' }}">
                                <i class="fa fa-utensils me-1"></i>Menu
                            </a>
                            <a href="{{ route('admin.categories') }}" class="nav-item nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                                <i class="fa fa-tags me-1"></i>Kategori
                            </a>
                            @endif
                            @endauth
                        </div>
                        <div class="d-flex m-3 me-0 align-items-center">
                            @auth
                            <span class="me-3 text-muted small">
                                <i class="fa fa-user-circle me-1"></i>{{ Auth::user()->fullname ?? 'Admin' }}
                            </span>
                            <a href="{{ route('menu') }}" class="btn btn-outline-primary btn-sm me-2" target="_blank">
                                <i class="fa fa-eye me-1"></i>Menu
                            </a>
                            <form method="POST" action="{{ route('admin.logout') ?? '#' }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-sign-out-alt me-1"></i>Logout
                                </button>
                            </form>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

        <!-- Page Header Start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">@yield('page-title', 'Admin Panel')</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item active text-primary">@yield('page-subtitle', 'Kelola restoran Anda')</li>
            </ol>
        </div>
        <!-- Page Header End -->

        <!-- Admin Content Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
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

                @yield('content')
            </div>
        </div>
        <!-- Admin Content End -->

        <!-- Footer Start -->
        @include('customer.layouts.__footer')
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/customer/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('assets/customer/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/customer/lib/lightbox/js/lightbox.min.js') }}"></script>
        <script src="{{ asset('assets/customer/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/customer/js/main.js') }}"></script>

        @yield('js')
    </body>
</html>

