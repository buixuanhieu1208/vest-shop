@extends('layouts.default_layout')

@section('title', 'Sản Phẩm - Kingsman Vietnam')

@section('sidebar_danhmuc')
<ul class="list-unstyled mb-0">
    <li>
        <a href="{{ url('/san-pham') }}"
            class="d-block px-2 py-2 text-decoration-none fw-semibold border-bottom"
            style="color:#d4af37;">
            <i class="bi bi-grid-fill me-1"></i> Tất cả
        </a>
    </li>
    @foreach($danhMucs as $dm)
    <li>
        <a href="{{ url('/san-pham?danh_muc=' . $dm->id) }}"
            class="d-block px-2 py-2 text-decoration-none border-bottom sidebar-link"
            style="color:#ccc; font-size:0.9rem;">
            <i class="bi bi-chevron-right me-1"></i>{{ $dm->ten_danh_muc }}
        </a>
    </li>
    @endforeach
</ul>
@endsection

@section('content')
<style>
    .products-section {
        padding: 40px 0;
        background: linear-gradient(to bottom, #0a0a0a, #000);
        min-height: 100vh;
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-header h2 {
        font-family: 'Playfair Display', serif;
        color: #d4af37;
        font-size: 2.2rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .section-header p {
        color: #a0a0a0;
        font-size: 1rem;
    }

    .product-card {
        background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
        border: 1px solid #333;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* Lớp phủ link toàn bộ card - cho phép click bất kỳ đâu trên card để vào chi tiết */
    .product-card-stretched-link {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    /* Nút Chi Tiết cần nổi lên trên lớp phủ để giữ hiệu ứng hover riêng của nó */
    .product-actions {
        position: relative;
        z-index: 2;
    }

    .product-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 50px rgba(212, 175, 55, 0.4);
        border-color: #d4af37;
    }

    .product-img-wrap {
        position: relative;
        overflow: hidden;
        height: 350px;
        background: #0f0f0f;
    }

    .product-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-img-wrap img {
        transform: scale(1.15);
    }

    .badge-hot {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        color: #fff;
        padding: 6px 16px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 2px;
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        animation: pulse 2s infinite;
        z-index: 2;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .product-info {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background: linear-gradient(to bottom, #1a1a1a, #0f0f0f);
    }

    .product-info h3 {
        color: #f0f0f0;
        font-size: 1.05rem;
        font-weight: 600;
        margin-bottom: 12px;
        min-height: 45px;
        line-height: 1.4;
        transition: color 0.3s;
    }

    .product-card:hover .product-info h3 {
        color: #d4af37;
    }

    .product-meta {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #333;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #888;
        font-size: 0.82rem;
    }

    .meta-item i {
        color: #d4af37;
    }

    .price {
        margin-bottom: 18px;
    }

    .price .current {
        color: #d4af37;
        font-size: 1.3rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }

    .product-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-detail {
        flex: 1;
        background: transparent;
        border: 2px solid #d4af37;
        color: #d4af37;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        text-align: center;
        font-size: 0.85rem;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-detail:hover {
        background: #d4af37;
        color: #000;
        transform: translateY(-2px);
    }

    .btn-cart {
        background: linear-gradient(135deg, #d4af37, #c19b2f);
        border: none;
        color: #000;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.5);
        color: #000;
    }

    /* CHỌN SIZE + THÊM GIỎ HÀNG */
    .cart-form {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        position: relative;
        z-index: 2;
    }

    .size-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        color-scheme: dark;
        flex: 0 0 100px;
        background-color: #0f0f0f;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath fill='%23d4af37' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        border: 1.5px solid #3a3a3a;
        color: #ccc;
        border-radius: 8px;
        padding: 0 28px 0 14px;
        height: 40px;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        outline: none;
        transition: all 0.25s ease;
    }

    .size-select:hover {
        border-color: #d4af37;
        color: #d4af37;
        background-color: #0f0f0f;
    }

    .size-select:focus,
    .size-select:focus-visible {
        border-color: #d4af37;
        outline: none;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        background-color: #0f0f0f;
    }

    .size-select option {
        background-color: #1a1a1a;
        color: #f0f0f0;
    }

    .size-select:focus {
        border-color: #d4af37;
    }

    .btn-add-cart {
        flex: 1;
        background: linear-gradient(135deg, #d4af37, #c19b2f);
        border: none;
        color: #000;
        height: 40px;
        padding: 0 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(212, 175, 55, 0.45);
        filter: brightness(1.08);
    }

    .btn-add-cart:active {
        transform: translateY(0);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d4af37;
        opacity: 0.5;
        margin-bottom: 15px;
        display: block;
    }

    .empty-state h3 {
        color: #f0f0f0;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #888;
    }

    /* Sidebar dark */
    .card {
        background: #1a1a1a !important;
        border-color: #333 !important;
    }

    .card-header.bg-dark {
        border-bottom: 1px solid #d4af37 !important;
        color: #d4af37 !important;
        letter-spacing: 2px;
    }

    .sidebar-link:hover {
        color: #d4af37 !important;
    }

    /* THÔNG BÁO THÊM GIỎ HÀNG */
    .toast-success {
        position: fixed;
        top: 90px;
        right: 20px;
        z-index: 1080;
        background: rgba(40, 167, 69, 0.15);
        border: 1px solid #28a745;
        color: #75d98b;
        padding: 14px 22px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        animation: fadeOut 0.4s ease 2.6s forwards;
    }

    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateX(20px);
        }
    }
</style>

{{-- THANH TÌM KIẾM --}}
<div style="background:#0a0a0a; padding: 20px 0; border-bottom: 1px solid #222;">

    @if(session('success'))
    <div class="toast-success">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    <div class="container">
        <form method="GET" action="{{ url('/san-pham') }}" class="d-flex gap-2 justify-content-center">
            {{-- Giữ filter danh mục nếu đang lọc --}}
            @if(request('danh_muc'))
            <input type="hidden" name="danh_muc" value="{{ request('danh_muc') }}">
            @endif

            <input type="text" name="tim_kiem"
                value="{{ request('tim_kiem') }}"
                placeholder="Tìm theo tên, chất liệu, xuất xứ..."
                style="background:#1a1a1a; border: 1px solid #444; border-radius:25px;
                          color:#fff; padding: 10px 20px; width: 400px; outline:none;
                          transition: border-color 0.3s;"
                onfocus="this.style.borderColor='#d4af37'"
                onblur="this.style.borderColor='#444'">

            <button type="submit"
                style="background: linear-gradient(135deg, #d4af37, #c19b2f);
                           color:#000; border:none; border-radius:25px;
                           padding: 10px 25px; font-weight:700; cursor:pointer;
                           transition: all 0.3s;"
                onmouseover="this.style.transform='translateY(-2px)'"
                onmouseout="this.style.transform='translateY(0)'">
                <i class="bi bi-search me-1"></i> Tìm kiếm
            </button>

            @if(request('tim_kiem'))
            <a href="{{ url('/san-pham') . (request('danh_muc') ? '?danh_muc='.request('danh_muc') : '') }}"
                style="background:transparent; border: 1px solid #666; border-radius:25px;
                      color:#aaa; padding: 10px 20px; text-decoration:none;
                      transition: all 0.3s; display:flex; align-items:center; gap:6px;"
                onmouseover="this.style.borderColor='#d4af37'; this.style.color='#d4af37'"
                onmouseout="this.style.borderColor='#666'; this.style.color='#aaa'">
                <i class="bi bi-x-circle"></i> Xoá
            </a>
            @endif
        </form>

        {{-- Hiển thị kết quả tìm kiếm --}}
        @if(request('tim_kiem'))
        <div class="text-center mt-3" style="color:#a0a0a0; font-size:0.9rem;">
            Kết quả cho "<span style="color:#d4af37;">{{ request('tim_kiem') }}</span>"
            — tìm thấy <span style="color:#d4af37;">{{ $sanPhams->count() }}</span> sản phẩm
        </div>
        @endif
    </div>
</div>

<section class="products-section">
    <div class="container-fluid px-0">

        <div class="section-header">
            <h2><i class="bi bi-grid-3x3-gap-fill"></i>
                {{ request('danh_muc') ? ($danhMucs->find(request('danh_muc'))->ten_danh_muc ?? 'Sản Phẩm') : 'Tất Cả Sản Phẩm' }}
            </h2>
            <p>Khám phá bộ sưu tập vest cao cấp — {{ $sanPhams->count() }} sản phẩm</p>
        </div>

        @if($sanPhams->count() > 0)
        <div class="row g-4">
            @foreach($sanPhams as $sp)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="product-card">
                    <a href="{{ url('/san-pham/' . $sp->id) }}" class="product-card-stretched-link" aria-label="Xem chi tiết {{ $sp->ten_sp }}"></a>
                    <div class="product-img-wrap">
                        @if($sp->hinh_anh)
                        <img src="{{ asset('images/' . $sp->hinh_anh) }}" alt="{{ $sp->ten_sp }}">
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-dark" style="height:350px;">
                            <i class="bi bi-image text-secondary" style="font-size:3rem;"></i>
                        </div>
                        @endif

                        @if($sp->gia > 3000000)
                        <span class="badge-hot">🔥 HOT</span>
                        @endif
                    </div>

                    <div class="product-info">
                        <h3>{{ $sp->ten_sp }}</h3>

                        @if($sp->xuat_xu || $sp->chat_lieu)
                        <div class="product-meta">
                            @if($sp->xuat_xu)
                            <div class="meta-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>{{ $sp->xuat_xu }}</span>
                            </div>
                            @endif
                            @if($sp->chat_lieu)
                            <div class="meta-item">
                                <i class="bi bi-stars"></i>
                                <span>{{ $sp->chat_lieu }}</span>
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="price">
                            <span class="current">{{ number_format($sp->gia, 0, ',', '.') }} ₫</span>
                        </div>

                        <div class="product-actions">
                            <a href="{{ url('/san-pham/' . $sp->id) }}" class="btn-detail" style="flex:1;">
                                <i class="bi bi-info-circle-fill"></i> Chi Tiết
                            </a>
                        </div>

                        <form action="{{ route('giohang.add') }}" method="GET" class="cart-form">
                            <input type="hidden" name="id" value="{{ $sp->id }}">
                            <input type="hidden" name="url" value="{{ url()->full() }}">
                            <select name="size" class="size-select" required>
                                <option value="" selected disabled>Chọn size</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                            <button type="submit" class="btn-add-cart">
                                <i class="bi bi-cart-plus-fill"></i> Thêm Giỏ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h3>Không tìm thấy sản phẩm</h3>
            <p>Vui lòng thử danh mục khác hoặc xem tất cả sản phẩm</p>
            <a href="{{ url('/san-pham') }}" class="btn-detail mt-3" style="display:inline-flex;">
                <i class="bi bi-arrow-left"></i> Xem Tất Cả
            </a>
        </div>
        @endif

    </div>
</section>
@endsection