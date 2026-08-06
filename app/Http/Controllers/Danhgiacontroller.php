<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaController extends Controller
{

    public function store(Request $request, $san_pham_id)
    {
        $request->validate([
            'so_sao' => 'required|integer|min:1|max:5',
            'noi_dung' => 'nullable|string|max:1000',
            'hinh_anh' => 'nullable|array|max:3', 
            'hinh_anh.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048' 
        ]);

        $danhSachAnh = [];
        
        if ($request->hasFile('hinh_anh')) {
            $thuMucLuu = public_path('images/reviews');
            if (!file_exists($thuMucLuu)) {
                mkdir($thuMucLuu, 0777, true);
            }

            foreach ($request->file('hinh_anh') as $file) {
                $tenFile = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move($thuMucLuu, $tenFile);
                $danhSachAnh[] = $tenFile;
            }
        }

        \App\Models\DanhGia::create([
            'san_pham_id' => $san_pham_id,
            'user_id' => auth()->id(),
            'so_sao' => $request->so_sao,
            'noi_dung' => $request->noi_dung,
            'hinh_anh' => empty($danhSachAnh) ? null : $danhSachAnh
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    public function destroy($id)
    {
        $danhGia = DanhGia::findOrFail($id);
        $user    = Auth::user();

        if ($danhGia->user_id !== $user->id && $user->quyen !== 'Admin') {
            abort(403, 'Bạn không có quyền xóa đánh giá này.');
        }

        $danhGia->delete();

        return back()->with('success', 'Đã xóa đánh giá.');
    }
}