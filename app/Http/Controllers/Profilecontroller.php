<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('Profile', compact('user'));
    }

    public function update(Request $request)
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

    public function avatar(Request $request)
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
}