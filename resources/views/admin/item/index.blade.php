@extends('admin.layouts.master')

@section('page-title', 'Manajemen Menu')
@section('page-subtitle', 'Daftar menu restoran')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="rounded bg-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa fa-utensils me-2 text-primary"></i>Daftar Menu</h5>
                <a href="{{ route('admin.items.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i> Tambah Menu
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($items->isEmpty())
                <div class="text-center py-5">
                    <i class="fa fa-utensils fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada menu. Silakan tambah menu baru.</p>
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="itemTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th width="20%">Nama</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Stok</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                <img src="{{ $item->img ? asset('img_item_upload/' . $item->img) : 'https://via.placeholder.com/60?text=No+Image' }}"
                                     alt="{{ $item->name }}"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                                     onerror="this.src='https://via.placeholder.com/60?text=No+Image'">
                            </td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>{{ $item->category->cat_name ?? '-' }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->stok ?? 0 }}</td>
                            <td class="text-center">
                                @if($item->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.items.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#itemTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endsection

