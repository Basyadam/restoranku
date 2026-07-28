@extends('admin.layouts.master')

@section('page-title', 'Manajemen Role')
@section('page-subtitle', 'Daftar role / jabatan yang tersedia')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="rounded bg-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa fa-user-tag me-2 text-primary"></i>Daftar Role</h5>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i> Tambah Role
                </a>
            </div>

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

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">No</th>
                            <th width="25%">Nama Role</th>
                            <th width="40%">Deskripsi</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $role->role_name }}</strong></td>
                            <td>{{ $role->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.roles.delete', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fa fa-user-tag fa-2x text-muted mb-2"></i>
                                <p class="mb-0">Belum ada role. Silakan tambah role baru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

