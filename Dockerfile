# -------- PHP-FPM с расширениями для Laravel + SQLite --------
FROM php:8.3-fpm-alpine

# Системные пакеты и PHP-расширения
RUN set -eux; \
    apk add --no-cache \
      bash git unzip icu-dev libpng-dev libjpeg-turbo-dev libwebp-dev libzip-dev oniguruma-dev \
      sqlite sqlite-dev; \
    docker-php-ext-configure gd --with-jpeg --with-webp; \
    docker-php-ext-install -j$(nproc) \
      intl gd exif bcmath pdo pdo_sqlite opcache; \
    # опкеш по умолчанию
    { \
      echo 'opcache.enable=1'; \
      echo 'opcache.enable_cli=1'; \
      echo 'opcache.validate_timestamps=0'; \
      echo 'opcache.memory_consumption=128'; \
      echo 'opcache.max_accelerated_files=20000'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория проекта
WORKDIR /var/www/html

# Если кладёте проект в контейнер при билде — раскомментируйте:
# COPY . /var/www/html

# Права для storage и bootstrap/cache (на случай пустых каталогов)
RUN mkdir -p storage bootstrap/cache database && \
    touch database/database.sqlite && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Ускоряем Composer и не требуем суперпользователя
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer --version

# Запускается php-fpm по умолчанию
CMD ["php-fpm", "-F"]
