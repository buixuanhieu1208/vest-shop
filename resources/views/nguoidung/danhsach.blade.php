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
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .nd-title {
        color: #C5A059;
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nd-search {
        display: flex;
        gap: 8px;
    }

    .nd-search input {
        background: #111;
        border: 2px solid #363636;
        color: #e0e0e0;
        border-radius: 25px;
        padding: 9px 18px;
        font-size: 0.88rem;
        min-width: 240px;
        transition: border-color 0.25s;
    }

    .nd-search input:focus {
        outline: none;
        border-color: #C5A059;
    }

    .nd-search button {
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border: none;
        border-radius: 25px;
        padding: 9px 20px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.25s;
    }

    .nd-search button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(197, 160, 89, 0.4);
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
    }

    .nd-name {
        font-weight: 600;
        color: #f0f0f0;
    }

    .nd-email {
        color: #999;
        font-size: 0.85rem;
    }

    .nd-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.3px;
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
    }

    .empty-row td {
        text-align: center;
        padding: 40px;
        color: #555;
    }

    .nd-pagination {
        margin-top: 20px;
    }

    .nd-pagination nav {
        display: flex;
        justify-content: center;
    }
</style>

<div class="nd-wrap">

    <div class="nd-header">
        <h2 class="nd-title">
            <i class="bi bi-people-fill"></i> Quản Lý Người Dùng
        </h2>

        <form class="nd-search" method="GET" action="{{ url('/nguoi-dung') }}">
            <input type="text" name="tim_kiem" value="{{ $tuKhoa }}" placeholder="Tìm theo tên hoặc email...">
            <button type="submit"><i class="bi bi-search"></i> Tìm</button>
        </form>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nguoiDungs as $nd)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="nd-avatar">{{ strtoupper(substr($nd->name, 0, 1)) }}</div>
                            <span class="nd-name">{{ $nd->name }}</span>
                        </div>
                    </td>
                    <td><span class="nd-email">{{ $nd->email }}</span></td>
                    <td>
                        @if($nd->quyen == 'Admin')
                        <span class="nd-badge nd-badge-admin"><i class="bi bi-shield-fill-check"></i> Admin</span>
                        @else
                        <span class="nd-badge nd-badge-user"><i class="bi bi-person-fill"></i> Khách hàng</span>
                        @endif
                    </td>
                    <td><span class="nd-date">{{ $nd->created_at ? $nd->created_at->format('d/m/Y') : '—' }}</span></td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="4">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
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
@endsection
