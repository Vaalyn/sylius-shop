#!/bin/sh
set -e

# Build templates into finished files
dockerize \
    -template "/etc/nginx/conf.d/default.conf.tmpl:/etc/nginx/conf.d/default.conf"
