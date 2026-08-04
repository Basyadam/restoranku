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
    <div class="container-fluid py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="auth-card row g-0">

                        <!-- Side Banner -->
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="auth-side h-100">
                                <div class="auth-side-content text-center text-white px-3">
                                    <div class="auth-side-icon">
                                        <i class="fa fa-user-plus"></i>
                                    </div>
                                    <h3 class="fw-bold text-white mb-2">Bergabunglah!</h3>
                                    <p class="text-white-50 mb-3">Daftar sekarang dan nikmati layanan terbaik dari Restoranku.</p>
                                    <div class="text-start d-inline-block">
                                        <p class="text-white mb-2"><i class="fa fa-check-circle me-2 text-secondary"></i>Pesanan lebih mudah</p>
                                        <p class="text-white mb-2"><i class="fa fa-check-circle me-2 text-secondary"></i>Menu terlengkap</p>
                                        <p class="text-white mb-0"><i class="fa fa-check-circle me-2 text-secondary"></i>Layanan cepat</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="col-lg-8">
                            <div class="auth-form-wrap">
                                <div class="text-center mb-4">
                                    <div class="d-lg-none mb-3">
                                        <i class="fa fa-user-plus fa-4x text-primary"></i>
                                    </div>
                                    <h4 class="auth-title mb-1">Buat Akun Baru</h4>
                                    <p class="auth-subtitle mb-0">Lengkapi data di bawah untuk mulai menikmati layanan kami</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                        <div class="d-flex">
                                            <i class="fa fa-exclamation-circle me-2 fs-5 flex-shrink-0"></i>
                                            <div class="small">
                                                <div class="fw-bold mb-1">Mohon periksa kembali data Anda:</div>
                                                @foreach ($errors->all() as $error)
                                                    <div>&bull; {{ $error }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="auth-label form-label mb-2">Username <span class="text-danger">*</span></label>
                                            <div class="input-group auth-input-group">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required>
                                            </div>
                                            @error('username')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fullname" class="auth-label form-label mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                                            <div class="input-group auth-input-group">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                                <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('fullname') }}" required>
                                            </div>
                                            @error('fullname')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="role_id" class="auth-label form-label mb-2">Daftar Sebagai <span class="text-danger">*</span></label>
                                            <div class="input-group auth-input-group">
                                                <span class="input-group-text"><i class="fa fa-user-tag"></i></span>
                                                <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Role --</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->role_name) }} - {{ $role->description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('role_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="auth-label form-label mb-2">Email <span class="text-danger">*</span></label>
                                            <div class="input-group auth-input-group">
                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="auth-label form-label mb-2">No. Telepon <span class="text-danger">*</span></label>
                                            <div class="input-group auth-input-group">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="No. Telepon" value="{{ old('phone') }}" required>
                                            </div>
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="auth-label form-label mb-2">Password <span class="text-danger">*</span></label>
                                            <div class="input-group auth-input-group position-relative">
                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 6 karakter" required>
                                                <button type="button" class="auth-toggle-password" onclick="togglePassword('password', this)" tabindex="-1">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                            <!-- Strength meter -->
                                            <div class="strength-meter">
                                                <div class="strength-bar" id="strengthBar"></div>
                                            </div>
                                            <div class="strength-label text-muted" id="strengthLabel"></div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="auth-label form-label mb-2">Konfirmasi Password <span class="text-danger">*</span></label>
                                            <div class="input-group auth-input-group position-relative">
                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                                                <button type="button" class="auth-toggle-password" onclick="togglePassword('password_confirmation', this)" tabindex="-1">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="password-match-msg" id="matchMsg"></div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn auth-btn w-100 mt-2" id="registerBtn">
                                        <span class="btn-text"><i class="fa fa-user-plus me-2"></i> DAFTAR</span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>Memproses...
                                        </span>
                                    </button>
                                </form>

                                <div class="auth-divider my-4">SUDAH PUNYA AKUN?</div>

                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="auth-link">
                                        <i class="fa fa-sign-in-alt me-1"></i>Masuk disini
                                    </a>
                                </div>
                            </div>
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

        // Password strength meter
        var passwordInput = document.getElementById('password');
        var strengthBar = document.getElementById('strengthBar');
        var strengthLabel = document.getElementById('strengthLabel');

        passwordInput.addEventListener('input', function () {
            var val = this.value;
            var score = 0;

            if (val.length >= 6) score += 1;
            if (val.length >= 8) score += 1;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score += 1;
            if (/\d/.test(val)) score += 1;
            if (/[^A-Za-z0-9]/.test(val)) score += 1;

            var levels = [
                { label: '', color: '', width: '0%' },
                { label: 'Lemah', color: '#dc3545', width: '25%' },
                { label: 'Cukup', color: '#ffc107', width: '50%' },
                { label: 'Baik', color: '#81C408', width: '75%' },
                { label: 'Kuat', color: '#198754', width: '100%' }
            ];

            var level = levels[score];
            strengthBar.style.width = level.width;
            strengthBar.style.background = level.color;

            if (val.length === 0) {
                strengthLabel.textContent = '';
            } else if (score <= 2) {
                strengthLabel.innerHTML = '<span style="color:' + level.color + ';">' + level.label + '</span>';
            } else {
                strengthLabel.innerHTML = '<span style="color:' + level.color + ';">' + level.label + '</span>';
            }
        });

        // Real-time password match check
        var passField = document.getElementById('password');
        var confirmField = document.getElementById('password_confirmation');
        var matchMsg = document.getElementById('matchMsg');

        function checkMatch() {
            var pass = passField.value;
            var confirm = confirmField.value;

            if (confirm.length === 0) {
                matchMsg.innerHTML = '';
            } else if (pass === confirm) {
                matchMsg.innerHTML = '<i class="fa fa-check-circle me-1"></i>Password cocok';
                matchMsg.style.color = '#198754';
            } else {
                matchMsg.innerHTML = '<i class="fa fa-times-circle me-1"></i>Password tidak cocok';
                matchMsg.style.color = '#dc3545';
            }
        }

        passField.addEventListener('input', checkMatch);
        confirmField.addEventListener('input', checkMatch);

        // Loading state saat submit
        document.getElementById('registerForm').addEventListener('submit', function () {
            var btn = document.getElementById('registerBtn');
            var text = btn.querySelector('.btn-text');
            var loading = btn.querySelector('.btn-loading');
            btn.disabled = true;
            text.classList.add('d-none');
            loading.classList.remove('d-none');
        });
    </script>
</body>
</html>

