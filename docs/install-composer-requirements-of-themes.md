# How to install composer dependencies of custom themes

In order to install additional composer dependencies you need to add a custom theme to the `themes/` directory with a `composer.json`.

To merge those dependencies with the ones of the main project you need to run `composer update --lock` inside of the php container. (Use `docker exec -it <container_name> sh` to enter the container).

# Adding composer dependencies without a custom theme

Alternatively if you don't use custom themes and still need to add composer dependencies you can just create a new directory in `themes/` and add a `composer.json` just for those dependencies.
