ARG ENVIRONMENT=production

FROM node:lts-alpine AS frontend_build

WORKDIR /srv/app
COPY client/package*.json ./
RUN npm install
COPY client/. .
RUN npm run build

FROM php:8.2-fpm-alpine AS backend
ARG ENVIRONMENT

WORKDIR /srv/app
COPY --from=mlocati/php-extension-installer --link /usr/bin/install-php-extensions /usr/local/bin/
RUN apk add \
		acl \
		fcgi \
		file \
		gettext \
		git \
		mariadb-client \
		mariadb-connector-c \
        nano \
	;

RUN set -eux; \
    install-php-extensions \
        gd \
    	zip \
		pdo_mysql \
        curl \
    ;

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN mkdir -p /var/run/php

COPY --link docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY server/composer.* ./
RUN set -eux; \
	composer install --prefer-dist --no-autoloader --no-scripts --no-progress; \
	composer clear-cache

RUN chown -R www-data:www-data /srv/app/vendor

COPY --link server . ./
RUN cp .env.$ENVIRONMENT .env && \
    chown www-data:www-data .env && \
    chmod 644 .env

# create laravel required directories
RUN mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# Set up permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN chown -R www-data:www-data /srv/app

# for symlinking the public folder
RUN chmod -R 755 /srv/app/public

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

USER www-data:www-data

FROM nginx:1.25.1-alpine AS nginx

WORKDIR /srv/app

COPY --from=frontend_build --link /srv/app/dist /srv/app/public
COPY --link docker/nginx/templates /etc/nginx/templates