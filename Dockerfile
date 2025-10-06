# syntax=docker/dockerfile:1.7

ARG PHP_VERSION=8.3

FROM composer:2 AS composer_deps
WORKDIR /var/www/html
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts

FROM node:20-alpine AS frontend
WORKDIR /var/www/html
COPY package*.json ./
RUN npm install
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

FROM php:${PHP_VERSION}-fpm-alpine AS app_base
ENV APP_ENV=production \
    APP_DEBUG=false \
    APP_ROOT=/var/www/html
WORKDIR ${APP_ROOT}

RUN apk add --no-cache \
        bash \
        git \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        sqlite-dev \
        zip \
        unzip \
        shadow \
        su-exec \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        intl \
        pdo_mysql \
        pdo_sqlite \
        gd \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /tmp/pear

COPY --from=composer_deps /usr/bin/composer /usr/bin/composer

COPY . .
COPY --from=composer_deps /var/www/html/vendor ./vendor
COPY --from=composer_deps /var/www/html/composer.lock ./composer.lock
COPY --from=frontend /var/www/html/public/build ./public/build

RUN set -eux; \
    mkdir -p storage/framework/cache/data storage/logs bootstrap/cache; \
    rm -rf public/storage; \
    ln -s ../storage/app/public public/storage; \
    chown -R www-data:www-data storage bootstrap/cache; \
    chmod -R ug+rwX storage bootstrap/cache

FROM app_base AS app
COPY docker/app/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
EXPOSE 9000
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

FROM nginx:1.27-alpine AS web
ENV APP_ROOT=/var/www/html \
    NGINX_SERVER_NAME=_
WORKDIR ${APP_ROOT}
RUN apk add --no-cache gettext
COPY --from=app_base ${APP_ROOT}/public ${APP_ROOT}/public
COPY --from=app_base ${APP_ROOT}/storage ${APP_ROOT}/storage
COPY docker/nginx/default.conf.template /etc/nginx/templates/default.conf.template
COPY docker/nginx/docker-entrypoint.d/ /docker-entrypoint.d/
RUN chmod +x /docker-entrypoint.d/*.sh
EXPOSE 80
