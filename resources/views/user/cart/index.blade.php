@extends('layouts.user')

@section('title', 'Keranjang Belanja Anda')

@push('styles')
<style>
    .cart-container { padding-top: 120px; max-width: 1100px; margin: auto; }
    .cart-table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .cart-table th, .cart-table td { padding: 1.25rem; text-align: left; border-bottom: 1px solid #eee; }
    .cart-table th { font-size: 0.9rem; text-transform: uppercase; color: #888; }
    .product-info { display: flex; align-items: center; }
    .product-info img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 1.5rem; }
    .remove-btn { color: #e74c3c; background: none; border: none; cursor: pointer; font-size: 1.5rem; }
    .cart-summary { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .checkout-btn { display: block; width: 100%; padding: 1rem; background: var(--success); color: white; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 1rem; transition: background-color 0.3s; border: none; cursor: pointer; }
    .checkout-btn:hover { background: #3aa14d; }
    .empty-cart { text-align: center; padding: 4rem; background: #fff; border-radius: 8px; }
    .cart-item-quantity { display: flex; align-items: center; }
    .quantity-btn { width: 30px; height: 30px; background: #f1f1f1; border: 1px solid #ddd; cursor: pointer; }
    .quantity-input { width: 50px; text-align: center; border: 1px solid #ddd; border-left: none; border-right: none; height: 30px; }
</style>
@endpush

@section('content')
<div class="container cart-container">
    <h1 style="font-size: 2.5rem; font-weight: bold; text-align: center; margin-bottom: 2.5rem;">Keranjang Belanja</h1>

    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Keranjang Anda masih kosong.</h2>
            <p style="color: #777; margin-bottom: 2rem;">Sepertinya Anda belum menambahkan menu apa pun.</p>
            <a href="{{ route('menu.index') }}" class="checkout-btn" style="background: var(--primary); display: inline-block; width: auto;">Lihat Menu</a>
        </div>
    @else
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: flex-start;">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th colspan="2">Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr data-id="{{ $item->id }}">
                        <td>
                            <img src="{{ $item->menuItem->image ? asset('storage/' . $item->menuItem->image) : 'https://via.placeholder.com/100' }}" alt="{{ $item->menuItem->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <span style="font-weight: 600;">{{ $item->menuItem->name }}</span>
                        </td>
                        <td>Rp {{ number_format($item->menuItem->price, 0, ',', '.') }}</td>
                        <td>
                            <div class="cart-item-quantity">
                                <button type="button" class="quantity-btn decrease-qty" data-id="{{ $item->id }}">-</button>
                                <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1" data-id="{{ $item->id }}">
                                <button type="button" class="quantity-btn increase-qty" data-id="{{ $item->id }}">+</button>
                            </div>
                        </td>
                        <td class="subtotal">Rp {{ number_format($item->menuItem->price * $item->quantity, 0, ',', '.') }}</td>
                        <td>
                            <button class="remove-btn" data-id="{{ $item->id }}">&times;</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-summary">
                <h2 class="summary-title">Ringkasan Pesanan</h2>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span class="summary-price" id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Pajak (12%)</span>
                    <span class="summary-price" id="tax">Rp {{ number_format($taxAmount, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-total">Total</span>
                    <span class="summary-price summary-total" id="grand-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="checkout-btn">
                        Check Out
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartTable = document.querySelector('.cart-table');
    if (!cartTable) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // --- FUNGSI-FUNGSI UTAMA ---

    function debounce(func, delay = 500) {
        let timeoutId;
        return function(...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(this, args);
            }, delay);
        };
    }

    function updateView(data) {
        // Update subtotal per baris jika datanya ada
        if (data.item_id && data.item_subtotal) {
            const row = document.querySelector(`tr[data-id="${data.item_id}"]`);
            if (row) {
                row.querySelector('.subtotal').textContent = data.item_subtotal;
            }
        }
        
        // Update Ringkasan Pesanan
        document.getElementById('subtotal').textContent = data.subtotal;
        document.getElementById('tax').textContent = data.taxAmount;
        document.getElementById('grand-total').textContent = data.grandTotal;
    }

    function updateCart(cartItemId, quantity) {
        fetch(`/cart/update/${cartItemId}`, {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json'},
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateView(data);
            } else {
                alert(data.message || 'Gagal memperbarui keranjang.');
            }
        })
        .catch(error => console.error('Error updating cart:', error));
    }

    /**
     * FUNGSI untuk menghapus item dari keranjang.
     */
    function removeCartItem(cartItemId) {
        fetch(`/cart/destroy/${cartItemId}`, {
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hapus baris dari tabel untuk feedback instan
                const row = document.querySelector(`tr[data-id="${cartItemId}"]`);
                if (row) {
                    row.remove();
                }
                
                // Update total harga di ringkasan pesanan
                updateView(data);

                // Jika keranjang menjadi kosong, reload halaman untuk menampilkan pesan
                if (data.cart_is_empty) {
                    window.location.reload();
                }
            } else {
                alert(data.message || 'Gagal menghapus item.');
            }
        })
        .catch(error => console.error('Error removing item:', error));
    }


    // --- EVENT LISTENERS ---

    const debouncedUpdateCart = debounce(updateCart);

    cartTable.addEventListener('click', function(e) {
        const target = e.target;
        const row = target.closest('tr');
        if (!row) return;

        const cartItemId = row.dataset.id;
        const input = row.querySelector('.quantity-input');
        
        if (target.classList.contains('increase-qty')) {
            let quantity = parseInt(input.value) + 1;
            input.value = quantity;
            updateCart(cartItemId, quantity);
        }

        if (target.classList.contains('decrease-qty')) {
            let quantity = parseInt(input.value);
            if (quantity > 1) {
                quantity--;
                input.value = quantity;
                updateCart(cartItemId, quantity);
            }
        }

        /**
         * KONDISI untuk Menangani klik pada tombol hapus.
         */
        if (target.classList.contains('remove-btn')) {
            // Tampilkan dialog konfirmasi sederhana
            if (confirm('Anda yakin ingin menghapus item ini dari keranjang?')) {
                removeCartItem(cartItemId);
            }
        }
    });

    cartTable.addEventListener('input', function(e) {
        const target = e.target;
        if (target.classList.contains('quantity-input')) {
            const row = target.closest('tr');
            const cartItemId = row.dataset.id;
            let quantity = parseInt(target.value);

            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                target.value = 1;
            }
            debouncedUpdateCart(cartItemId, quantity);
        }
    });
});
</script>
@endpush