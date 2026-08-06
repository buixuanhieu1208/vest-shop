@extends('layouts.default_layout')
@section('title', 'Thống Kê Doanh Thu')
@section('content')

<style>
    .tk-wrap {
        font-family: 'Be Vietnam Pro', sans-serif;
    }

    .tk-title {
        color: #C5A059;
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        margin: 0 0 28px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* THẺ TỔNG QUAN */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    @media (max-width: 991px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 560px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: linear-gradient(135deg, #1a1a1a, #202020);
        border: 1px solid #2e2e2e;
        border-radius: 14px;
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.25s, border-color 0.25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: #C5A059;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: rgba(197, 160, 89, 0.12);
        color: #C5A059;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .stat-value {
        color: #f0f0f0;
        font-size: 1.35rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .stat-label {
        color: #888;
        font-size: 0.82rem;
        margin-top: 3px;
    }

    /* PANEL */
    .tk-panel {
        background: #1a1a1a;
        border: 1px solid #2e2e2e;
        border-radius: 16px;
        padding: 26px;
        margin-bottom: 24px;
    }

    .tk-panel-title {
        color: #C5A059;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* BIỂU ĐỒ CỘT DOANH THU THEO THÁNG */
    .chart-bars {
        display: flex;
        align-items: flex-end;
        gap: 14px;
        height: 220px;
        padding: 0 6px;
    }

    .chart-bar-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        gap: 8px;
    }

    .chart-bar-value {
        color: #C5A059;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .chart-bar {
        width: 100%;
        max-width: 46px;
        background: linear-gradient(180deg, #C5A059, #8c6e35);
        border-radius: 6px 6px 0 0;
        transition: opacity 0.2s;
        min-height: 4px;
    }

    .chart-bar:hover {
        opacity: 0.8;
    }

    .chart-bar-label {
        color: #888;
        font-size: 0.78rem;
        margin-top: 4px;
    }

    /* TOP SẢN PHẨM */
    .top-sp-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #242424;
    }

    .top-sp-row:last-child {
        border-bottom: none;
    }

    .top-sp-rank {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(197, 160, 89, 0.12);
        color: #C5A059;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .top-sp-img {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #333;
        flex-shrink: 0;
    }

    .top-sp-info {
        flex: 1;
        min-width: 0;
    }

    .top-sp-name {
        color: #f0f0f0;
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .top-sp-bar-wrap {
        background: #111;
        border-radius: 10px;
        height: 6px;
        margin-top: 6px;
        overflow: hidden;
    }

    .top-sp-bar {
        height: 100%;
        background: linear-gradient(90deg, #C5A059, #8c6e35);
        border-radius: 10px;
    }

    .top-sp-count {
        color: #C5A059;
        font-weight: 700;
        font-size: 0.85rem;
        white-space: nowrap;
        text-align: right;
        min-width: 70px;
    }

    /* TRẠNG THÁI ĐƠN */
    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #242424;
        font-size: 0.9rem;
    }

    .status-row:last-child {
        border-bottom: none;
    }

    .status-dot {
        display: inline-block;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .empty-mini {
        color: #555;
        text-align: center;
        padding: 30px 0;
    }
</style>

<div class="tk-wrap">
    <h2 class="tk-title"><i class="bi bi-graph-up-arrow"></i> Thống Kê Doanh Thu</h2>

    {{-- TỔNG QUAN --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
            <div>
                <div class="stat-value">{{ number_format($tongDoanhThu, 0, ',', '.') }} ₫</div>
                <div class="stat-label">Tổng doanh thu</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-receipt"></i></div>
            <div>
                <div class="stat-value">{{ number_format($tongDonHang) }}</div>
                <div class="stat-label">Tổng đơn hàng</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-value">{{ number_format($tongKhach) }}</div>
                <div class="stat-label">Khách hàng đã mua</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
            <div>
                <div class="stat-value">{{ number_format($trungBinhDon, 0, ',', '.') }} ₫</div>
                <div class="stat-label">Trung bình / đơn</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- BIỂU ĐỒ DOANH THU THEO THÁNG --}}
        <div class="col-lg-7">
            <div class="tk-panel">
                <div class="tk-panel-title"><i class="bi bi-bar-chart-fill"></i> Doanh thu 6 tháng gần nhất</div>

                @if($doanhThuThang->count() > 0)
                <div class="chart-bars">
                    @foreach($doanhThuThang as $dt)
                    <div class="chart-bar-col">
                        <span class="chart-bar-value">{{ number_format($dt->tong / 1000000, 1) }}tr</span>
                        <div class="chart-bar" style="height: {{ max(4, ($dt->tong / $maxDoanhThuThang) * 100) }}%;"
                            title="{{ number_format($dt->tong, 0, ',', '.') }} ₫"></div>
                        <span class="chart-bar-label">{{ \Carbon\Carbon::parse($dt->thang . '-01')->format('m/Y') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-mini"><i class="bi bi-inbox" style="font-size:1.6rem;display:block;margin-bottom:8px;"></i>Chưa có dữ liệu doanh thu</div>
                @endif
            </div>

            {{-- TRẠNG THÁI ĐƠN HÀNG --}}
            <div class="tk-panel">
                <div class="tk-panel-title"><i class="bi bi-pie-chart-fill"></i> Đơn hàng theo trạng thái</div>
                @php
                $mauTrangThai = [
                    'Chờ xử lý' => '#f0ad4e',
                    'Đang giao' => '#5bc0de',
                    'Hoàn Thành' => '#5cb85c',
                    'Đã hủy' => '#ff5555',
                ];
                @endphp
                @forelse($donHangTheoTrangThai as $tt)
                <div class="status-row">
                    <span style="color:#ccc;">
                        <span class="status-dot" style="background: {{ $mauTrangThai[$tt->trang_thai] ?? '#888' }};"></span>
                        {{ $tt->trang_thai }}
                    </span>
                    <strong style="color:#f0f0f0;">{{ $tt->so_luong }} đơn</strong>
                </div>
                @empty
                <div class="empty-mini">Chưa có đơn hàng</div>
                @endforelse
            </div>
        </div>

        {{-- TOP SẢN PHẨM BÁN CHẠY --}}
        <div class="col-lg-5">
            <div class="tk-panel">
                <div class="tk-panel-title"><i class="bi bi-trophy-fill"></i> Top 5 Sản Phẩm Bán Chạy</div>

                @forelse($topSanPham as $i => $sp)
                <div class="top-sp-row">
                    <div class="top-sp-rank">{{ $i + 1 }}</div>
                    @if($sp->sanPham && $sp->sanPham->hinh_anh)
                    <img class="top-sp-img" src="{{ asset('images/' . $sp->sanPham->hinh_anh) }}" alt="">
                    @else
                    <div class="top-sp-img d-flex align-items-center justify-content-center bg-dark">
                        <i class="bi bi-image text-secondary"></i>
                    </div>
                    @endif
                    <div class="top-sp-info">
                        <div class="top-sp-name">{{ $sp->sanPham->ten_sp ?? 'Sản phẩm đã xóa' }}</div>
                        <div class="top-sp-bar-wrap">
                            <div class="top-sp-bar" style="width: {{ max(4, ($sp->tong_ban / $maxTongBan) * 100) }}%;"></div>
                        </div>
                    </div>
                    <div class="top-sp-count">{{ $sp->tong_ban }} đã bán</div>
                </div>
                @empty
                <div class="empty-mini"><i class="bi bi-inbox" style="font-size:1.6rem;display:block;margin-bottom:8px;"></i>Chưa có dữ liệu bán hàng</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection