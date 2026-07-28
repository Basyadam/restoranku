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
            {{ $user->fullname ?? 'User' }}
        </span>
        @auth
        <!-- <a href="{{ route('menu') }}" class="btn btn-sm btn-outline-primary" target="_blank">
            <i class="bi bi-eye me-1"></i> Lihat Menu
        </a>
        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form> -->
        @endauth
    </div>
</header>

