FROM php:8.4-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git unzip curl default-mysql-client libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/www  # <- рабочая директория внутри volume

# Копируем только composer.json и composer.lock
COPY ./www/composer.json ./www/composer.lock ./

# Выполняем composer install внутри www
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Копируем весь проект внутрь www
COPY ./www ./

# Права для runtime и assets
RUN mkdir -p runtime web/assets && chmod -R 777 runtime web/assets

CMD ["php-fpm"]
