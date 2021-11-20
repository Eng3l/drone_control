FROM php:8.0-fpm


RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
    pecl install apcu && \
    docker-php-ext-install -j$(nproc) zip opcache intl && \
    docker-php-ext-enable apcu sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o ;bin/console doctrine:migrations:migrate; bin/console -q doctrine:fixtures:load;  php-fpm 

EXPOSE 9000
