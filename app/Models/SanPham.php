<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_phams';

    protected $fillable = [
        'ten_sp',
        'xuat_xu',
        'chat_lieu',
        'gia',
        'hinh_anh',
        'mo_ta',
        'danh_muc_id'
    ];

    // Quan hệ với DanhMuc
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }

    // Liên kết 1 sản phẩm có nhiều đánh giá
    public function danhGia()
    {
        return $this->hasMany(DanhGia::class, 'san_pham_id');
    }

    // Tính sao trung bình
    public function getSoSaoTrungBinhAttribute()
    {
        return round($this->danhGia()->avg('so_sao') ?? 0, 1);
    }
    
    // Tính số lượng đánh giá
    public function getSoLuongDanhGiaAttribute()
    {
        return $this->danhGia()->count();
    }
}