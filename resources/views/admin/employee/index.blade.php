@extends('admin.layouts.master')

@section('page-title', 'Manajemen Karyawan')
@section('page-subtitle', 'Daftar karyawan restoran')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="rounded bg-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa fa-users me-2 text-primary"></i>Daftar Karyawan</h5>
                <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i> Tambah Karyawan
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="employeeTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Username</th>
                            <th width="20%">Nama Lengkap</th>
                            <th width="20%">Email</th>
                            <th width="12%">No. Telepon</th>
                            <th width="12%">Role</th>
                            <th width="16%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $employee->username }}</strong></td>
                            <td>{{ $employee->fullname }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>
                                <span class="badge bg-info">{{ $employee->role->role_name ?? '-' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.employees.delete', $employee->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
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
                            <td colspan="7" class="text-center py-4">
                                <i class="fa fa-users fa-2x text-muted mb-2"></i>
                                <p class="mb-0">Belum ada karyawan. Silakan tambah karyawan baru.</p>
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

