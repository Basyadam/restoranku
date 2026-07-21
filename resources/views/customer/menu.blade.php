@extends('customer.layouts.master')

@section('content')
     <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-3">
                            <div class="col-lg">
                                <div class="row g-4 justify-content-center">
                                    
                                @foreach ($items as $item)
                                <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                              <img src="{{ asset('img_item_upload/' . $item->img) }}" class="img-fluid w-100 rounded-top" alt="{{ $item->name }}" onerror="this.onerror=null;this.src='{{ $item->img }}';">
                                            </div>
                                            <div class="text-white px-3 py-1 rounded position-absolute
                                            @if($item->category && $item->category->cat_name == 'Makanan')
                                                bg-warning
                                            @elseif($item->category && $item->category->cat_name == 'Minuman')
                                                bg-info
                                            @else
                                                bg-primary
                                            @endif" style="top: 10px; left: 10px;">
                                                {{ $item->category?->cat_name ?? 'Lainnya' }}
                                    </div>
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4 class="text-limited">{{ $item->name }}</h4>
                                        <p class="text-limited">{{ $item->description }}</p>
<div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold mb-0">{{ 'Rp' . number_format($item->price, 0, ',', '.') }}</p>
                                            <button type="button" class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart-btn" data-item-id="{{ $item->id }}">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Fruits Shop End-->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.add-to-cart-btn').on('click', function() {
            var $btn = $(this);
            var itemId = $btn.data('item-id');
            var originalText = $btn.html();

            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Menambahkan...');

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    item_id: itemId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $btn.html('<i class="fa fa-check me-2"></i> Ditambahkan');
                        setTimeout(function() {
                            $btn.html(originalText).prop('disabled', false);
                        }, 1500);
                    } else {
                        alert('Gagal menambahkan item: ' + response.message);
                        $btn.html(originalText).prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menambahkan ke keranjang.');
                    $btn.html(originalText).prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
