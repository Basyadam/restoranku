@extends('admin.layouts.master')

@section('page-title', 'Edit Role')
@section('page-subtitle', 'Silakan isi form dengan benar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="rounded bg-light p-4">
            <h5 class="mb-4"><i class="fa fa-pencil me-2 text-primary"></i>Edit Data Role</h5>

            @if ($errors->any())
            <div class="alert alert-danger">
                <h6><i class="fa fa-exclamation-triangle"></i> Terjadi Kesalahan</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Role <span class="text-danger">*</span></label>
                    <input type="text" name="role_name" class="form-control" value="{{ old('role_name', $role->role_name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $role->description) }}</textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.roles') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

