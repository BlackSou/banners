FROM php:8.2-fpm-alpine

# Install required packages
RUN apk --no-cache add curl git build-base zlib-dev oniguruma-dev autoconf bash libpq libpq-dev rabbitmq-c rabbitmq-c-dev

# Install the amqp extension
RUN docker-php-ext-install pdo_pgsql
RUN pecl install amqp && docker-php-ext-enable amqp pdo_pgsql

# Configure non-root user.
RUN apk --no-cache add shadow

# Copy source code
COPY ../.. /var/www
WORKDIR /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 8080