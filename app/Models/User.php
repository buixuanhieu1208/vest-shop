<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'quyen',
        'trang_thai',
        'phone',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isKhoa(): bool
    {
        return $this->trang_thai === 'Đã khóa';
    }

    // Đánh giá mà user này đã viết
    public function danhGia()
    {
        return $this->hasMany(DanhGia::class, 'user_id');
    }

    // Link ảnh avatar - nếu chưa có avatar thì tự sinh ảnh chữ cái đầu tên (không cần file mặc định trên server)
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('images/avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=d4af37&color=000&bold=true';
    }
}