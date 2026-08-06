<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gias';

    protected $fillable = ['san_pham_id', 'user_id', 'so_sao', 'noi_dung', 'hinh_anh'];

    protected $casts = [
        'hinh_anh' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}