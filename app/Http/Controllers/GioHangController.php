<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SanPham;

class GioHangController extends Controller
{
    private function sessionKey()
    {
        return 'gio_hang_' . Auth::id();
    }

    public function index()
    {
        $gioHang  = session()->get($this->sessionKey(), []);
        $tongTien = collect($gioHang)->sum(fn($item) => $item['gia'] * $item['so_luong']);
        if (session('thanhtoan')) {
            $gioHang  = session('gioHang_thanhtoan', []);
            $tongTien = session('tongTien_thanhtoan', 0);
        }

        return view('giohang', compact('gioHang', 'tongTien'));
    }

    public function addToCart(Request $request)
    {
        $id      = $request->id;
        $size    = $request->size;
        $sanPham = SanPham::findOrFail($id);

        $gioHang = session()->get($this->sessionKey(), []);
        $key     = $id . '_' . $size;

        if (isset($gioHang[$key])) {
            $gioHang[$key]['so_luong']++;
        } else {
            $gioHang[$key] = [
                'id'       => $sanPham->id,
                'ten_sp'   => $sanPham->ten_sp,
                'gia'      => $sanPham->gia,
                'hinh_anh' => $sanPham->hinh_anh,
                'size'     => $size,
                'so_luong' => 1,
            ];
        }

        session()->put($this->sessionKey(), $gioHang);

        $backUrl = $request->url ?: route('sanpham.index');
        return redirect($backUrl)->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function updateSL(Request $request)
    {
        $key     = $request->key;
        $type    = $request->type;
        $gioHang = session()->get($this->sessionKey(), []);

        if (isset($gioHang[$key])) {
            $gioHang[$key]['so_luong'] += $type;
            if ($gioHang[$key]['so_luong'] <= 0) {
                unset($gioHang[$key]);
            }
        }

        session()->put($this->sessionKey(), $gioHang);
        return redirect()->route('giohang.index');
    }

    public function remove(Request $request)
    {
        $key     = $request->key;
        $gioHang = session()->get($this->sessionKey(), []);
        unset($gioHang[$key]);
        session()->put($this->sessionKey(), $gioHang);
        return redirect()->route('giohang.index');
    }

    public function clear()
    {
        session()->forget($this->sessionKey());
        return redirect()->route('giohang.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    public function checkout()
    {
        session()->forget($this->sessionKey());
        return redirect()->route('sanpham.index');
    }

    public function thanhToan()
    {
        $gioHang = session('gio_hang_' . auth()->id(), []);
        
        if (empty($gioHang)) {
            return redirect()->route('sanpham.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $tongTien = collect($gioHang)->sum(function($item) {
            return $item['gia'] * $item['so_luong'];
        });

        return view('thanhtoan', compact('gioHang', 'tongTien'));
    }

    public function xuLyThanhToan(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'dia_chi' => 'required|string|max:500',
            'phuong_thuc' => 'required|in:cod,bank',
            'ghi_chu' => 'nullable|string'
        ]);

        session()->forget('gio_hang_' . auth()->id());

        return redirect()->route('trangchu')->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ để xác nhận đơn hàng của bạn trong thời gian sớm nhất.');
    }
}