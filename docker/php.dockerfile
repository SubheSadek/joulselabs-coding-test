FROM php:8.4-fpm-alpine

ENV PHPGROUP=sellnow
ENV PHPUSER=sellnow

# Create user
RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

# PHP-FPM config
RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

# ⭐ Install system dependencies FIRST
RUN apk add --no-cache \
    postgresql-dev \
    bash \
    tar \
    gzip \
    bzip2 \
    xz

# Install PHP extension installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# ⭐ Install extensions one by one (more reliable)
RUN install-php-extensions pdo_mysql && \
    install-php-extensions pdo_pgsql && \
    install-php-extensions pgsql && \
    install-php-extensions opcache && \
    install-php-extensions pcntl && \
    install-php-extensions bcmath

# Verify installation
RUN php -m | grep -E 'pdo_pgsql|pgsql'

WORKDIR /var/www/SellNow

CMD ["php-fpm", "-F"]