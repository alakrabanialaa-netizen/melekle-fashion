# PHP 8.4 الرسمي مع Apache
FROM php:8.4-apache

# إضافات النظام اللازمة لـ Laravel
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
    curl \
    && rm -rf /var/lib/apt/lists/*

# إضافات PHP
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

# تفعيل Rewrite
RUN a2enmod rewrite

# جعل public هو مجلد Apache الرئيسي
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# نسخ المشروع
COPY . /var/www/html

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ملفات Laravel الأساسية
RUN touch /var/www/html/.env \
    && mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite

# تثبيت المكتبات
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs --no-scripts

# الصلاحيات
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chown -R www-data:www-data /var/www/html

# Render يحدد PORT تلقائياً؛ 10000 قيمة احتياطية محلية
ENV PORT=10000

# تشغيل Apache على 0.0.0.0 وعلى PORT الخاص بـ Render
CMD ["/bin/sh", "-c", "set -e; PORT=${PORT:-10000}; sed -ri \"s!^Listen .*!Listen 0.0.0.0:${PORT}!\" /etc/apache2/ports.conf; sed -ri \"s!<VirtualHost [^>]+>!<VirtualHost 0.0.0.0:${PORT}>!g\" /etc/apache2/sites-enabled/*.conf; printf '%s\\n' 'ServerName localhost' > /etc/apache2/conf-available/servername.conf; a2enconf servername >/dev/null; php artisan config:clear; php artisan cache:clear; rm -rf bootstrap/cache/*.php; exec apache2-foreground"]
