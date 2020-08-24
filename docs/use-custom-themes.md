# How to use custom themes

In order to install a custom theme create a `docker-compose.override.yml` with the following contents:
```
version: '3.4'

services:
    php:
        environment:
            - CUSTOM_OVERRIDE=true
        volumes:
            - .:/srv/sylius:rw,cached
            - ./themes/webpack_encore.yaml:/srv/sylius/config/packages/dev/webpack_encore.yaml
            - ./themes/webpack_encore.yaml:/srv/sylius/config/packages/prod/webpack_encore.yaml

    enqueue_consumer:
        volumes:
            - .:/srv/sylius:rw,cached
            - ./themes/webpack_encore.yaml:/srv/sylius/config/packages/dev/webpack_encore.yaml
            - ./themes/webpack_encore.yaml:/srv/sylius/config/packages/prod/webpack_encore.yaml

    nginx:
        volumes:
            - ./public:/srv/sylius/public:ro,delegated

    nodejs:
        image: vaachar/sylius_nodejs:${TAG_VERSION:-latest}
        build:
            context: .
            target: sylius_nodejs
        depends_on:
            - php
        environment:
            - PHP_HOST=php
            - PHP_PORT=9000
        volumes:
            - .:/srv/sylius:rw,cached
```

Then create the `themes/webpack_encore.yaml` with the following contents and replace the `<...>` parts accordingly:
```
webpack_encore:
    builds:
        <themeBuildName>: '%kernel.project_dir%/public/assets/<theme-assets-dir>'
```

Then create the file `themes/themes.webpack.config.js` with the following content (modify to your needs):
```
const myThemeConfig = require('./<theme-dir>/webpack.config');

module.exports = [myThemeConfig];
```
