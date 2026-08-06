@extends('layouts.default_layout')
@section('title', 'Quản Lý Đơn Hàng')
@section('content')

<style>
    .dh-wrap {
        font-family: 'Be Vietnam Pro', sans-serif;
    }

    .dh-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dh-title {
        color: #C5A059;
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dh-filters {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .dh-filters select,
    .dh-filters input {
        background: #111;
        border: 2px solid #363636;
        color: #e0e0e0;
        border-radius: 25px;
        padding: 8px 16px;
        font-size: 0.85rem;
        transition: border-color 0.25s;
    }

    .dh-filters select:focus,
    .dh-filters input:focus {
        outline: none;
        border-color: #C5A059;
    }

    .dh-filters button {
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border: none;
        border-radius: 25px;
        padding: 8px 18px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.25s;
    }

    .dh-filters button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(197, 160, 89, 0.4);
    }

    .sp-alert {
        background: rgba(197, 160, 89, .12);
        border: 1px solid #C5A059;
        color: #C5A059;
        border-radius: 10px;
        padding: 12px 20px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-table {
        background: #1a1a1a;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #2e2e2e;
    }

    .admin-table table {
        width: 100%;
        color: #e0e0e0;
        margin: 0;
        border-collapse: collapse;
    }

    .admin-table thead {
        background: linear-gradient(135deg, #C5A059, #8c6e35);
    }

    .admin-table thead th {
        padding: 14px 18px;
        font-weight: 700;
        border: none;
        color: #000;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-table tbody td {
        padding: 13px 18px;
        border-bottom: 1px solid #242424;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .admin-table tbody tr:last-child td {
        border-bottom: none;
    }

    .admin-table tbody tr {
        transition: background 0.15s;
    }

    .admin-table tbody tr:hover {
        background: rgba(197, 160, 89, 0.04);
    }

    .dh-ma {
        color: #C5A059;
        font-weight: 700;
    }

    .dh-khach {
        font-weight: 600;
        color: #f0f0f0;
    }

    .dh-khach-sub {
        color: #888;
        font-size: 0.82rem;
    }

    .dh-tien {
        color: #C5A059;
        font-weight: 700;
        white-space: nowrap;
    }

    .dh-date {
        color: #999;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .badge-status {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-status.st-cho { background: rgba(240,173,78,.15); color: #f0ad4e; border: 1px solid #f0ad4e; }
    .badge-status.st-giao { background: rgba(91,192,222,.15); color: #5bc0de; border: 1px solid #5bc0de; }
    .badge-status.st-xong { background: rgba(92,184,92,.15); color: #5cb85c; border: 1px solid #5cb85c; }
    .badge-status.st-huy { background: rgba(255,85,85,.15); color: #ff5555; border: 1px solid #ff5555; }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        font-size: .82rem;
        transition: all .2s;
        background: rgba(197, 160, 89, .15);
        color: #C5A059;
        border: 1px solid rgba(197, 160, 89, .35);
    }

    .btn-icon:hover {
        background: #C5A059;
        color: #000;
    }

    .empty-row td {
        text-align: center;
        padding: 40px;
        color: #555;
    }

    /* MODAL CHI TIẾT */
    .dh-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.78);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(4px);
    }

    .dh-modal-overlay.active { display: flex; }

    .dh-modal {
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 18px;
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 30px;
        position: relative;
        animation: modalIn .22s ease;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: translateY(-18px) scale(.97); }
        to { opacity: 1; transform: none; }
    }

    .dh-modal-close {
        position: absolute;
        top: 16px;
        right: 18px;
        background: none;
        border: none;
        color: #666;
        font-size: 1.4rem;
        cursor: pointer;
        line-height: 1;
        transition: color .2s;
    }

    .dh-modal-close:hover { color: #ff5555; }

    .dh-modal h3 {
        color: #C5A059;
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        margin: 0 0 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dh-modal-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 20px;
        margin-bottom: 20px;
        padding-bottom: 18px;
        border-bottom: 1px solid #2a2a2a;
        font-size: 0.88rem;
    }

    .dh-modal-info div span:first-child {
        color: #888;
        display: block;
        font-size: 0.78rem;
        margin-bottom: 2px;
    }

    .dh-modal-info div span:last-child {
        color: #e0e0e0;
        font-weight: 600;
    }

    .dh-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #242424;
    }

    .dh-item:last-child { border-bottom: none; }

    .dh-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #333;
    }

    .dh-item-info { flex: 1; }

    .dh-item-name {
        color: #f0f0f0;
        font-weight: 600;
        font-size: 0.88rem;
    }

    .dh-item-meta {
        color: #888;
        font-size: 0.8rem;
    }

    .dh-item-price {
        color: #C5A059;
        font-weight: 700;
        font-size: 0.88rem;
        white-space: nowrap;
    }

    .dh-modal-total {
        display: flex;
        justify-content: space-between;
        padding-top: 16px;
        margin-top: 6px;
        border-top: 2px solid #C5A059;
    }

    .dh-modal-total span:first-child {
        color: #C5A059;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.95rem;
    }

    .dh-modal-total span:last-child {
        color: #C5A059;
        font-weight: 700;
        font-size: 1.15rem;
    }

    .dh-status-form {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .dh-status-form select {
        flex: 1;
        background: #111;
        border: 2px solid #363636;
        color: #e0e0e0;
        border-radius: 9px;
        padding: 10px 14px;
        font-size: 0.9rem;
    }

    .dh-status-form button {
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border: none;
        border-radius: 9px;
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        white-space: nowrap;
    }
</style>

<div class="dh-wrap">

    <div class="dh-header">
        <h2 class="dh-title"><i class="bi bi-receipt-cutoff"></i> Quản Lý Đơn Hàng</h2>

        <form class="dh-filters" method="GET" action="{{ url('/thong-ke/don-hang') }}">
            <input type="text" name="tim_kiem" value="{{ $tuKhoa }}" placeholder="Tìm mã đơn, tên, email...">
            <select name="trang_thai" onchange="this.form.submit()">
                <option value="">-- Tất cả trạng thái --</option>
                @foreach($danhSachTrangThai as $tt)
                <option value="{{ $tt }}" {{ $trangThai == $tt ? 'selected' : '' }}>{{ $tt }}</option>
                @endforeach
            </select>
            <button type="submit"><i class="bi bi-search"></i> Lọc</button>
        </form>
    </div>

    @if(session('success'))
    <div class="sp-alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Ngày bán</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donHangs as $dh)
                <tr>
                    <td><span class="dh-ma">#{{ $dh->id }}</span></td>
                    <td>
                        <div class="dh-khach">{{ $dh->user->name ?? 'Khách vãng lai' }}</div>
                        <div class="dh-khach-sub">{{ $dh->user->email ?? '—' }}</div>
                    </td>
                    <td><span class="dh-date">{{ $dh->ngay_ban ? $dh->ngay_ban->format('d/m/Y H:i') : '—' }}</span></td>
                    <td><span class="dh-tien">{{ number_format($dh->thanh_toan, 0, ',', '.') }} ₫</span></td>
                    <td>
                        @php
                        $cls = match($dh->trang_thai) {
                            'Đang giao' => 'st-giao',
                            'Hoàn Thành' => 'st-xong',
                            'Đã hủy' => 'st-huy',
                            default => 'st-cho',
                        };
                        @endphp
                        <span class="badge-status {{ $cls }}">{{ $dh->trang_thai }}</span>
                    </td>
                    <td class="text-center">
                        <button class="btn-icon" title="Xem chi tiết" onclick='openChiTietModal(@json($dh))'>
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="6">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
                        Chưa có đơn hàng nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $donHangs->links() }}
    </div>
</div>

{{-- MODAL CHI TIẾT ĐƠN HÀNG --}}
<div class="dh-modal-overlay" id="modal-chitiet">
    <div class="dh-modal">
        <button class="dh-modal-close" onclick="closeChiTietModal()">&times;</button>
        <h3><i class="bi bi-receipt"></i> Chi Tiết Đơn Hàng <span id="ct-ma"></span></h3>

        <div class="dh-modal-info">
            <div><span>Khách hàng</span><span id="ct-khach"></span></div>
            <div><span>Ngày bán</span><span id="ct-ngay"></span></div>
            <div style="grid-column: 1 / -1;"><span>Địa chỉ giao hàng</span><span id="ct-diachi"></span></div>
        </div>

        <div id="ct-items"></div>

        <div class="dh-modal-total">
            <span>Tổng thanh toán</span>
            <span id="ct-tongtien"></span>
        </div>

        <form class="dh-status-form" id="ct-status-form" method="POST" action="">
            @csrf
            <select name="trang_thai" id="ct-status-select">
                <option value="Chờ xử lý">Chờ xử lý</option>
                <option value="Đang giao">Đang giao</option>
                <option value="Hoàn Thành">Hoàn Thành</option>
                <option value="Đã hủy">Đã hủy</option>
            </select>
            <button type="submit"><i class="bi bi-check2"></i> Cập nhật</button>
        </form>
    </div>
</div>

<script>
    var BASE_IMG_URL = "{{ asset('images/') }}/";

    function openChiTietModal(dh) {
        document.getElementById('ct-ma').innerText = '#' + dh.id;
        document.getElementById('ct-khach').innerText = (dh.user ? dh.user.name : 'Khách vãng lai');
        document.getElementById('ct-ngay').innerText = dh.ngay_ban ? new Date(dh.ngay_ban).toLocaleString('vi-VN') : '—';
        document.getElementById('ct-diachi').innerText = dh.dia_chi || '—';
        document.getElementById('ct-tongtien').innerText = Number(dh.thanh_toan).toLocaleString('vi-VN') + ' ₫';

        var itemsHtml = '';
        (dh.chi_tiet_hoa_dons || []).forEach(function(item) {
            var ten = item.san_pham ? item.san_pham.ten_sp : 'Sản phẩm đã xóa';
            var anh = item.san_pham ? BASE_IMG_URL + item.san_pham.hinh_anh : '';
            itemsHtml += '<div class="dh-item">' +
                '<img src="' + anh + '" alt="">' +
                '<div class="dh-item-info">' +
                    '<div class="dh-item-name">' + ten + '</div>' +
                    '<div class="dh-item-meta">Size: ' + item.size + ' × ' + item.so_luong + '</div>' +
                '</div>' +
                '<div class="dh-item-price">' + Number(item.tong_tien).toLocaleString('vi-VN') + ' ₫</div>' +
            '</div>';
        });
        document.getElementById('ct-items').innerHTML = itemsHtml || '<p style="color:#555;text-align:center;padding:20px 0;">Không có sản phẩm</p>';

        document.getElementById('ct-status-select').value = dh.trang_thai;
        document.getElementById('ct-status-form').action = "{{ url('/thong-ke/don-hang') }}/" + dh.id + "/trang-thai";

        document.getElementById('modal-chitiet').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeChiTietModal() {
        document.getElementById('modal-chitiet').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.getElementById('modal-chitiet').addEventListener('click', function(e) {
        if (e.target === this) closeChiTietModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeChiTietModal();
    });
</script>
@endsection