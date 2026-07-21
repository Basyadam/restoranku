@extends('customer.layouts.master')

@section('content')
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @php
                $cartItems = session('cart', []);
            @endphp

            @if(empty($cartItems))
                <div id="cart-empty" class="text-center py-5">
                    <h4 class="mb-3">Keranjang belanja kosong</h4>
                    <p class="text-muted mb-4">Belum ada menu yang Anda pilih.</p>
                    <a href="{{ route('menu') }}" class="btn btn-primary">Lihat Menu</a>
                </div>
            @else
                <div id="cart-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Gambar</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cartItems as $itemId => $item)
                                @php
                                    $itemTotal = $item['price'] * $item['qty'];
                                    $total += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('img_item_upload/' . $item['image']) }}" class="img-fluid rounded-circle" style="width: 80px;" alt="" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=300&q=80';">
                                    </td>
                                    <td>
                                        <p class="mb-0">{{ $item['name'] ?? 'Menu' }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                    <div class="input-group quantity mt-1" style="width: 100px;"><div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" data-item-id="{{ $item['id'] }}" data-change="-1">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input id="qty-{{ $item['id'] }}" type="text" class="form-control form-control-sm text-center border-0 bg-transparent" value="{{ $item['qty'] }}" readonly>
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border" data-item-id="{{ $item['id'] }}" data-change="1">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span id="total-{{ $item['id'] }}">Rp{{ number_format($itemTotal, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm rounded-circle bg-light border mt-1" onclick="if(confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {removeItemFromCart('{{ $item['id'] }}');}">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row g-4 justify-content-end mt-3">
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded p-4">
                            <h4 class="mb-4">Total Pesanan</h4>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal</span>
                                <span id="cart-subtotal">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>PPN (10%)</span>
                                <span id="cart-ppn">Rp{{ number_format($total * 0.1, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-3">
                                <strong>Total</strong>
                                <strong id="cart-grand-total">Rp{{ number_format($total + ($total * 0.1), 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('checkout') }}" class="btn border-secondary py-3 text-primary text-uppercase">Lanjut ke Pembayaran</a>
                        </div>
                    </div>
                </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Override handler untuk quantity buttons - gunakan data-item-id
            $('#cart-content').on('click', '.btn-minus, .btn-plus', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var $btn = $(this);
                var itemId = $btn.data('item-id');
                var change = parseInt($btn.data('change'));
                
                if (!itemId) {
                    var $row = $btn.closest('tr');
                    itemId = $row.find('input[id^="qty-"]').attr('id').replace('qty-', '');
                    if (!itemId) return false;
                }

                var qtyInput = document.getElementById('qty-' + itemId);
                if (!qtyInput) return false;

                var currentQty = parseInt(qtyInput.value) || 0;
                var newQty = currentQty + change;

                if (newQty < 0 || newQty === 0) {
                    if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                        removeItemFromCart(itemId);
                    }
                    return false;
                }

                // Kirim permintaan AJAX
                fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: itemId, qty: newQty })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        qtyInput.value = newQty;
                        document.getElementById('total-' + itemId).textContent = data.item_total_formatted;
                        document.getElementById('cart-subtotal').textContent = data.subtotal_formatted;
                        document.getElementById('cart-ppn').textContent = data.ppn_formatted;
                        document.getElementById('cart-grand-total').textContent = data.grand_total_formatted;
                    } else {
                        alert('Gagal memperbarui jumlah item.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui keranjang.');
                });

                return false;
            });
        });

        function removeItemFromCart(itemId) {
            fetch("{{ route('cart.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: itemId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.cart_empty) {
                        location.reload();
                    } else {
                        var row = document.getElementById('qty-' + itemId).closest('tr');
                        if (row) row.remove();
                        var subEl = document.getElementById('cart-subtotal');
                        var ppnEl = document.getElementById('cart-ppn');
                        var totalEl = document.getElementById('cart-grand-total');
                        if (subEl) subEl.textContent = data.subtotal_formatted;
                        if (ppnEl) ppnEl.textContent = data.ppn_formatted;
                        if (totalEl) totalEl.textContent = data.grand_total_formatted;
                    }
                } else {
                    alert('Gagal menghapus item dari keranjang.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus item.');
            });
        }
    </script>
@endsection

