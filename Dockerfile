# PHP FPM uchun rasmni asos sifatida oling
FROM php:8.3-fpm

# Ishchi katalogni belgilash
WORKDIR /var/www

# PHP uchun kerakli paketlarni o'rnatish
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && apt-get clean

# Composer'ni o'rnatish (Composer rasmidan)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Loyihani konteynerga nusxalash
COPY . /var/www

# PHP paketlarini o'rnatish
RUN composer install

# Katalog va fayllarga kerakli ruxsatlarni berish
RUN chown -R www-data:www-data /var/www \
    && chmod -R 777 /var/www

# Konteyner ishga tushganda, PHP-FPM xizmatini ishga tushirish
CMD ["php-fpm"]
