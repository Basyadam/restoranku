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
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-sign-in-alt me-1"></i> Login
                    </a>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Daftar Akun Baru</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item active text-primary">Buat akun untuk mulai memesan</li>
        </ol>
    </div>
    <!-- Page Header End -->

    <!-- Register Form Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="rounded bg-light p-5">
                        <div class="text-center mb-4">
                            <i class="fa fa-user-plus fa-4x text-primary mb-3"></i>
                            <h4 class="fw-bold">Buat Akun Baru</h4>
                            <p class="text-muted">Daftar untuk mulai menikmati layanan kami</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small mb-2">USERNAME <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user text-primary"></i></span>
                                        <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small mb-2">NAMA LENGKAP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-id-card text-primary"></i></span>
                                        <input type="text" name="fullname" class="form-control" placeholder="Nama Lengkap" value="{{ old('fullname') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small mb-2">DAFTAR SEBAGAI <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user-tag text-primary"></i></span>
                                        <select name="role_id" class="form-select" required>
                                            <option value="">-- Pilih Role --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->role_name) }} - {{ $role->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small mb-2">EMAIL <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-envelope text-primary"></i></span>
                                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small mb-2">NO. TELEPON <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-phone text-primary"></i></span>
                                        <input type="text" name="phone" class="form-control" placeholder="No. Telepon" value="{{ old('phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small mb-2">PASSWORD <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-lock text-primary"></i></span>
                                        <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small mb-2">KONFIRMASI PASSWORD <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-lock text-primary"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                    <i class="fa fa-user-plus me-2"></i> DAFTAR
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <span class="text-muted">Sudah punya akun? </span>
                            <a href="{{ route('login') }}" class="text-primary fw-bold">
                                <i class="fa fa-sign-in-alt me-1"></i>Masuk disini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form End -->

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

