FROM php:8.0-fpm

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y \
    g++ \
    zlib1g-dev \
    libbz2-dev \
    libicu-dev \
    zip \
    libzip-dev \
    memcached \
    wget \
    unzip \
    libmemcached-dev \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && pecl install memcached && docker-php-ext-enable memcached \
    && apt-get remove -y g++ wget \
    && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/* /var/tmp/* \
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini