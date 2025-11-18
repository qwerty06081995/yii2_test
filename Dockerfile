FROM php:8.4-fpm

# Установка зависимостей PHP и MySQL client
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

# Создаём рабочую директорию
WORKDIR /var/www/html

# Копируем весь проект в контейнер
COPY ./ /var/www/html

# Запуск composer install при сборке контейнера
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Даем права на запись для runtime и web/assets (если нужно)
RUN mkdir -p runtime web/assets && chmod -R 777 runtime web/assets

# Устанавливаем рабочую директорию на web для nginx
WORKDIR /var/www/html
