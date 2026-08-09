<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\DangKyController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DanhGiaController;

// 0. Route công khai - AI CŨNG XEM ĐƯỢC, không cần đăng nhập
Route::get('/', [TrangChuController::class, 'index'])->name('trangchu.index');
Route::get('/san-pham', [SanPhamController::class, 'index'])->name('sanpham.index');
Route::get('/san-pham/danh-sach', [SanPhamController::class, 'danhSach'])->name('sanpham.danhsach');
Route::get('/san-pham/{id}', [SanPhamController::class, 'chiTiet'])->name('sanpham.chitiet');

// 1. Route xác thực (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [DangNhapController::class, 'index'])->name('login');
    Route::post('/dang-nhap', [DangNhapController::class, 'login']);
    Route::get('/dang-ky', [DangKyController::class, 'index']);
    Route::post('/dang-ky', [DangKyController::class, 'register']);
});

// 2. Route yêu cầu đăng nhập
Route::middleware('auth')->group(function () {

    // Giỏ hàng (cần đăng nhập vì gắn với session theo user)
    Route::get('/gio-hang', [GioHangController::class, 'index'])->name('giohang.index');
    Route::get('/gio-hang/them', [GioHangController::class, 'addToCart'])->name('giohang.add');
    Route::get('/gio-hang/update', [GioHangController::class, 'updateSL'])->name('giohang.update');
    Route::get('/gio-hang/xoa', [GioHangController::class, 'remove'])->name('giohang.remove');
    Route::get('/gio-hang/checkout', [GioHangController::class, 'checkout'])->name('giohang.checkout');
    Route::get('/gio-hang/clear', [App\Http\Controllers\GioHangController::class, 'clear'])->name('giohang.clear');

    Route::get('/thanh-toan', [App\Http\Controllers\GioHangController::class, 'thanhToan'])->name('giohang.thanhtoan');
    Route::post('/thanh-toan', [App\Http\Controllers\GioHangController::class, 'xuLyThanhToan'])->name('giohang.xulythanhtoan');

    // Trang cá nhân (Profile)
    Route::get('/trang-ca-nhan', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/trang-ca-nhan/cap-nhat', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/trang-ca-nhan/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Đánh giá sản phẩm
    Route::post('/san-pham/{id}/danh-gia', [DanhGiaController::class, 'store'])->name('danhgia.store');
    Route::post('/danh-gia/{id}/xoa', [DanhGiaController::class, 'destroy'])->name('danhgia.xoa');
    Route::delete('/danh-gia/{id}', [App\Http\Controllers\DanhGiaController::class, 'destroy'])->name('danhgia.destroy');

    // CRUD Sản phẩm
    Route::post('/san-pham/them', [SanPhamController::class, 'luuThem'])->name('sanpham.luuthem');
    Route::post('/san-pham/{id}/sua', [SanPhamController::class, 'luuSua'])->name('sanpham.luusua');
    Route::post('/san-pham/{id}/xoa', [SanPhamController::class, 'xoa'])->name('sanpham.xoa');

    // Quản lý người dùng (Admin)
    Route::get('/nguoi-dung', [NguoiDungController::class, 'index'])->name('nguoidung.index');
    Route::post('/nguoi-dung/{id}/quyen', [NguoiDungController::class, 'doiQuyen'])->name('nguoidung.doiquyen');
    Route::post('/nguoi-dung/{id}/xoa', [NguoiDungController::class, 'xoa'])->name('nguoidung.xoa');
    Route::put('/nguoi-dung/{id}/sua-ten', [App\Http\Controllers\NguoiDungController::class, 'suaTen'])->name('nguoidung.suaten');

    // Thống kê (Admin)
    Route::get('/thong-ke/doanh-thu', [ThongKeController::class, 'doanhThu'])->name('thongke.doanhthu');
    Route::get('/thong-ke/don-hang', [ThongKeController::class, 'donHang'])->name('thongke.donhang');
    Route::post('/thong-ke/don-hang/{id}/trang-thai', [ThongKeController::class, 'capNhatTrangThai'])->name('thongke.donhang.trangthai');

    // Đăng xuất
    Route::get('/dang-xuat', function () {
        Auth::logout();
        return redirect('/dang-nhap');
    });
});