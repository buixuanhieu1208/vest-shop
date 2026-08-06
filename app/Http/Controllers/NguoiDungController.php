<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
    /**
     * Hiển thị danh sách tất cả tài khoản (chỉ Admin được truy cập).
     */
    public function index(Request $request)
    {
        $tuKhoa = $request->query('tim_kiem');

        $nguoiDungs = User::query()
            ->when($tuKhoa, function ($query, $tuKhoa) {
                $query->where('name', 'like', "%{$tuKhoa}%")
                      ->orWhere('email', 'like', "%{$tuKhoa}%");
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('nguoidung.danhsach', compact('nguoiDungs', 'tuKhoa'));
    }
}
