<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Restoranku</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/iconly.css') }}">

    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Sidebar -->
        @include('admin.layouts.__sidebar')

        <!-- Main Content -->
        <div id="main">
            <!-- Header -->
            @include('admin.layouts.__header')

            <div class="page-heading">
                <h3>@yield('page-title', 'Dashboard')</h3>
                <p class="text-muted">@yield('page-subtitle', '')</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show ms-3 me-3" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show ms-3 me-3" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="page-content">
                @yield('content')
            </div>

            <!-- Footer -->
            @include('admin.layouts.__footer')
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="{{ asset('assets/admin/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/compiled/js/app.js') }}"></script>

    <!-- Chart.js -->
    <script src="{{ asset('assets/admin/extensions/chart.js/chart.umd.js') }}"></script>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('table.table').each(function() {
                if ($(this).find('tbody tr').length > 1 && !$(this).attr('id')) {
                    $(this).DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                        }
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>

