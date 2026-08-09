<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Đổi quyền tài khoản (Admin <-> Khách hàng).
     */
    public function doiQuyen(Request $request, $id)
    {
        $request->validate([
            'quyen' => 'required|in:Admin,Khách hàng',
        ]);

        if ((int) $id === (int) Auth::id()) {
            return back()->with('error', 'Bạn không thể tự đổi quyền của chính mình!');
        }

        $nguoiDung = User::findOrFail($id);
        $nguoiDung->quyen = $request->quyen;
        $nguoiDung->save();

        return back()->with('success', 'Đã cập nhật quyền cho ' . $nguoiDung->name . ' thành "' . $request->quyen . '".');
    }

    /**
     * Khóa hoặc mở khóa tài khoản (thay vì xóa cứng, để giữ nguyên lịch sử đơn hàng liên quan).
     */
    public function khoaMoKhoa($id)
    {
        if ((int) $id === (int) Auth::id()) {
            return back()->with('error', 'Bạn không thể tự khóa tài khoản của chính mình!');
        }

        $nguoiDung = User::findOrFail($id);
        $nguoiDung->trang_thai = $nguoiDung->isKhoa() ? 'Hoạt động' : 'Đã khóa';
        $nguoiDung->save();

        $thongBao = $nguoiDung->isKhoa()
            ? 'Đã khóa tài khoản "' . $nguoiDung->name . '".'
            : 'Đã mở khóa tài khoản "' . $nguoiDung->name . '".';

        return back()->with('success', $thongBao);
    }
    public function suaTen(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $nguoiDung = User::findOrFail($id);
        $nguoiDung->name = $request->name;
        $nguoiDung->save();

        return back()->with('success', 'Đã cập nhật tên tài khoản thành công!');
    }
    public function doiAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $thuMucLuu = public_path('images/avatars');
            if (!file_exists($thuMucLuu)) {
                mkdir($thuMucLuu, 0777, true);
            }

            $file = $request->file('avatar');
            $tenFile = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move($thuMucLuu, $tenFile);

            if ($user->avatar && file_exists(public_path('images/avatars/' . $user->avatar))) {
                @unlink(public_path('images/avatars/' . $user->avatar));
            }

            $user->avatar = $tenFile;
            $user->save();
        }

        return back()->with('success', 'Đổi ảnh đại diện thành công!');
    }
    public function showProfile()
    {
        $user = Auth::user();
        return view('Profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}