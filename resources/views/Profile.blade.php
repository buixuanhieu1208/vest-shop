@extends('layouts.default_layout')

@section('title', 'Trang Cá Nhân - Kingsman Vietnam')

@section('content')
<style>
    .profile-container {
        padding: 50px 0 70px;
        min-height: 60vh;
    }

    .profile-card {
        background: linear-gradient(135deg, #1a1a1a, #191919);
        border: 1px solid #2c2c2c;
        border-radius: 18px;
        padding: 40px;
        max-width: 640px;
        margin: 0 auto;
    }

    .profile-title {
        font-family: 'Playfair Display', serif;
        color: #d4af37;
        font-size: 1.8rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
    }

    /* AVATAR */
    .avatar-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
        margin-bottom: 34px;
        padding-bottom: 30px;
        border-bottom: 1px solid #2c2c2c;
    }

    .avatar-preview {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #d4af37;
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.25);
    }

    .avatar-upload-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #d4af37;
        border: 1.5px solid #d4af37;
        border-radius: 25px;
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
    }

    .avatar-upload-label:hover {
        background: #d4af37;
        color: #000;
    }

    .avatar-hint {
        color: #777;
        font-size: 0.78rem;
    }

    /* FORM */
    .profile-form .form-label {
        color: #a0a0a0;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .profile-form .form-control {
        background: #0f0f0f !important;
        border: 1.5px solid #3a3a3a !important;
        border-radius: 8px !important;
        color: #f0f0f0 !important;
        padding: 11px 14px;
        margin-bottom: 18px;
    }

    .profile-form .form-control:focus {
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15) !important;
    }

    .profile-form .form-control:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, #d4af37, #c19b2f);
        color: #000;
        border: none;
        border-radius: 25px;
        font-weight: 700;
        padding: 12px;
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
    }

    .profile-alert {
        background: rgba(40, 167, 69, 0.15);
        border: 1px solid #28a745;
        color: #75d98b;
        border-radius: 10px;
        padding: 12px 20px;
        margin-bottom: 22px;
        font-size: 0.9rem;
    }
</style>

<div class="profile-container container">
    <div class="profile-card">
        <div class="profile-title"><i class="bi bi-person-circle"></i> Trang Cá Nhân</div>

        @if(session('success'))
        <div class="profile-alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
        @endif

        {{-- UPLOAD AVATAR --}}
        <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
            @csrf
            <div class="avatar-wrap">
                <img src="{{ $user->avatar_url }}" class="avatar-preview" id="avatarPreview" alt="Avatar">

                <label class="avatar-upload-label" for="avatarInput">
                    <i class="bi bi-camera-fill"></i> Đổi ảnh đại diện
                </label>
                <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;" onchange="document.getElementById('avatarForm').submit()">

                <span class="avatar-hint">Ảnh JPG, PNG hoặc WEBP, tối đa 2MB</span>
            </div>
        </form>

        {{-- THÔNG TIN CÁ NHÂN --}}
        <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
            @csrf

            <label class="form-label">Họ tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>

            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $user->email }}" disabled>

            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">

            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">

            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Lưu Thay Đổi
            </button>
        </form>
    </div>
</div>
@endsection