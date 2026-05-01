# استخدام نسخة PHP 8.4 الرسمية مع Apache
FROM php:8.4-apache

# تثبيت الإضافات اللازمة لـ Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# تثبيت إضافات PHP الضرورية
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

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

# 1. إعداد الملفات الأساسية وقاعدة البيانات
RUN touch /var/www/html/.env && \
    mkdir -p /var/www/html/database && \
    touch /var/www/html/database/database.sqlite

# 2. تثبيت المكتبات
RUN composer update --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs --no-scripts

# 3. ضبط الصلاحيات بشكل نهائي
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database && \
    chown -R www-data:www-data /var/www/html

# الطريقة الأفضل: تشغيل الأوامر حتى لو وجد المفتاح، مع مسح الكاش بقوة
CMD php artisan key:generate --force && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear && \
    php artisan migrate --force && \
    apache2-foreground
