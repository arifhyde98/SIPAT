FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd intl mysqli pdo_mysql zip \
    && a2enmod rewrite headers \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/sipat.ini
COPY docker/entrypoint.sh /usr/local/bin/sipat-entrypoint
RUN sed -i 's/\r$//' /usr/local/bin/sipat-entrypoint \
    && chmod +x /usr/local/bin/sipat-entrypoint

WORKDIR /var/www/html

ENTRYPOINT ["sipat-entrypoint"]
CMD ["apache2-foreground"]
