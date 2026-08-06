@extends('layouts.default_layout')

@section('title', 'Thanh Toán - Kingsman Vietnam')

@section('content')
<style>
    .checkout-container {
        padding: 40px 0;
    }

    .checkout-title {
        font-family: 'Playfair Display', serif;
        color: #C5A059;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        padding-bottom: 15px;
    }

    .checkout-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #C5A059, transparent);
    }

    .checkout-card {
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        margin-bottom: 25px;
    }

    .card-heading {
        color: #C5A059;
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 25px;
        border-bottom: 1px solid #333;
        padding-bottom: 15px;
    }

    .form-label {
        color: #e0e0e0;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        background: #111;
        border: 2px solid #333;
        color: #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        background: #151515;
        border-color: #C5A059;
        box-shadow: 0 0 15px rgba(197, 160, 89, 0.2);
        color: #fff;
    }

    .form-control[readonly] {
        background: #151515 !important;
        color: #888 !important;
        border-color: #333 !important;
        cursor: not-allowed;
    }

    .payment-method {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border: 2px solid #333;
        border-radius: 10px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s;
        background: #111;
    }

    .payment-method:hover {
        border-color: #C5A059;
    }

    .payment-method input[type="radio"] {
        display: none;
    }

    .payment-method .radio-custom {
        width: 22px;
        height: 22px;
        border: 2px solid #666;
        border-radius: 50%;
        margin-right: 15px;
        position: relative;
        display: inline-block;
    }

    .payment-method input[type="radio"]:checked + .radio-custom {
        border-color: #C5A059;
    }

    .payment-method input[type="radio"]:checked + .radio-custom::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        background: #C5A059;
        border-radius: 50%;
    }

    .payment-method-info {
        display: flex;
        flex-direction: column;
    }

    .payment-method-title {
        color: #e0e0e0;
        font-weight: 600;
        font-size: 1rem;
    }

    .payment-method-desc {
        color: #888;
        font-size: 0.85rem;
    }

    .qr-container {
        text-align: center;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        margin-top: 15px;
        display: none;
    }

    .qr-container img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #2a2a2a;
        color: #aaa;
    }

    .summary-row.total {
        border-bottom: none;
        border-top: 2px solid #C5A059;
        margin-top: 10px;
        padding-top: 15px;
        color: #C5A059;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .summary-row span:last-child {
        color: #e0e0e0;
        font-weight: 600;
    }

    .summary-row.total span:last-child {
        color: #C5A059;
        font-size: 1.4rem;
    }

    .btn-submit-order {
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border: none;
        width: 100%;
        padding: 15px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-top: 25px;
        transition: all 0.3s;
    }

    .btn-submit-order:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(197, 160, 89, 0.4);
        background: linear-gradient(135deg, #d4b36a, #C5A059);
    }
</style>

<div class="checkout-container container">
    <h2 class="checkout-title"><i class="bi bi-shield-lock"></i> Thanh Toán An Toàn</h2>

    @if($errors->any())
    <div class="alert alert-danger" style="background:rgba(255,68,68,0.1); border:1px solid #ff4444; color:#ff4444;">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('giohang.xulythanhtoan') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-4">
            
            <div class="col-lg-7">
                <div class="checkout-card">
                    <h4 class="card-heading">Thông Tin Giao Hàng</h4>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Họ và tên người nhận</label>
                            <input type="text" name="ho_ten" class="form-control" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="so_dien_thoai" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Địa chỉ nhận hàng chi tiết</label>
                            <input type="text" name="dia_chi" class="form-control" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Ghi chú đơn hàng</label>
                            <textarea name="ghi_chu" class="form-control" rows="3" placeholder="Ghi chú về thời gian giao hàng, chỉ dẫn địa chỉ..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="checkout-card">
                    <h4 class="card-heading">Phương Thức Thanh Toán</h4>
                    
                    <label class="payment-method">
                        <input type="radio" name="phuong_thuc" value="cod" id="pm_cod" checked>
                        <span class="radio-custom"></span>
                        <div class="payment-method-info">
                            <span class="payment-method-title"><i class="bi bi-cash-stack me-2"></i> Thanh toán khi nhận hàng (COD)</span>
                            <span class="payment-method-desc">Thanh toán bằng tiền mặt khi đơn hàng được giao đến tay bạn.</span>
                        </div>
                    </label>

                    <label class="payment-method">
                        <input type="radio" name="phuong_thuc" value="bank" id="pm_bank">
                        <span class="radio-custom"></span>
                        <div class="payment-method-info">
                            <span class="payment-method-title"><i class="bi bi-qr-code-scan me-2"></i> Chuyển khoản VietQR</span>
                            <span class="payment-method-desc">Quét mã QR qua ứng dụng ngân hàng để thanh toán nhanh chóng.</span>
                        </div>
                    </label>

                    <div id="qr_code_section" class="qr-container">
                        <p style="color: #000; font-weight: 600; margin-bottom: 10px;">Quét mã QR dưới đây để thanh toán</p>
                        <img id="vietqr_img" src="" alt="Mã QR Thanh Toán">
                        <p style="color: #666; font-size: 0.85rem; margin-top: 10px; margin-bottom: 0;">Mã QR đã bao gồm số tiền và nội dung chuyển khoản.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-card" style="position: sticky; top: 20px;">
                    <h4 class="card-heading">Đơn Hàng Của Bạn</h4>
                    
                    <div style="max-height: 300px; overflow-y: auto; padding-right: 10px; margin-bottom: 20px;">
                        @foreach($gioHang as $item)
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                            <img src="{{ asset('images/' . $item['hinh_anh']) }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #333;">
                            <div style="flex: 1;">
                                <div style="color: #e0e0e0; font-weight: 600; font-size: 0.9rem;">{{ $item['ten_sp'] }}</div>
                                <div style="color: #888; font-size: 0.8rem;">Size: {{ $item['size'] }} | SL: {{ $item['so_luong'] }}</div>
                            </div>
                            <div style="color: #C5A059; font-weight: 600;">{{ number_format($item['gia'] * $item['so_luong'], 0, ',', '.') }} đ</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($tongTien, 0, ',', '.') }} VNĐ</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí giao hàng:</span>
                        <span>30.000 VNĐ</span>
                    </div>
                    <div class="summary-row total">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($tongTien + 30000, 0, ',', '.') }} VNĐ</span>
                    </div>

                    <button type="submit" class="btn-submit-order">
                        <i class="bi bi-check2-circle me-2"></i> Xác Nhận Đặt Hàng
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pmCod = document.getElementById('pm_cod');
        const pmBank = document.getElementById('pm_bank');
        const qrSection = document.getElementById('qr_code_section');
        const qrImg = document.getElementById('vietqr_img');
        
        const tongTienThanhToan = {{ $tongTien + 30000 }};
        
        const bankId = 'BIDV'; 
        const accountNo = '6360972167'; 
        const accountName = 'BUI XUAN HIEU';
        const addInfo = 'KINGSMAN THANH TOAN DON HANG';

        function updatePaymentView() {
            if(pmBank.checked) {
                qrSection.style.display = 'block';
                qrImg.src = `https://img.vietqr.io/image/${bankId}-${accountNo}-compact2.png?amount=${tongTienThanhToan}&addInfo=${encodeURIComponent(addInfo)}&accountName=${encodeURIComponent(accountName)}`;
            } else {
                qrSection.style.display = 'none';
            }
        }

        pmCod.addEventListener('change', updatePaymentView);
        pmBank.addEventListener('change', updatePaymentView);
    });
</script>
@endsection