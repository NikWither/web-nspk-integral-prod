#!/usr/bin/env sh
set -e

: "${NGINX_SERVER_NAME:=_}"

TEMPLATE=/etc/nginx/templates/default.conf.template
TARGET=/etc/nginx/conf.d/default.conf

if [ -f "$TEMPLATE" ]; then
    envsubst '$$NGINX_SERVER_NAME' < "$TEMPLATE" > "$TARGET"
fi
