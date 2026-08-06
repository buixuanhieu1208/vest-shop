<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'hoa_dons';

    protected $fillable = [
        'user_id',
        'ngay_ban',
        'trang_thai',
        'thanh_toan',
        'dia_chi',
    ];

    protected $casts = [
        'ngay_ban' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chiTietHoaDons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'hoa_don_id');
    }
}