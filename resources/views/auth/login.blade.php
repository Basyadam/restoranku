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
    <div class="container-fluid py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="auth-card row g-0">

                        <!-- Side Banner -->
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="auth-side h-100">
                                <div class="auth-side-content text-center text-white">
                                    <div class="auth-side-icon">
                                        <i class="fa fa-utensils"></i>
                                    </div>
                                    <h3 class="fw-bold text-white mb-2">Selamat Datang!</h3>
                                    <p class="text-white-50 mb-4">Kelola restoran Anda dengan mudah, cepat, dan menyenangkan bersama Restoranku.</p>
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3 d-inline-block">
                                        <i class="fa fa-quote-left text-white me-2"></i>
                                        <span class="text-white">Pilihan Lezat di Ujung Jari Anda!</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="col-lg-7">
                            <div class="auth-form-wrap">
                                <div class="text-center mb-4">
                                    <div class="d-lg-none mb-3">
                                        <i class="fa fa-user-circle fa-4x text-primary"></i>
                                    </div>
                                    <h4 class="auth-title mb-1">Selamat Datang Kembali 👋</h4>
                                    <p class="auth-subtitle mb-0">Silakan masuk dengan akun Anda untuk melanjutkan</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-exclamation-circle me-2 fs-5"></i>
                                            <div>
                                                @foreach ($errors->all() as $error)
                                                    <div class="small">{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-check-circle me-2 fs-5"></i>
                                            <span>{{ session('success') }}</span>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                                    @csrf

                                    <div class="mb-3">
                                        <label for="username" class="auth-label form-label mb-2">Username</label>
                                        <div class="input-group auth-input-group">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                                        </div>
                                        @error('username')
                                            <div class="invalid-feedback d-block">
                                                <i class="fa fa-info-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="password" class="auth-label form-label mb-0">Password</label>
                                            <a href="#" class="small auth-link" title="Silakan hubungi administrator untuk mereset password" onclick="return false;"><i class="fa fa-key me-1"></i>Lupa password?</a>
                                        </div>
                                        <div class="input-group auth-input-group position-relative">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                                            <button type="button" class="auth-toggle-password" onclick="togglePassword('password', this)" tabindex="-1">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                <i class="fa fa-info-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label small text-muted" for="remember">
                                                Ingat saya
                                            </label>
                                        </div>
                                        <a href="{{ route('register') }}" class="small fw-bold auth-link">
                                            Buat akun baru <i class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>

                                    <button type="submit" class="btn auth-btn w-100" id="loginBtn">
                                        <span class="btn-text"><i class="fa fa-sign-in-alt me-2"></i> MASUK</span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>Memproses...
                                        </span>
                                    </button>
                                </form>

                                <div class="auth-divider my-4">ATAU</div>

                                <!-- Demo Accounts -->
                                <div class="text-center mb-3">
                                    <h6 class="fw-bold text-dark mb-1"><i class="fa fa-info-circle me-1 text-primary"></i> Akun Demo</h6>
                                    <span class="text-muted small">Klik kartu untuk mengisi otomatis</span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="demo-account" onclick="fillDemo('admin','password')" title="Klik untuk isi otomatis">
                                            <span class="demo-icon" style="background: #81C408;"><i class="fa fa-user-shield"></i></span>
                                            <div class="fw-bold small text-dark">Admin</div>
                                            <div class="text-muted" style="font-size: 11px;">admin / password</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="demo-account" onclick="fillDemo('kasir','password')" title="Klik untuk isi otomatis">
                                            <span class="demo-icon" style="background: #198754;"><i class="fa fa-cash-register"></i></span>
                                            <div class="fw-bold small text-dark">Kasir</div>
                                            <div class="text-muted" style="font-size: 11px;">kasir / password</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="demo-account" onclick="fillDemo('chef','password')" title="Klik untuk isi otomatis">
                                            <span class="demo-icon" style="background: #0dcaf0;"><i class="fa fa-utensils"></i></span>
                                            <div class="fw-bold small text-dark">Chef</div>
                                            <div class="text-muted" style="font-size: 11px;">chef / password</div>
                                        </div>
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

        // Toggle password visibility
        function togglePassword(inputId, btn) {
            var input = document.getElementById(inputId);
            var icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Fill demo account
        function fillDemo(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
            var usernameField = document.getElementById('username');
            var passwordField = document.getElementById('password');
            usernameField.classList.remove('is-invalid');
            passwordField.classList.remove('is-invalid');
            // Fokus ke tombol login
            document.getElementById('loginBtn').focus();
            // Efek highlight singkat
            usernameField.style.transition = 'box-shadow 0.5s ease';
            usernameField.style.boxShadow = '0 0 0 0.25rem rgba(129,196,8,.25)';
            setTimeout(function () {
                usernameField.style.boxShadow = '';
            }, 800);
        }

        // Loading state saat submit
        document.getElementById('loginForm').addEventListener('submit', function () {
            var btn = document.getElementById('loginBtn');
            var text = btn.querySelector('.btn-text');
            var loading = btn.querySelector('.btn-loading');
            btn.disabled = true;
            text.classList.add('d-none');
            loading.classList.remove('d-none');
        });
    </script>
</body>
</html>

