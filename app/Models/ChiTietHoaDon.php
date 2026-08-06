<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    protected $table = 'chi_tiet_hoa_dons';

    protected $fillable = [
        'hoa_don_id',
        'san_pham_id',
        'size',
        'gia_sp',
        'so_luong',
        'tong_tien',
    ];

    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'hoa_don_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}