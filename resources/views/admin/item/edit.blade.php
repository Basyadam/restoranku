@extends('admin.layouts.master')

@section('page-title', 'Edit Menu')
@section('page-subtitle', 'Silakan isi form dengan benar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="rounded bg-light p-4">
            <h5 class="mb-4"><i class="fa fa-pencil me-2 text-primary"></i>Edit Data Menu</h5>

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

            <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="categories_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('categories_id', $item->categories_id) == $cat->id ? 'selected' : '' }}>{{ $cat->cat_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $item->price) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ old('stok', $item->stok ?? 0) }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $item->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    @if($item->img)
                        <div class="mb-2">
                            <img src="{{ asset('img_item_upload/' . $item->img) }}" alt="{{ $item->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;" onerror="this.style.display='none'">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Format: jpeg, png, jpg, gif. Maks: 2MB</small>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ $item->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.items') }}" class="btn btn-secondary">
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

