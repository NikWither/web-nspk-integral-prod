#!/usr/bin/env sh
set -e

APP_ROOT=${APP_ROOT:-/var/www/html}
APP_USER=${APP_USER:-www-data}
APP_GROUP=${APP_GROUP:-www-data}

log() {
    printf '[entrypoint] %s\n' "$1" >&2
}

ensure_dir() {
    [ -d "$1" ] || mkdir -p "$1"
}

ensure_dir "$APP_ROOT/storage/framework/cache/data"
ensure_dir "$APP_ROOT/storage/logs"
ensure_dir "$APP_ROOT/storage/app/public"
ensure_dir "$APP_ROOT/bootstrap/cache"

if [ "${SKIP_CHOWN:-false}" != "true" ] && [ "${APP_ENV}" != "local" ]; then
    chown -R "$APP_USER":"$APP_GROUP" "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache"
    chmod -R ug+rwX "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache"
fi

if [ ! -f "$APP_ROOT/storage/logs/laravel.log" ]; then
    touch "$APP_ROOT/storage/logs/laravel.log"
fi

if [ "${SKIP_CHOWN:-false}" != "true" ] && [ "${APP_ENV}" != "local" ]; then
    chown "$APP_USER":"$APP_GROUP" "$APP_ROOT/storage/logs/laravel.log"
fi

if [ "${DB_CONNECTION}" = "sqlite" ]; then
    SQLITE_PATH=${DB_DATABASE:-$APP_ROOT/database/database.sqlite}
    case "$SQLITE_PATH" in
        /*) ;;
        *) SQLITE_PATH="$APP_ROOT/$SQLITE_PATH" ;;
    esac
    ensure_dir "$(dirname "$SQLITE_PATH")"
    if [ ! -f "$SQLITE_PATH" ]; then
        log "Creating sqlite database at $SQLITE_PATH"
        touch "$SQLITE_PATH"
    fi
    if [ "${SKIP_CHOWN:-false}" != "true" ] && [ "${APP_ENV}" != "local" ]; then
        chown "$APP_USER":"$APP_GROUP" "$SQLITE_PATH"
    fi
fi

if [ -f "$APP_ROOT/artisan" ]; then
    if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
        log "Running database migrations"
        su-exec "$APP_USER":"$APP_GROUP" php artisan migrate --force --no-ansi || {
            log "Migrations failed"; exit 1; }
    fi

    if [ "${APP_ENV}" = "production" ] && [ "${SKIP_ARTISAN_OPTIMIZE:-false}" != "true" ]; then
        log "Optimizing framework caches"
        su-exec "$APP_USER":"$APP_GROUP" php artisan optimize --no-ansi >/dev/null 2>&1 || log "artisan optimize skipped"
    fi
fi

exec "$@"
