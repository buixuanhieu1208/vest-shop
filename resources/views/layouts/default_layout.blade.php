<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Kingsman Vietnam')</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #000;
            color: #f0f0f0;
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* TOP BAR */
        .top-bar {
            background-color: #0a0a0a;
            padding: 10px 0;
            border-bottom: 1px solid #222;
            font-size: 0.85rem;
        }

        .top-bar a {
            color: #a0a0a0;
            text-decoration: none;
            transition: color 0.3s;
            margin: 0 15px;
        }

        .top-bar a:hover {
            color: #d4af37;
        }

        .top-bar span {
            color: #a0a0a0;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(180deg, #1a1a1a 0%, #0f0f0f 100%);
            border-bottom: 2px solid #d4af37;
            padding: 12px 0;
            box-shadow: 0 2px 15px rgba(212, 175, 55, 0.15);
        }

        .navbar .container-fluid {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 18px;
        }

        /* Khối chứa nav + actions (Bootstrap collapse) luôn cùng hàng với logo */
        #navbarNav {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: space-between;
            flex: 1 1 auto;
            min-width: 0;
            gap: 14px;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            color: #d4af37 !important;
            letter-spacing: 1.8px;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
            transition: all 0.3s;
            white-space: nowrap;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand i {
            font-size: 1.25rem;
        }

        .navbar-brand:hover {
            color: #f0c864 !important;
            text-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
        }

        .navbar-nav {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 2px;
            flex-shrink: 1;
            min-width: 0;
        }

        .nav-link-main {
            color: #d0d0d0 !important;
            font-weight: 500;
            font-size: 0.78rem;
            padding: 7px 11px !important;
            border-radius: 20px;
            transition: all 0.25s ease;
            white-space: nowrap;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            line-height: 1.2;
        }

        .nav-link-main i {
            font-size: 0.86rem;
        }

        .nav-link-main:hover,
        .nav-link-main.active-link {
            color: #000 !important;
            background: #d4af37;
        }

        .navbar-nav .dropdown-toggle::after {
            margin-left: 3px;
            vertical-align: 0.15em;
            transition: transform 0.25s ease;
        }

        .dropdown-hover:hover .dropdown-toggle::after {
            transform: rotate(180deg);
        }

        /* DROPDOWN */
        .dropdown-hover {
            position: relative;
        }

        /* Vùng đệm vô hình nối liền nav-link với menu, tránh mất hover khi rê chuột xuống */
        .dropdown-hover::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            height: 18px;
        }

        .dropdown-hover .dropdown-menu {
            display: block;
            position: absolute;
            top: calc(100% + 14px);
            left: 50%;
            transform: translateX(-50%) translateY(6px);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
            min-width: 220px;
        }

        .dropdown-hover:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-menu {
            background-color: #161616;
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 10px;
            padding: 6px;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.6);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #c0c0c0;
            padding: 9px 13px;
            font-size: 0.83rem;
            border-radius: 6px;
            transition: background-color 0.18s ease, color 0.18s ease;
            white-space: nowrap;
        }

        .dropdown-item i {
            font-size: 0.9rem;
            width: 15px;
            text-align: center;
            color: #d4af37;
            flex-shrink: 0;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: rgba(212, 175, 55, 0.14);
            color: #f0c864;
        }

        /* RIGHT-SIDE ACTIONS */
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            flex-shrink: 0;
        }

        /* BUTTONS */
        .btn-action-gold {
            color: #d4af37 !important;
            border: 1.5px solid #d4af37 !important;
            background: transparent;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 600;
            padding: 6px 13px;
            transition: all 0.25s;
            letter-spacing: 0.2px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-action-gold:hover {
            background: #d4af37 !important;
            color: #000 !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        /* USER INFO — avatar tròn viết tắt chữ cái đầu, gọn hơn nhiều so với hiện tên đầy đủ */
        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #c0c0c0;
            font-size: 0.78rem;
            padding: 4px 12px 4px 4px;
            background: rgba(42, 42, 42, 0.5);
            border-radius: 20px;
            border: 1px solid #333;
            white-space: nowrap;
        }

        .user-info-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d4af37, #a08045);
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.72rem;
            flex-shrink: 0;
        }

        .user-info strong {
            color: #d4af37;
        }

        /* CART */
        .cart-badge {
            position: relative;
        }

        .cart-badge .badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #d4af37;
            color: #000;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 50%;
            border: 2px solid #1a1a1a;
        }

        @media (max-width: 991.98px) {
            #navbarNav {
                flex-wrap: wrap;
                justify-content: flex-start;
            }

            .navbar-nav {
                flex-wrap: wrap;
                flex-shrink: 1;
                margin: 8px 0;
                width: 100%;
                justify-content: flex-start;
            }

            .nav-link-main {
                font-size: 0.88rem;
                padding: 9px 16px !important;
            }

            .nav-link-main i {
                font-size: 0.95rem;
            }

            .navbar-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            /* Trên mobile: navbar collapse theo chiều dọc nên dropdown hiển thị tĩnh, không dùng hover */
            .dropdown-hover::after {
                display: none;
            }

            .dropdown-hover .dropdown-menu {
                position: static;
                display: none;
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                transform: none;
                box-shadow: none;
                margin: 4px 0 4px 12px;
                border-left: 2px solid #d4af37;
                border-radius: 6px;
            }

            .dropdown-hover .dropdown-menu::before {
                display: none;
            }

            .dropdown-hover.show .dropdown-menu {
                display: block;
            }
        }

        /* SIDEBAR */
        .sidebar {
            background: linear-gradient(to bottom, #0f0f0f, #1a1a1a);
            border: 1px solid #333;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }

        .side-heading {
            background: linear-gradient(135deg, #d4af37, #c19b2f) !important;
            color: #000 !important;
            font-family: 'Playfair Display', serif;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 12px;
            text-align: center;
        }

        .sidebar-body {
            padding: 10px;
        }

        .sidebar-link {
            display: block;
            padding: 10px 15px;
            color: #f0f0f0;
            text-decoration: none;
            border-bottom: 1px solid #222;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .sidebar-link:last-child {
            border-bottom: none;
        }

        .sidebar-link:hover {
            background: rgba(212, 175, 55, 0.1);
            color: #d4af37;
            padding-left: 20px;
        }

        /* MAIN */
        .main-content {
            flex: 1;
            padding: 30px 0;
        }

        /* FOOTER */
        footer {
            background-color: #0a0a0a;
            border-top: 2px solid #d4af37;
            margin-top: auto;
            padding: 50px 0 30px;
        }

        footer h5 {
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
            margin-bottom: 20px;
            color: #d4af37;
        }

        footer a {
            color: #a0a0a0;
            text-decoration: none;
            transition: color 0.3s;
            display: block;
            margin-bottom: 8px;
        }

        footer a:hover {
            color: #d4af37;
            padding-left: 5px;
        }

        footer p {
            color: #a0a0a0;
            line-height: 1.8;
        }

        footer hr {
            border-color: #333 !important;
            margin: 30px 0;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #d4af37;
            border-radius: 2.5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #c19b2f;
        }
        a, a:hover {
            text-decoration: none !important;
        }
    </style>
</head>

<body>

    {{-- TOP BAR --}}
    <div class="top-bar">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <span><i class="bi bi-clock"></i> Thời gian làm việc: Hàng ngày từ 9h - 21h</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="tel:0901234567"><i class="bi bi-telephone"></i> 0901 234 567</a>
                    <a href="mailto:vip@kingsman.vn"><i class="bi bi-envelope"></i> vip@kingsman.vn</a>
                </div>
            </div>
        </div>
    </div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-gem"></i> KINGSMAN
            </a>

            <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter:invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link nav-link-main">
                            <i class="bi bi-house-door"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/san-pham') }}" class="nav-link nav-link-main">
                            <i class="bi bi-grid"></i> Sản phẩm
                        </a>
                    </li>

                    @if(Auth::check() && Auth::user()->quyen == 'Admin')
                    <li class="nav-item">
                        <a href="{{ url('/san-pham/danh-sach') }}" class="nav-link nav-link-main">
                            <i class="bi bi-box-seam"></i> Quản Lý Sản Phẩm
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link nav-link-main dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-people"></i> Quản Lý Người Dùng
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/nguoi-dung') }}"><i class="bi bi-person-lines-fill me-2"></i>Danh Sách Tài Khoản</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link nav-link-main dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-graph-up-arrow"></i> Thống kê
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/thong-ke/doanh-thu') }}"><i class="bi bi-bar-chart me-2"></i>Doanh thu</a></li>
                            <li><a class="dropdown-item" href="{{ url('/thong-ke/don-hang') }}"><i class="bi bi-receipt-cutoff me-2"></i>Đơn hàng</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>

                <div class="d-flex align-items-center gap-2 navbar-actions">
                    @if(Auth::check())
                    <div class="user-info">
                        <span class="user-info-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        <strong>{{ Auth::user()->name }}</strong>
                    </div>
                    <a href="{{ url('/dang-xuat') }}" class="btn-action-gold">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </a>
                    @else
                    <a href="{{ url('/dang-nhap') }}" class="btn-action-gold">
                        <i class="bi bi-person"></i> Đăng nhập
                    </a>
                    @endif

                    @if(Auth::check())
                    <a href="{{ url('/gio-hang') }}" class="btn-action-gold cart-badge">
                        <i class="bi bi-cart3"></i> Giỏ hàng
                        @php $soLuongGioHang = collect(session('gio_hang_' . Auth::id(), []))->sum('so_luong'); @endphp
                        @if($soLuongGioHang > 0)
                        <span class="badge">{{ $soLuongGioHang }}</span>
                        @endif
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- BODY --}}
    <div class="container-fluid main-content">
        <div class="row px-3">

            @hasSection('sidebar_danhmuc')
            <aside class="col-md-3 col-lg-2 mb-4">
                <div class="sidebar">
                    <div class="side-heading"><i class="bi bi-list-ul me-1"></i> DANH MỤC</div>
                    <div class="sidebar-body">
                        @yield('sidebar_danhmuc')
                    </div>
                </div>
            </aside>
            <main class="col-md-9 col-lg-10">
                @else
                <main class="col-12">
                    @endif
                    @yield('content')
                </main>

        </div>
    </div>

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-gem"></i> KINGSMAN</h5>
                    <p>Đẳng cấp quý ông. Mang đến những bộ vest sang trọng, lịch lãm và hoàn hảo cho mọi sự kiện.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>LIÊN KẾT</h5>
                    <a href="{{ url('/') }}">Trang chủ</a>
                    <a href="{{ url('/san-pham') }}">Bộ sưu tập</a>
                    <a href="{{ url('/gio-hang') }}">Giỏ hàng</a>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>LIÊN HỆ</h5>
                    <p><i class="bi bi-geo-alt-fill" style="color:#d4af37;"></i> 123 Đồng Khởi, Quận 1, TP.HCM</p>
                    <p><i class="bi bi-telephone-fill" style="color:#d4af37;"></i> 0901 234 567</p>
                    <p><i class="bi bi-envelope-fill" style="color:#d4af37;"></i> vip@kingsman.vn</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <small style="color:#666;">&copy; 2026 Kingsman Bespoke. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Active nav highlight
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link-main').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.style.color = '#d4af37';
                link.style.backgroundColor = 'rgba(212, 175, 55, 0.1)';
            }
        });

        // Carousel
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.querySelector('#heroCarousel');
            if (el && typeof bootstrap !== 'undefined') {
                new bootstrap.Carousel(el, {
                    interval: 4000,
                    ride: 'carousel',
                    touch: true
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>