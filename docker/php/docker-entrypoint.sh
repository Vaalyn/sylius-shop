#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
    mkdir -p var/cache var/log public/media public/media/image public/media/banner-image
    chown -R www-data:www-data var public/media
    chmod -R a+rw var public/media

    # Build templates into finished files
    dockerize \
        -template "/usr/local/etc/php/php.ini.tmpl:/usr/local/etc/php/php.ini" \
        -template "/usr/local/etc/php/php-cli.ini.tmpl:/usr/local/etc/php/php-cli.ini" \
        -template "/srv/sylius/webpack.config.js.tmpl:/srv/sylius/webpack.config.js"

    if [ "$APP_ENV" != 'prod' ] && [ "$ENQUEUE_CONSUMER" != 'true' ]; then
        composer install --prefer-dist --no-progress --no-suggest --no-interaction
        bin/console assets:install --no-interaction
        bin/console sylius:theme:assets:install public --no-interaction
    fi

    until bin/console doctrine:query:sql "select 1" >/dev/null 2>&1; do
        (>&2 echo "Waiting for MySQL to be ready...")
        sleep 1
    done

    if [ "$(ls -A src/Migrations/*.php 2> /dev/null)" ] && [ "$ENQUEUE_CONSUMER" != 'true' ]; then
        bin/console doctrine:migrations:migrate --no-interaction
    fi

    bin/console cache:clear --env=$APP_ENV
    chown -R www-data:www-data var
fi

exec docker-php-entrypoint "$@"
