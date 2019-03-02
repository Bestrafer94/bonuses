FROM php:7.3-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu-5.1.17
RUN docker-php-ext-enable apcu

RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update -qq && apt-get install -y -qq \
    unzip \
    libicu-dev \
    git \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev

RUN docker-php-ext-install -j$(nproc) zip

WORKDIR /usr/src/app

COPY ./ /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
