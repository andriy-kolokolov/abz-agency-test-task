FROM node:lts-alpine AS frontend_build

WORKDIR /srv/app
COPY client/package*.json ./
RUN npm install
COPY client/. .
RUN npm run build

FROM php:8.2-fpm-alpine AS backend

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

COPY --from=composer/composer:2-bin --link /composer /usr/bin/composer

COPY server/composer.* ./
RUN set -eux; \
	composer install --prefer-dist --no-autoloader --no-scripts --no-progress; \
	composer clear-cache

COPY --link server . ./
COPY --chown=www-data:www-data --link . .
COPY --chown=www-data:www-data --from=frontend_build --link /srv/app/public public/
RUN mkdir -p ./storage/framework/views \
    && mkdir -p ./storage/framework/cache \
    && mkdir -p ./storage/framework/sessions \
    && mkdir -p ./bootstrap/cache

RUN chown www-data.www-data -R storage/ \
    && chown www-data.www-data -R vendor/ \
    && chown www-data.www-data -R bootstrap/

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

USER www-data:www-data

FROM nginx:1.25.1-alpine AS nginx

WORKDIR /srv/app

COPY --from=frontend_build --link /srv/app/dist /srv/app/public
COPY --link docker/nginx/templates /etc/nginx/templates