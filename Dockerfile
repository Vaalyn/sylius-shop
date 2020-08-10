# the different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/compose/compose-file/#target

ARG PHP_VERSION=7.3
ARG NODE_VERSION=10
ARG NGINX_VERSION=1.16

FROM php:${PHP_VERSION}-fpm-alpine AS sylius_php_stage_1

# persistent / runtime deps
RUN apk add --no-cache \
        acl \
        file \
        gettext \
        git \
        mariadb-client \
        wkhtmltopdf \
        ttf-ubuntu-font-family \
        optipng \
        jpegoptim \
        pngquant \
    ;

RUN apk add --no-cache autoconf automake build-base make cmake libtool nasm zlib

WORKDIR /src/mozjpeg
RUN git clone git://github.com/mozilla/mozjpeg.git ./

RUN cmake -G"Unix Makefiles" -DPNG_SUPPORTED=NO ./ \
  && make install

ARG APCU_VERSION=5.1.17
RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        coreutils \
        freetype-dev \
        icu-dev \
        libjpeg-turbo \
        libjpeg-turbo-dev \
        libpng-dev \
        libtool \
        libwebp-dev \
        libzip-dev \
        mariadb-dev \
        zlib-dev \
    ; \
    \
    docker-php-ext-configure gd --with-jpeg-dir=/usr/local/ --with-png-dir=/usr/include --with-webp-dir=/usr/include --with-freetype-dir=/usr/include/; \
    docker-php-ext-configure zip --with-libzip; \
    docker-php-ext-install -j$(nproc) \
        exif \
        gd \
        intl \
        pdo_mysql \
        zip \
    ; \
    pecl install \
        apcu-${APCU_VERSION} \
    ; \
    pecl clear-cache; \
    docker-php-ext-enable \
        apcu \
        opcache \
    ; \
    \
    runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )"; \
    apk add --no-cache --virtual .sylius-phpexts-rundeps $runDeps; \
    \
    apk del .build-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/php-cli.ini /usr/local/etc/php/php-cli.ini

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
    composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
    composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /srv/sylius

# build for production
ARG APP_ENV=prod

# prevent the reinstallation of vendors at every changes in the source code
COPY composer.json composer.lock symfony.lock ./
RUN set -eux; \
    composer install --prefer-dist --no-autoloader --no-scripts --no-progress --no-suggest; \
    composer clear-cache

# copy only specifically what we need
COPY .env.sample ./.env
COPY bin bin/
COPY config config/
COPY data data/
COPY public public/
COPY src src/
COPY templates templates/
COPY themes themes/
COPY translations translations/

RUN set -eux; \
    mkdir -p var/cache var/log; \
    composer dump-autoload --classmap-authoritative; \
    APP_SECRET='' composer run-script post-install-cmd; \
    chmod +x bin/console; sync; \
    bin/console sylius:install:assets; \
    bin/console sylius:theme:assets:install public
VOLUME /srv/sylius/var

VOLUME /srv/sylius/public/media

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

# NodeJS image
#--------------

FROM node:${NODE_VERSION}-alpine AS sylius_nodejs

WORKDIR /srv/sylius

RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
        g++ \
        gcc \
        git \
        make \
        python \
    ;

# prevent the reinstallation of vendors at every changes in the source code
COPY package.json yarn.lock ./
RUN set -eux; \
    yarn install; \
    yarn cache clean

COPY assets assets/

COPY --from=sylius_php_stage_1 /srv/sylius/config config/
COPY --from=sylius_php_stage_1 /srv/sylius/public public/
COPY --from=sylius_php_stage_1 /srv/sylius/themes themes/
COPY --from=sylius_php_stage_1 /srv/sylius/vendor vendor/

COPY webpack.config.js ./

RUN yarn encore production

COPY docker/nodejs/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["yarn", "encore", "dev", "--watch"]

# PHP image
#-----------

FROM sylius_php_stage_1 AS sylius_php

COPY --from=sylius_nodejs /srv/sylius/public public/

# NGINX image
#-------------

FROM nginx:${NGINX_VERSION}-alpine AS sylius_nginx

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/

WORKDIR /srv/sylius

COPY --from=sylius_nodejs /srv/sylius/public public/

# ElasticSearch image
#---------------------

FROM docker.elastic.co/elasticsearch/elasticsearch:7.4.0 as sylius_elasticsearch

# Install ES plugins
RUN bin/elasticsearch-plugin install analysis-phonetic
RUN bin/elasticsearch-plugin install analysis-icu
