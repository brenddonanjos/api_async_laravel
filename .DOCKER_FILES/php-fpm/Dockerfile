FROM php:8.2-fpm

#System dependencies
RUN apt-get update;\
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
    curl\
    libmemcached-dev \
    libz-dev \
	libpng-dev \
	libjpeg-dev \
	libjpeg62-turbo-dev \
	libfreetype-dev \
    libssl-dev \
    libwebp-dev \
    libxpm-dev \
    libmcrypt-dev \
    libzip-dev \
    git\
    unzip \
    zip 

RUN set -eux; \
    docker-php-ext-install pdo_mysql sockets;

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#php debug
RUN pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets

RUN docker-php-ext-install gd

CMD ["php-fpm"]

WORKDIR /var/www

EXPOSE 9000