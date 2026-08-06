@extends('layouts.auth_layout')

@section('title', 'Đăng Nhập - Kingsman')

@section('content')
<style>

    .auth-wrap {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 16px;
        background:
            radial-gradient(circle at 20% 20%, rgba(197, 160, 89, 0.08), transparent 45%),
            radial-gradient(circle at 80% 80%, rgba(197, 160, 89, 0.06), transparent 45%),
            linear-gradient(135deg, #0a0a0a 0%, #141414 100%);
    }

    .auth-card {
        width: 100%;
        max-width: 460px;
        background: linear-gradient(150deg, #1a1a1a 0%, #151515 100%);
        border: 1px solid #333;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 55px rgba(0, 0, 0, 0.55);
    }

    .auth-card-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-align: center;
        padding: 30px 30px 24px;
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        font-family: 'Montserrat', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .auth-card-header i {
        font-family: "bootstrap-icons" !important;
        font-size: 1.3rem;
        line-height: 1;
    }

    .auth-card-body {
        padding: 36px 34px 32px;
    }

    .auth-card-body .form-label {
        color: #C5A059;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.4px;
        margin-bottom: 8px;
        display: block;
    }

    .auth-card-body .form-control {
        background: #111;
        border: 2px solid #363636;
        color: #e8e8e8;
        border-radius: 10px;
        padding: 12px 16px;
        width: 100%;
        font-size: 0.95rem;
        transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
    }

    .auth-card-body .form-control::placeholder {
        color: #4d4d4d;
    }

    .auth-card-body .form-control:focus {
        outline: none;
        border-color: #C5A059;
        background: #161616;
        box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.15);
    }

    .btn-gold {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        border: none;
        padding: 13px 20px;
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.8px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 8px 22px rgba(197, 160, 89, 0.3);
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(197, 160, 89, 0.5);
        color: #000;
    }

    .link-gold {
        color: #C5A059;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .link-gold:hover {
        color: #e8c169;
        text-decoration: underline;
    }

    .auth-divider {
        text-align: center;
        color: #555;
        font-size: 0.78rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin: 26px 0 22px;
        position: relative;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 38%;
        height: 1px;
        background: #333;
    }

    .auth-divider::before {
        left: 0;
    }

    .auth-divider::after {
        right: 0;
    }

    .alert-success {
        background: rgba(197, 160, 89, 0.15) !important;
        border: 1px solid #C5A059 !important;
        color: #C5A059 !important;
        border-radius: 10px !important;
    }
</style>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-card-header">
            <i class="bi bi-person-circle me-2"></i> Đăng Nhập
        </div>
        <div class="auth-card-body">

            @if(session('success'))
            <div class="alert alert-success small mb-4">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger small mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ url('/dang-nhap') }}" method="POST" autocomplete="on">
                @csrf

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        required autocomplete="email"
                        value="{{ old('email') }}"
                        placeholder="example@email.com">
                </div>

                <div class="mb-4">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control"
                        required autocomplete="current-password"
                        placeholder="••••••••">
                </div>

                <button type="submit" class="btn-gold mb-4">
                     Đăng Nhập
                </button>

                <div class="auth-divider">hoặc</div>

                <div class="text-center small" style="color:#888;">
                    Chưa có tài khoản?
                    <a href="{{ url('/dang-ky') }}" class="link-gold">Đăng ký ngay</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection