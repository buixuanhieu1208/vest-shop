# Dockerfile để deploy Laravel lên Render.com
FROM php:8.3-apache

# Cài các extension PHP cần thiết cho Laravel + MySQL
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Bật mod_rewrite cho Apache (Laravel cần để route hoạt động đúng)
RUN a2enmod rewrite

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy toàn bộ code vào container
COPY . .

# Cài package PHP (bỏ qua dev dependencies để nhẹ hơn)
RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p /var/www/html/public/images/reviews
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images


# Cho Apache trỏ vào thư mục public của Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set quyền ghi cho storage và cache (Laravel cần ghi log, cache, session)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Script khởi động: tự động chạy migrate rồi mới start Apache
# (cần thiết vì gói Free của Render không cho phép vào Shell thủ công)
RUN echo '#!/bin/bash\nphp artisan migrate --force\napache2-foreground' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

CMD ["/usr/local/bin/start.sh"]
CMD php artisan config:clear && php artisan cache:clear && php artisan migrate --force && apache2-foreground
