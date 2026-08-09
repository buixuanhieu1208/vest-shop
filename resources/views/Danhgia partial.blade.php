<style>
    .rating-summary {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #2a2a2a;
    }

    .rating-stars i {
        color: #C5A059;
        font-size: 1.4rem;
    }

    .rating-count {
        color: #999;
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* KHUNG FORM ĐÁNH GIÁ */
    .review-form-container {
        background: #111;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #2a2a2a;
        margin-bottom: 35px;
    }

    .rating-form-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 5px;
    }

    .rating-form-stars input {
        display: none;
    }

    .rating-form-stars label {
        font-size: 1.8rem;
        color: #333;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
    }

    .rating-form-stars input:checked~label,
    .rating-form-stars label:hover,
    .rating-form-stars label:hover~label {
        color: #C5A059;
    }

    .rating-form-stars label:hover {
        transform: scale(1.1);
    }

    .review-textarea, .review-file-input {
        background: #1a1a1a !important;
        border: 2px solid #333 !important;
        color: #e0e0e0 !important;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .review-textarea {
        padding: 15px;
        resize: vertical;
    }

    .review-file-input {
        padding: 10px;
        font-size: 0.9rem;
        color: #aaa !important;
        cursor: pointer;
    }

    .review-textarea:focus, .review-file-input:focus {
        outline: none;
        border-color: #C5A059 !important;
        box-shadow: 0 0 15px rgba(197, 160, 89, 0.2) !important;
        background: #151515 !important;
    }
    
    .review-textarea::placeholder {
        color: #666;
    }

    /* NÚT GỬI ĐÁNH GIÁ */
    .btn-submit-review {
        background: linear-gradient(135deg, #C5A059, #a08045);
        color: #000;
        border: none;
        padding: 12px 35px;
        border-radius: 30px;
        font-weight: 700;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-submit-review:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(197, 160, 89, 0.4);
        background: linear-gradient(135deg, #d4b36a, #C5A059);
    }

    /* DANH SÁCH BÌNH LUẬN */
    .review-item {
        background: #151515;
        border: 1px solid #222;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        transition: border-color 0.3s;
    }
    
    .review-item:hover {
        border-color: #333;
    }

    .review-user {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .review-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #C5A059;
    }

    .review-name {
        color: #f0f0f0;
        font-weight: 600;
        font-size: 1rem;
    }

    .review-stars i {
        color: #C5A059;
        font-size: 0.9rem;
    }

    .review-content {
        color: #ccc;
        font-size: 0.95rem;
        line-height: 1.6;
        padding-left: 52px;
    }

    /* ẢNH ĐÍNH KÈM TRONG BÌNH LUẬN */
    .review-attached-images {
        display: flex;
        gap: 12px;
        margin-top: 15px;
        padding-left: 52px;
        flex-wrap: wrap;
    }

    .review-img-item {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #333;
        cursor: pointer;
        transition: all 0.3s;
    }

    .review-img-item:hover {
        border-color: #C5A059;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(197, 160, 89, 0.3);
    }
</style>

<div class="rating-block">

    {{-- ĐIỂM TRUNG BÌNH --}}
    <div class="rating-summary">
        <div class="rating-stars">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= round($sp->so_sao_trung_binh))
                    <i class="bi bi-star-fill"></i>
                @else
                    <i class="bi bi-star"></i>
                @endif
            @endfor
        </div>
        <strong style="color:#C5A059; font-size: 1.5rem;">{{ $sp->so_sao_trung_binh }}/5</strong>
        <span class="rating-count">({{ $sp->so_luong_danh_gia }} đánh giá)</span>
    </div>

    {{-- FORM GỬI ĐÁNH GIÁ --}}
    @auth
    <div class="review-form-container">
        {{-- Thêm enctype="multipart/form-data" để cho phép up file --}}
        <form action="{{ route('danhgia.store', $sp->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center gap-3 mb-3">
                <span style="color: #e0e0e0; font-weight: 600;">Đánh giá của bạn:</span>
                <div class="rating-form-stars mb-0">
                    <input type="radio" name="so_sao" id="star5" value="5" checked><label for="star5"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="so_sao" id="star4" value="4"><label for="star4"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="so_sao" id="star3" value="3"><label for="star3"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="so_sao" id="star2" value="2"><label for="star2"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="so_sao" id="star1" value="1"><label for="star1"><i class="bi bi-star-fill"></i></label>
                </div>
            </div>
            
            <textarea name="noi_dung" class="form-control review-textarea mb-3" rows="3"
                placeholder="Chia sẻ cảm nhận của bạn về chất liệu, form dáng của sản phẩm... (Không bắt buộc)"></textarea>
            
            {{-- THÊM Ô CHỌN ẢNH --}}
            <div class="mb-4">
                <label style="color:#aaa; font-size:0.85rem; margin-bottom:8px; display:block;">
                    <i class="bi bi-camera"></i> Đính kèm ảnh thực tế (Tối đa 3 ảnh)
                </label>
                <input type="file" name="hinh_anh[]" multiple accept="image/jpeg, image/png, image/jpg, image/webp" 
                       class="form-control review-file-input" id="reviewImageInput">
                <small class="text-danger mt-1 d-none" id="imageWarning">Chỉ được chọn tối đa 3 ảnh!</small>
            </div>
                
            <div class="text-end">
                <button type="submit" class="btn-submit-review" id="btnSubmitReview">
                    <i class="bi bi-send-fill"></i> Gửi Đánh Giá
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="review-form-container text-center py-4">
        <p style="color:#888; font-size:1rem; margin-bottom: 15px;">
            Vui lòng đăng nhập để có thể để lại nhận xét và ảnh thực tế cho sản phẩm này.
        </p>
        <a href="{{ route('login') }}" class="btn-submit-review" style="display:inline-flex; text-decoration: none;">
            <i class="bi bi-person-circle"></i> Đăng Nhập Ngay
        </a>
    </div>
    @endauth

    {{-- DANH SÁCH ĐÁNH GIÁ --}}
    <div class="review-list">
        @forelse($sp->danhGia()->with('user')->latest()->get() as $dg)
        <div class="review-item">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; margin-bottom: 10px;">
                <div class="review-user" style="margin-bottom: 0;">
                    <img src="{{ $dg->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($dg->user->name).'&background=C5A059&color=000' }}" 
                         class="review-avatar" alt="{{ $dg->user->name }}">
                    
                    <div>
                        <div class="review-name">{{ $dg->user->name }}</div>
                        <div class="review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $dg->so_sao)
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                            <span style="color: #666; font-size: 0.8rem; margin-left: 8px;">
                                {{ $dg->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                @if(auth()->check() && (auth()->id() === $dg->user_id || auth()->user()->quyen === 'Admin'))
                <form action="{{ route('danhgia.destroy', $dg->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: transparent; border: none; color: #ff4444; font-size: 1.1rem; cursor: pointer; padding: 5px;">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
                @endif
            </div>
            
            @if($dg->noi_dung)
            <div class="review-content">{{ $dg->noi_dung }}</div>
            @endif

            {{-- HIỂN THỊ ẢNH ĐÍNH KÈM NẾU CÓ --}}
            @if(!empty($dg->hinh_anh) && is_array($dg->hinh_anh))
            <div class="review-attached-images">
                @foreach($dg->hinh_anh as $img)
                    <img src="{{ asset('images/reviews/' . $img) }}" 
                         class="review-img-item" 
                         alt="Ảnh đánh giá" 
                         onclick="window.open(this.src, '_blank')"
                         title="Nhấp để xem ảnh lớn">
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-5" style="background: #111; border-radius: 12px; border: 1px dashed #333;">
            <i class="bi bi-chat-square-text" style="font-size: 2.5rem; color: #444; margin-bottom: 10px; display: block;"></i>
            <p style="color:#777; font-size:1rem; margin: 0;">Chưa có đánh giá nào. Hãy là người đầu tiên nhận xét sản phẩm này!</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    // Kiểm tra số lượng ảnh trước khi gửi
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('reviewImageInput');
        const warningText = document.getElementById('imageWarning');
        const submitBtn = document.getElementById('btnSubmitReview');

        if(fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 3) {
                    warningText.classList.remove('d-none');
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.5';
                    submitBtn.style.cursor = 'not-allowed';
                } else {
                    warningText.classList.add('d-none');
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                }
            });
        }
    });
</script>