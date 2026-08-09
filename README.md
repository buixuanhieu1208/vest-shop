# Kingsman Shop Vest 

Website thương mại điện tử bán vest online, xây dựng bằng Laravel. Dự án cá nhân, phát triển từ thiết kế cơ sở dữ liệu, giao diện đến triển khai (deploy) thực tế.

**Live Demo:** [vest-shop.onrender.com](https://vest-shop.onrender.com)
*(Lưu ý: server dùng gói Free của Render, nếu không có truy cập trong ~15 phút sẽ tự "ngủ", lần load đầu tiên sau đó có thể mất 30-60s để khởi động lại.)*

---

## Giới thiệu

Kingsman Shop Vest là website bán vest/suit cao cấp theo phong cách sang trọng (theme đen - vàng gold), phục vụ cả khách hàng (mua sắm) và quản trị viên (quản lý sản phẩm, đơn hàng, người dùng).

## Tính năng chính

**Dành cho khách hàng:**
- Xem danh sách sản phẩm, lọc theo danh mục, tìm kiếm theo tên/chất liệu/xuất xứ
- Xem chi tiết sản phẩm, đánh giá sản phẩm theo thang 5 sao
- Giỏ hàng: thêm/sửa số lượng/xóa sản phẩm theo size
- Đặt hàng, thanh toán
- Đăng ký, đăng nhập, quản lý trang cá nhân (đổi avatar, thông tin liên hệ)

**Dành cho quản trị viên (Admin):**
- Quản lý sản phẩm (CRUD: thêm/sửa/xóa)
- Quản lý người dùng (đổi quyền, khóa/xóa tài khoản)
- Quản lý đơn hàng (cập nhật trạng thái: chờ xử lý, đang giao, hoàn thành, đã hủy)
- Thống kê doanh thu, sản phẩm bán chạy, đơn hàng theo trạng thái

## Công nghệ sử dụng

**Back-end:**
- PHP 8.3, Laravel Framework
- MySQL
- Eloquent ORM

**Front-end:**
- HTML5, CSS3, JavaScript
- Bootstrap 5
- Blade Template Engine

**Triển khai (Deployment):**
- Docker
- [Render](https://render.com) — hosting web service (Free tier)
- [Clever Cloud](https://www.clever-cloud.com) — MySQL database (Free tier)

## Cấu trúc thư mục chính

```
app/
├── Http/Controllers/      # Xử lý logic (SanPham, GioHang, DangNhap, NguoiDung, ThongKe, Profile, DanhGia...)
├── Models/                 # Eloquent models (SanPham, User, HoaDon, DanhGia...)
resources/
├── views/
│   ├── layouts/            # Layout dùng chung (default_layout, auth_layout)
│   ├── *.blade.php         # Các trang (trang chủ, sản phẩm, giỏ hàng, đăng nhập...)
database/
├── migrations/             # Cấu trúc bảng database
routes/
├── web.php                 # Định nghĩa route
Dockerfile                  # Cấu hình build & deploy qua Docker
```

## Cài đặt & chạy local

### Yêu cầu
- PHP >= 8.3
- Composer
- MySQL
- Node.js (nếu cần build asset front-end)

### Các bước

1. Clone repository:
```bash
git clone https://github.com/buixuanhieu1208/vest-shop.git
cd vest-shop
```

2. Cài đặt package PHP:
```bash
composer install
```

3. Tạo file môi trường và sinh APP_KEY:
```bash
cp .env.example .env
php artisan key:generate
```

4. Cấu hình kết nối database trong file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shop_vest
DB_USERNAME=root
DB_PASSWORD=
```

5. Chạy migration để tạo bảng:
```bash
php artisan migrate
```

6. Khởi chạy server:
```bash
php artisan serve
```

Truy cập tại: `http://127.0.0.1:8000`

## Deploy bằng Docker

Project đã có sẵn `Dockerfile` để deploy lên các nền tảng hỗ trợ Docker (Render, Railway, Fly.io...). Container sẽ tự động chạy migration khi khởi động.

## Tác giả

**Bùi Xuân Hiếu**
- GitHub: [@buixuanhieu1208](https://github.com/buixuanhieu1208)
- Email: buixuanhieu11b08@gmail.com

---

