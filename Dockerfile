# استخدام نسخة PHP 8.4 الرسمية مع Apache
FROM php:8.4-apache

# تثبيت الإضافات اللازمة لـ Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    curl

# تثبيت إضافات PHP الضرورية
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# تفعيل موديل Rewrite في Apache
RUN a2enmod rewrite

# ضبط المجلد الرئيسي ليكون public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# نسخ ملفات المشروع
COPY . /var/www/html

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تثبيت المكتبات
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs --no-scripts

# ضبط الصلاحيات بشكل كامل (هذا هو حل خطأ 500)
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html

# تشغيل السيرفر
CMD php artisan key:generate --force && apache2-foreground
