<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Thư viện mã hóa mật khẩu

class DangKyController extends Controller
{
    public function index()
    {
        return view('dangky');
    }

    public function register(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào (Validation)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'email.unique' => 'Email này đã được sử dụng!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ]);

        // 2. Lưu vào database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'quyen' => 'Khách hàng'
        ]);

        return redirect('/dang-nhap')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
