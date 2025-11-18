FROM php:8.4-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    default-mysql-client \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Установка Composer глобально
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html/www

# Копируем composer.json и composer.lock, чтобы оптимизировать build
COPY ./www/composer.json ./www/composer.lock ./

# Копируем остальной проект
COPY ./www .

# Перезаписываем рабочую директорию на корень
WORKDIR /var/www/html/www
