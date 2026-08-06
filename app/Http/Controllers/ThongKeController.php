<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use Illuminate\Http\Request;

class ThongKeController extends Controller
{
    /**
     * Trang thống kê doanh thu.
     */
    public function doanhThu(Request $request)
    {
        // Tổng quan
        $tongDoanhThu = HoaDon::sum('thanh_toan');
        $tongDonHang  = HoaDon::count();
        $tongKhach    = HoaDon::distinct('user_id')->count('user_id');
        $trungBinhDon = $tongDonHang > 0 ? $tongDoanhThu / $tongDonHang : 0;

        // Doanh thu 6 tháng gần nhất
        $doanhThuThang = HoaDon::selectRaw("DATE_FORMAT(ngay_ban, '%Y-%m') as thang, SUM(thanh_toan) as tong")
            ->whereNotNull('ngay_ban')
            ->groupBy('thang')
            ->orderByDesc('thang')
            ->limit(6)
            ->get()
            ->sortBy('thang')
            ->values();

        $maxDoanhThuThang = $doanhThuThang->max('tong') ?: 1;

        // Top 5 sản phẩm bán chạy
        $topSanPham = ChiTietHoaDon::selectRaw('san_pham_id, SUM(so_luong) as tong_ban, SUM(tong_tien) as doanh_thu')
            ->groupBy('san_pham_id')
            ->orderByDesc('tong_ban')
            ->with('sanPham')
            ->limit(5)
            ->get();

        $maxTongBan = $topSanPham->max('tong_ban') ?: 1;

        // Đơn hàng theo trạng thái
        $donHangTheoTrangThai = HoaDon::selectRaw('trang_thai, COUNT(*) as so_luong')
            ->groupBy('trang_thai')
            ->get();

        return view('thongke.doanhthu', compact(
            'tongDoanhThu',
            'tongDonHang',
            'tongKhach',
            'trungBinhDon',
            'doanhThuThang',
            'maxDoanhThuThang',
            'topSanPham',
            'maxTongBan',
            'donHangTheoTrangThai'
        ));
    }

    /**
     * Trang danh sách & quản lý đơn hàng.
     */
    public function donHang(Request $request)
    {
        $trangThai = $request->query('trang_thai');
        $tuKhoa    = $request->query('tim_kiem');

        $donHangs = HoaDon::with(['user', 'chiTietHoaDons.sanPham'])
            ->when($trangThai, function ($q) use ($trangThai) {
                $q->where('trang_thai', $trangThai);
            })
            ->when($tuKhoa, function ($q) use ($tuKhoa) {
                $q->where('id', 'like', "%{$tuKhoa}%")
                  ->orWhereHas('user', function ($qq) use ($tuKhoa) {
                      $qq->where('name', 'like', "%{$tuKhoa}%")
                         ->orWhere('email', 'like', "%{$tuKhoa}%");
                  });
            })
            ->orderByDesc('ngay_ban')
            ->paginate(12)
            ->withQueryString();

        $danhSachTrangThai = ['Chờ xử lý', 'Đang giao', 'Hoàn Thành', 'Đã hủy'];

        return view('thongke.donhang', compact('donHangs', 'trangThai', 'tuKhoa', 'danhSachTrangThai'));
    }

    /**
     * Cập nhật trạng thái đơn hàng (dùng cho nút đổi trạng thái nhanh).
     */
    public function capNhatTrangThai(Request $request, $id)
    {
        $request->validate([
            'trang_thai' => 'required|in:Chờ xử lý,Đang giao,Hoàn Thành,Đã hủy',
        ]);

        $donHang = HoaDon::findOrFail($id);
        $donHang->trang_thai = $request->trang_thai;
        $donHang->save();

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $id);
    }
}