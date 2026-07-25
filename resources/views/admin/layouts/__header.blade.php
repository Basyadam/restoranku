@php
    $user = Auth::user();
@endphp
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
    <div class="d-flex justify-content-end align-items-center gap-3 mt-2">
        <span class="text-muted">
            <i class="bi bi-person-circle me-1"></i>
            {{ $user->name ?? 'Admin' }}
        </span>
        @auth
        <a href="{{ route('menu') }}" class="btn btn-sm btn-outline-primary" target="_blank">
            <i class="bi bi-eye me-1"></i> Lihat Menu
        </a>
        @endauth
    </div>
</header>

