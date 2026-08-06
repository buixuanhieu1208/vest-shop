<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update($request->only('name', 'phone', 'address'));

        return back()->with('success', 'Đã cập nhật thông tin cá nhân!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();

        // Xóa avatar cũ nếu có, tránh rác file trên server
        if ($user->avatar) {
            $duongDanCu = public_path('images/avatars/' . $user->avatar);
            if (file_exists($duongDanCu)) {
                unlink($duongDanCu);
            }
        }

        $file    = $request->file('avatar');
        $tenFile = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $thuMuc = public_path('images/avatars');
        if (!file_exists($thuMuc)) {
            mkdir($thuMuc, 0755, true);
        }

        $file->move($thuMuc, $tenFile);

        $user->avatar = $tenFile;
        $user->save();

        return back()->with('success', 'Đã cập nhật ảnh đại diện!');
    }
}