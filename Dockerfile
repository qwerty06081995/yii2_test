FROM php:8.4-fpm

# Установка зависимостей для PHP и composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    default-mysql-client \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Автоматически выполнить composer install
COPY ./www /var/www/html
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Задаем рабочую директорию
WORKDIR /var/www/html
