@extends('layouts.default_layout')
@section('title', 'Quản Lý Người Dùng')
@section('content')

<style>
    .nd-wrap {
        font-family: 'Be Vietnam Pro', sans-serif;
    }

    .nd-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 26px;
        flex-wrap: wrap;
        gap: 14px;
    }

    .nd-title {
        color: #C5A059;
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .nd-subtitle {
        color: #777;
        font-size: 0.85rem;
        margin-top: 4px;
    }

    .nd-search {
        display: flex;
        gap: 8px;
    }

    .nd-search-box {
        position: relative;
    }

    .nd-search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 0.85rem;
        pointer-events: none;
    }

    .nd-search input {
        background: #111;
        border: 2px solid #363636;
        color: #e0e0e0;
        border-radius: 25px;
        padding: 10px 18px 10px 38px;
        font-size: 0.88rem;
        min-width: 260px;
        transition: border-color 0.25s, background 0.25s;
    }

    .nd-search input::placeholder {
        color: #555;
    }

    .nd-search input:focus {
        outline: none;
        border-color: #C5A059;
        background: #161616;
    }

    .nd-search button {
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border: none;
        border-radius: 25px;
        padding: 10px 22px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .nd-search button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(197, 160, 89, 0.4);
    }

    /* STAT CARDS */
    .nd-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 26px;
    }

    @media (max-width: 700px) {
        .nd-stats {
            grid-template-columns: 1fr;
        }
    }

    .nd-stat-card {
        background: linear-gradient(135deg, #1a1a1a, #202020);
        border: 1px solid #2e2e2e;
        border-radius: 14px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.25s, border-color 0.25s;
    }

    .nd-stat-card:hover {
        transform: translateY(-3px);
        border-color: #C5A059;
    }

    .nd-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(197, 160, 89, 0.12);
        color: #C5A059;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .nd-stat-value {
        color: #f0f0f0;
        font-size: 1.3rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .nd-stat-label {
        color: #888;
        font-size: 0.78rem;
        margin-top: 2px;
    }

    /* TABLE */
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
        font-size: 0.82rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-table tbody td {
        padding: 14px 18px;
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
        background: rgba(197, 160, 89, 0.045);
    }

    .nd-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #C5A059, #8c6e35);
        color: #000;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(197, 160, 89, 0.25);
    }

    .nd-name {
        font-weight: 600;
        color: #f0f0f0;
    }

    .nd-email {
        color: #999;
        font-size: 0.85rem;
    }

    .nd-phone {
        color: #aaa;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .nd-phone i {
        color: #C5A059;
        font-size: 0.78rem;
    }

    .nd-no-data {
        color: #555;
        font-size: 0.82rem;
        font-style: italic;
    }

    .nd-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .nd-badge-admin {
        background: rgba(197, 160, 89, 0.15);
        border: 1px solid #C5A059;
        color: #C5A059;
    }

    .nd-badge-user {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid #444;
        color: #aaa;
    }

    .nd-date {
        color: #888;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .empty-row td {
        text-align: center;
        padding: 50px;
        color: #555;
    }

    .empty-row i {
        color: #333;
    }

    .nd-pagination {
        margin-top: 22px;
    }

    .nd-pagination nav {
        display: flex;
        justify-content: center;
    }

    .nd-alert {
        border-radius: 12px;
        padding: 13px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
    }

    .nd-alert-success {
        background: rgba(197, 160, 89, .12);
        border: 1px solid #C5A059;
        color: #C5A059;
    }

    .nd-alert-error {
        background: rgba(255, 85, 85, .1);
        border: 1px solid #ff5555;
        color: #ff8080;
    }

    .nd-actions-col {
        white-space: nowrap;
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(197, 160, 89, .35);
        cursor: pointer;
        font-size: .85rem;
        transition: all .2s;
        background: rgba(197, 160, 89, .1);
        color: #C5A059;
        text-decoration: none;
    }

    .btn-icon:hover {
        background: #C5A059;
        color: #000;
    }

    .nd-self-tag {
        color: #555;
        font-size: 0.78rem;
        font-style: italic;
    }

    /* MODAL CHI TIẾT NGƯỜI DÙNG */
    .nd-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .78);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(4px);
    }

    .nd-modal-overlay.active {
        display: flex;
    }

    .nd-modal {
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 18px;
        width: 100%;
        max-width: 480px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 32px;
        position: relative;
        animation: nd-modalIn .22s ease;
    }

    @keyframes nd-modalIn {
        from {
            opacity: 0;
            transform: translateY(-18px) scale(.97);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .nd-modal-close {
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

    .nd-modal-close:hover {
        color: #ff5555;
    }

    .nd-modal-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
        padding-bottom: 20px;
        border-bottom: 1px solid #2a2a2a;
    }

    .nd-modal-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #C5A059, #8c6e35);
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .nd-modal-name {
        color: #f0f0f0;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .nd-modal-email {
        color: #888;
        font-size: 0.85rem;
    }

    .nd-modal-info {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 24px;
    }

    .nd-modal-info-row {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .nd-modal-info-row i {
        color: #C5A059;
        font-size: 0.95rem;
        margin-top: 2px;
        width: 18px;
        flex-shrink: 0;
    }

    .nd-modal-info-row div span:first-child {
        color: #777;
        display: block;
        font-size: 0.76rem;
        margin-bottom: 2px;
    }

    .nd-modal-info-row div span:last-child {
        color: #e0e0e0;
        font-size: 0.92rem;
        font-weight: 500;
    }

    .nd-modal-section-title {
        color: #C5A059;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 14px;
        padding-top: 18px;
        border-top: 1px solid #2a2a2a;
    }

    .nd-role-form {
        display: flex;
        gap: 10px;
        margin-bottom: 14px;
    }

    .nd-role-form select {
        flex: 1;
        background: #111;
        border: 2px solid #363636;
        color: #e0e0e0;
        border-radius: 9px;
        padding: 10px 14px;
        font-size: 0.88rem;
    }

    .nd-role-form select:focus {
        outline: none;
        border-color: #C5A059;
    }

    .nd-role-form button {
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

    .nd-delete-form button {
        width: 100%;
        background: transparent;
        border: 1.5px solid #ff5555;
        color: #ff5555;
        border-radius: 9px;
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: all .2s;
    }

    .nd-delete-form button:hover {
        background: #ff5555;
        color: #fff;
    }

    .nd-modal-self-note {
        text-align: center;
        color: #666;
        font-size: 0.82rem;
        font-style: italic;
        padding: 10px 0;
    }
</style>

<div class="nd-wrap">

    <div class="nd-header">
        <div>
            <h2 class="nd-title">
                <i class="bi bi-people-fill"></i> Quản Lý Người Dùng
            </h2>
            <div class="nd-subtitle">Danh sách toàn bộ tài khoản đã đăng ký trên hệ thống</div>
        </div>

        <form class="nd-search" method="GET" action="{{ url('/nguoi-dung') }}">
            <div class="nd-search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="tim_kiem" value="{{ $tuKhoa }}" placeholder="Tìm theo tên hoặc email...">
            </div>
            <button type="submit"><i class="bi bi-funnel"></i> Tìm</button>
        </form>
    </div>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
    <div class="nd-alert nd-alert-success">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="nd-alert nd-alert-error">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
    @endif

    {{-- THỐNG KÊ NHANH --}}
    <div class="nd-stats">
        <div class="nd-stat-card">
            <div class="nd-stat-icon"><i class="bi bi-people"></i></div>
            <div>
                <div class="nd-stat-value">{{ $nguoiDungs->total() }}</div>
                <div class="nd-stat-label">Tổng tài khoản</div>
            </div>
        </div>
        <div class="nd-stat-card">
            <div class="nd-stat-icon"><i class="bi bi-shield-fill-check"></i></div>
            <div>
                <div class="nd-stat-value">{{ $nguoiDungs->where('quyen', 'Admin')->count() }}</div>
                <div class="nd-stat-label">Quản trị viên (trang này)</div>
            </div>
        </div>
        <div class="nd-stat-card">
            <div class="nd-stat-icon"><i class="bi bi-person-fill"></i></div>
            <div>
                <div class="nd-stat-value">{{ $nguoiDungs->where('quyen', '!=', 'Admin')->count() }}</div>
                <div class="nd-stat-label">Khách hàng (trang này)</div>
            </div>
        </div>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Quyền</th>
                    <th>Ngày tạo</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nguoiDungs as $nd)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="nd-avatar">{{ strtoupper(substr($nd->name, 0, 1)) }}</div>
                            <span class="nd-name">{{ $nd->name }}</span>
                        </div>
                    </td>
                    <td><span class="nd-email">{{ $nd->email }}</span></td>
                    <td>
                        @if($nd->phone)
                        <span class="nd-phone"><i class="bi bi-telephone-fill"></i> {{ $nd->phone }}</span>
                        @else
                        <span class="nd-no-data">Chưa cập nhật</span>
                        @endif
                    </td>
                    <td>
                        @if($nd->quyen == 'Admin')
                        <span class="nd-badge nd-badge-admin"><i class="bi bi-shield-fill-check"></i> Admin</span>
                        @else
                        <span class="nd-badge nd-badge-user"><i class="bi bi-person-fill"></i> Khách hàng</span>
                        @endif
                    </td>
                    <td><span class="nd-date">{{ $nd->created_at ? $nd->created_at->format('d/m/Y') : '—' }}</span></td>
                    <td class="text-center nd-actions-col">
                        @if($nd->id == Auth::id())
                        <span class="nd-self-tag">Tài khoản của bạn</span>
                        @else
                        <button class="btn-icon" title="Xem chi tiết" onclick='openNguoiDungModal(@json($nd))'>
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="6">
                        <i class="bi bi-inbox" style="font-size:2.4rem;display:block;margin-bottom:12px;"></i>
                        Không tìm thấy tài khoản nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="nd-pagination">
        {{ $nguoiDungs->links() }}
    </div>

</div>

{{-- MODAL CHI TIẾT NGƯỜI DÙNG --}}
<div class="nd-modal-overlay" id="modal-nguoidung">
    <div class="nd-modal">
        <button class="nd-modal-close" onclick="closeNguoiDungModal()">&times;</button>

        <div class="nd-modal-head">
            <div class="nd-modal-avatar" id="nd-modal-avatar"></div>
            <div>
                <div class="nd-modal-name" id="nd-modal-name"></div>
                <div class="nd-modal-email" id="nd-modal-email"></div>
            </div>
        </div>

        <div class="nd-modal-info">
            <div class="nd-modal-info-row">
                <i class="bi bi-telephone-fill"></i>
                <div><span>Số điện thoại</span><span id="nd-modal-phone"></span></div>
            </div>
            <div class="nd-modal-info-row">
                <i class="bi bi-geo-alt-fill"></i>
                <div><span>Địa chỉ</span><span id="nd-modal-address"></span></div>
            </div>
            <div class="nd-modal-info-row">
                <i class="bi bi-calendar3"></i>
                <div><span>Ngày tạo tài khoản</span><span id="nd-modal-created"></span></div>
            </div>
        </div>

        {{-- SỬA TÊN TÀI KHOẢN --}}
        <div class="nd-modal-section-title">Chỉnh sửa tên tài khoản</div>
        <form class="nd-role-form" id="nd-name-form" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="text" name="name" id="nd-modal-name-input" required style="flex: 1; background: #111; border: 2px solid #363636; color: #e0e0e0; border-radius: 9px; padding: 10px 14px; font-size: 0.88rem;">
            <button type="submit"><i class="bi bi-check2"></i> Lưu tên</button>
        </form>

        <div class="nd-modal-section-title">Đổi quyền tài khoản</div>
        <form class="nd-role-form" id="nd-role-form" method="POST" action="">
            @csrf
            <select name="quyen" id="nd-modal-quyen-select">
                <option value="Khách hàng">Khách hàng</option>
                <option value="Admin">Admin</option>
            </select>
            <button type="submit"><i class="bi bi-check2"></i> Đổi quyền</button>
        </form>

        <form class="nd-delete-form" id="nd-delete-form" method="POST" action=""
            onsubmit="return confirm('Xóa vĩnh viễn tài khoản này? Hành động không thể hoàn tác.')">
            @csrf
            <button type="submit"><i class="bi bi-trash3-fill"></i> Xóa tài khoản</button>
        </form>
    </div>
</div>

<script>
    function openNguoiDungModal(nd) {
        document.getElementById('nd-modal-avatar').innerText = nd.name.charAt(0).toUpperCase();
        document.getElementById('nd-modal-name').innerText = nd.name;
        document.getElementById('nd-modal-email').innerText = nd.email;
        document.getElementById('nd-modal-phone').innerText = nd.phone || 'Chưa cập nhật';
        document.getElementById('nd-modal-address').innerText = nd.address || 'Chưa cập nhật';
        document.getElementById('nd-modal-created').innerText = nd.created_at
            ? new Date(nd.created_at).toLocaleDateString('vi-VN')
            : '—';

        document.getElementById('nd-modal-name-input').value = nd.name;
        document.getElementById('nd-modal-quyen-select').value = nd.quyen;
        
        document.getElementById('nd-name-form').action = "{{ url('/nguoi-dung') }}/" + nd.id + "/sua-ten";
        document.getElementById('nd-role-form').action = "{{ url('/nguoi-dung') }}/" + nd.id + "/quyen";
        document.getElementById('nd-delete-form').action = "{{ url('/nguoi-dung') }}/" + nd.id + "/xoa";

        document.getElementById('modal-nguoidung').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeNguoiDungModal() {
        document.getElementById('modal-nguoidung').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.getElementById('modal-nguoidung').addEventListener('click', function(e) {
        if (e.target === this) closeNguoiDungModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeNguoiDungModal();
    });
</script>
@endsection