@include('customer.layouts.__header')

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="{{ route('menu') }}" class="navbar-brand">
                    <h1 class="text-primary display-6">Restoranku</h1>
                    <p class="text-secondary mb-0" style="font-size: 12px;">Pilihan Lezat di Ujung Jari Anda!</p>
                </a>
                <div class="d-flex m-3 me-0 align-items-center">
                    <a href="{{ route('menu') }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fa fa-arrow-left me-1"></i> Kembali ke Menu
                    </a>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Masuk ke Akun</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item active text-primary">Silakan login untuk mengelola restoran</li>
        </ol>
    </div>
    <!-- Page Header End -->

    <!-- Login Form Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="rounded bg-light p-5">
                        <div class="text-center mb-4">
                            <i class="fa fa-user-circle fa-4x text-primary mb-3"></i>
                            <h4 class="fw-bold">Selamat Datang Kembali</h4>
                            <p class="text-muted">Silakan masuk dengan akun Anda</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>
                                @foreach ($errors->all() as $error)
                                    <span>{{ $error }}</span>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small mb-2">USERNAME</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-user text-primary"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small mb-2">PASSWORD</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-lock text-primary"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                    <i class="fa fa-sign-in-alt me-2"></i> MASUK
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center mb-4">
                            <span class="text-muted">Belum punya akun? </span>
                            <a href="{{ route('register') }}" class="text-primary fw-bold">
                                <i class="fa fa-user-plus me-1"></i>Daftar disini
                            </a>
                        </div>

                        <div class="p-3 bg-white rounded border">
                            <h6 class="fw-bold text-center mb-3"><i class="fa fa-info-circle me-1 text-primary"></i> AKUN DEMO</h6>
                            <div class="row g-2 small">
                                <div class="col-4">
                                    <div class="p-2 bg-light rounded text-center">
                                        <strong class="text-primary">Admin</strong><br>
                                        <span class="text-muted">admin / password</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 bg-light rounded text-center">
                                        <strong class="text-success">Kasir</strong><br>
                                        <span class="text-muted">kasir / password</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 bg-light rounded text-center">
                                        <strong class="text-info">Chef</strong><br>
                                        <span class="text-muted">chef / password</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Form End -->

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
    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>
</html>
