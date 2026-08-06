@extends('layouts.default_layout')

@section('title', 'Giỏ Hàng - Kingsman Vietnam')

@section('content')
<style>
    .cart-container {
        padding: 50px 0 70px;
        min-height: 60vh;
    }

    .cart-breadcrumb {
        color: #777;
        font-size: 0.82rem;
        margin-bottom: 14px;
    }

    .cart-breadcrumb a {
        color: #999;
        text-decoration: none;
        transition: color 0.2s;
    }

    .cart-breadcrumb a:hover {
        color: #C5A059;
    }

    .cart-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 32px;
    }

    .cart-title {
        font-family: 'Playfair Display', serif;
        color: #C5A059;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: 1px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cart-count {
        color: #888;
        font-size: 0.9rem;
    }

    .cart-alert {
        background: rgba(197, 160, 89, .12);
        border: 1px solid #C5A059;
        color: #C5A059;
        border-radius: 12px;
        padding: 13px 22px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.92rem;
    }

    /* CART ITEM CARD */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .cart-item-card {
        background: linear-gradient(135deg, #1a1a1a, #191919);
        border: 1px solid #2c2c2c;
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
    }

    .cart-item-card:hover {
        border-color: #C5A059;
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
    }

    .cart-item-img {
        width: 84px;
        height: 84px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #333;
        flex-shrink: 0;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .cart-item-name {
        font-weight: 600;
        color: #f0f0f0;
        font-size: 1rem;
        margin-bottom: 8px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .cart-item-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .size-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 12px;
        background: rgba(197, 160, 89, 0.12);
        border: 1px solid #C5A059;
        border-radius: 20px;
        color: #C5A059;
        font-size: 0.76rem;
        font-weight: 600;
    }

    .unit-price {
        color: #999;
        font-size: 0.82rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #111;
        border: 1px solid #333;
        border-radius: 25px;
        padding: 5px 8px;
        flex-shrink: 0;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: #C5A059;
        font-size: 1.05rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        line-height: 1;
    }

    .qty-btn:hover {
        background: #C5A059;
        color: #000;
    }

    .qty-num {
        font-weight: 700;
        font-size: 0.95rem;
        color: #f0f0f0;
        min-width: 18px;
        text-align: center;
    }

    .subtotal-col {
        text-align: right;
        min-width: 130px;
        flex-shrink: 0;
    }

    .subtotal-label {
        color: #777;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    .subtotal-price {
        color: #C5A059;
        font-weight: 700;
        font-size: 1.08rem;
        white-space: nowrap;
    }

    .remove-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1.5px solid #444;
        color: #888;
        background: transparent;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .remove-btn:hover {
        background: #ff4444;
        border-color: #ff4444;
        color: #fff;
    }

    .cart-continue {
        margin-top: 24px;
    }

    .btn-continue {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 26px;
        border-radius: 25px;
        border: 2px solid #C5A059;
        color: #C5A059;
        background: transparent;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.3s;
    }

    .btn-continue:hover {
        background: #C5A059;
        color: #000;
    }

    /* SUMMARY CARD */
    .summary-card {
        background: linear-gradient(150deg, #1a1a1a 0%, #161616 100%);
        border: 1px solid #333;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.45);
        position: sticky;
        top: 20px;
    }

    .summary-header {
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        padding: 20px 26px;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .summary-body {
        padding: 26px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 11px 0;
        color: #999;
        font-size: 0.9rem;
    }

    .summary-row span:last-child {
        font-weight: 600;
        color: #e0e0e0;
    }

    .summary-divider {
        border: none;
        border-top: 1px dashed #333;
        margin: 6px 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 18px 0 4px;
        margin-top: 6px;
        border-top: 2px solid #C5A059;
    }

    .summary-total span:first-child {
        color: #C5A059;
        font-weight: 700;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .summary-total span:last-child {
        color: #C5A059;
        font-weight: 700;
        font-size: 1.45rem;
        font-family: 'Playfair Display', serif;
    }

    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 15px;
        margin-top: 22px;
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.6px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 8px 25px rgba(197, 160, 89, 0.35);
    }

    .btn-checkout:hover {
        background: linear-gradient(135deg, #d4b36a, #C5A059);
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(197, 160, 89, 0.55);
        color: #000;
    }

    .summary-secure {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        color: #666;
        font-size: 0.76rem;
        margin-top: 16px;
    }

    /* EMPTY CART */
    .empty-cart {
        text-align: center;
        padding: 90px 20px;
    }

    .empty-cart-icon {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: rgba(197, 160, 89, 0.08);
        border: 1px solid rgba(197, 160, 89, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .empty-cart-icon i {
        font-size: 2.8rem;
        color: #C5A059;
        opacity: 0.7;
    }

    .empty-cart h4 {
        color: #f0f0f0;
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        margin-bottom: 10px;
    }

    .empty-cart p {
        color: #777;
        font-size: 0.95rem;
        margin-bottom: 28px;
    }

    @media (max-width: 767px) {
        .cart-item-card {
            flex-wrap: wrap;
        }

        .subtotal-col {
            text-align: left;
            margin-left: auto;
        }
    }
</style>

<div class="cart-container container">

    <div class="cart-breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a> / <span style="color:#C5A059;">Giỏ hàng</span>
    </div>

    <div class="cart-header">
        <h2 class="cart-title"><i class="bi bi-cart3"></i> Giỏ Hàng</h2>
        @if(!empty($gioHang))
        <span class="cart-count">{{ count($gioHang) }} sản phẩm trong giỏ</span>
        @endif
    </div>

    @if(session('success'))
    <div class="cart-alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    @if(empty($gioHang))
    <div class="empty-cart">
        <div class="empty-cart-icon">
            <i class="bi bi-cart-x"></i>
        </div>
        <h4>Giỏ hàng của bạn đang trống</h4>
        <p>Hãy khám phá bộ sưu tập vest cao cấp của Kingsman.</p>
        <a href="{{ route('sanpham.index') }}" class="btn-continue">
            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
        </a>
    </div>
    @else
    <div class="row g-4">
        {{-- DANH SÁCH SẢN PHẨM --}}
        <div class="col-lg-8">
            <div class="cart-items">
                @foreach($gioHang as $key => $item)
                <div class="cart-item-card">
                    <img src="{{ asset('images/' . $item['hinh_anh']) }}"
                        class="cart-item-img" alt="{{ $item['ten_sp'] }}" />

                    <div class="cart-item-info">
                        <div class="cart-item-name">{{ $item['ten_sp'] }}</div>
                        <div class="cart-item-meta">
                            <span class="size-badge"><i class="bi bi-rulers"></i> {{ $item['size'] }}</span>
                            <span class="unit-price">{{ number_format($item['gia'], 0, ',', '.') }} VNĐ / sản phẩm</span>
                        </div>
                    </div>

                    <div class="qty-control">
                        <a href="{{ route('giohang.update', ['key' => $key, 'type' => -1]) }}" class="qty-btn">−</a>
                        <span class="qty-num">{{ $item['so_luong'] }}</span>
                        <a href="{{ route('giohang.update', ['key' => $key, 'type' => 1]) }}" class="qty-btn">+</a>
                    </div>

                    <div class="subtotal-col">
                        <div class="subtotal-label">Thành tiền</div>
                        <div class="subtotal-price">{{ number_format($item['gia'] * $item['so_luong'], 0, ',', '.') }} VNĐ</div>
                    </div>

                    <a href="{{ route('giohang.remove', ['key' => $key]) }}"
                        class="remove-btn"
                        title="Xóa sản phẩm"
                        onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                        <i class="bi bi-trash3"></i>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="cart-continue">
                <a href="{{ route('sanpham.index') }}" class="btn-continue">
                    <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>

        {{-- TÓM TẮT ĐƠN HÀNG --}}
        <div class="col-lg-4">
            <div class="summary-card">
                <div class="summary-header">
                    <i class="bi bi-receipt"></i> Tóm Tắt Đơn Hàng
                </div>
                <div class="summary-body">
                    <div class="summary-row">
                        <span>Tạm tính</span>
                        <span>{{ number_format($tongTien, 0, ',', '.') }} VNĐ</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển</span>
                        <span>30.000 VNĐ</span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-total">
                        <span>Thanh toán</span>
                        <span>{{ number_format($tongTien + 30000, 0, ',', '.') }} VNĐ</span>
                    </div>

                    <a href="{{ route('giohang.thanhtoan') }}" class="btn-checkout">
                        <i class="bi bi-bag-check-fill me-2"></i> Tiến Hành Thanh Toán
                    </a>

                    <div class="summary-secure">
                        <i class="bi bi-shield-check"></i> Thanh toán an toàn & bảo mật
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- MODAL THANH TOÁN THÀNH CÔNG --}}
<div class="modal fade" id="modalThanhToan" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#1a1a1a; border:2px solid #C5A059; border-radius:16px;">
            <div class="modal-body text-center" style="padding:40px;">
                <i class="bi bi-check-circle-fill" style="font-size:4rem; color:#C5A059; display:block; margin-bottom:20px;"></i>
                <h4 style="color:#C5A059; font-family:'Playfair Display',serif; margin-bottom:15px;">Thanh Toán Thành Công!</h4>
                <p style="color:#aaa; margin-bottom:25px;">Cảm ơn bạn đã mua hàng tại Kingsman. Chúng tôi sẽ liên hệ xác nhận đơn hàng sớm nhất.</p>

                <div style="background:#111; border-radius:10px; padding:20px; margin-bottom:25px; text-align:left;">
                    @foreach($gioHang as $item)
                    <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #2a2a2a;">
                        <img src="{{ asset('images/' . $item['hinh_anh']) }}"
                            style="width:50px; height:50px; object-fit:cover; border-radius:8px;" />
                        <div style="flex:1;">
                            <div style="color:#e0e0e0; font-weight:600; font-size:0.9rem;">{{ $item['ten_sp'] }}</div>
                            <div style="color:#888; font-size:0.8rem;">Size: {{ $item['size'] }} × {{ $item['so_luong'] }}</div>
                        </div>
                        <div style="color:#C5A059; font-weight:700; font-size:0.9rem;">
                            {{ number_format($item['gia'] * $item['so_luong'], 0, ',', '.') }} VNĐ
                        </div>
                    </div>
                    @endforeach
                    <div style="display:flex; justify-content:space-between; padding-top:15px;">
                        <span style="color:#aaa;">Tổng cộng:</span>
                        <span style="color:#C5A059; font-weight:700; font-size:1.1rem;">
                            {{ number_format($tongTien + 30000, 0, ',', '.') }} VNĐ
                        </span>
                    </div>
                </div>

                <a href="{{ route('sanpham.index') }}" class="btn-checkout" style="display:inline-flex; width:auto; padding:12px 35px;">
                    <i class="bi bi-bag"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalThanhToan');
        if (modal && modal.dataset.autoShow === 'true') {
            new bootstrap.Modal(modal).show();
        }
    });

    const btnThanhToan = document.getElementById('btnThanhToan');
    if (btnThanhToan) {
        btnThanhToan.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Thanh toán thành công! Cảm ơn bạn đã mua hàng tại Kingsman.');
            window.location.href = "{{ route('giohang.checkout') }}";
        });
    }
</script>
@endsection