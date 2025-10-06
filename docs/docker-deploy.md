# Docker Deployment Guide

This project now ships with a production-ready Docker setup that builds the application code, PHP-FPM runtime, Nginx web front-end, and an optional MySQL database. Follow the steps below to ship the stack to any VPS.

## 1. Prerequisites
- Docker Engine 24+
- Docker Compose v2 plugin
- A VPS running Linux (Ubuntu 22.04 LTS works great)
- A domain with an A/AAAA record pointing to the VPS IP

## 2. Prepare environment variables
1. Copy the example file and edit secrets for production:
   ```bash
   cp .env.example .env.production
   ```
2. Update at least these keys inside `.env.production`:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://your-domain.com`
   - `APP_KEY` (generate with `php artisan key:generate --show` and paste the value)
   - Database credentials to match the MySQL service or an external DB
3. Export the file path for Compose (optional but keeps commands shorter):
   ```bash
   export APP_ENV_FILE=.env.production
   ```

## 3. Build and start the stack
On the VPS (inside the project root):
```bash
docker compose -f docker-compose.prod.yml --env-file ${APP_ENV_FILE:-.env.production} pull
docker compose -f docker-compose.prod.yml --env-file ${APP_ENV_FILE:-.env.production} build
docker compose -f docker-compose.prod.yml --env-file ${APP_ENV_FILE:-.env.production} up -d
```
The build stage installs Composer dependencies, compiles Vite assets, and bakes everything into the PHP-FPM and Nginx images.

## 4. Post-deploy tasks
- Run database migrations (once per deployment):
  ```bash
  docker compose -f docker-compose.prod.yml run --rm app php artisan migrate --force
  ```
- Warm caches manually if needed:
  ```bash
  docker compose -f docker-compose.prod.yml run --rm app php artisan optimize
  ```
- Tail the logs:
  ```bash
  docker compose -f docker-compose.prod.yml logs -f app web
  ```

## 5. Domain binding & TLS
1. Set `NGINX_SERVER_NAME=your-domain.com` in your `.env.production` (or export it when running Compose). This value is injected into the Nginx config at container start.
2. Point your DNS records to the VPS IP and wait for propagation.
3. For HTTPS you can:
   - Terminate TLS on the host (e.g. install Caddy or Nginx on the VPS and reverse proxy to `web:80`).
   - Or add a companion container such as [nginx-proxy](https://github.com/nginx-proxy/nginx-proxy) with [acme-companion](https://github.com/nginx-proxy/acme-companion) for automated Let's Encrypt certificates.
   - If you prefer manual certificates, mount them to `/etc/nginx/certs` and extend `docker/nginx/default.conf.template` accordingly.

## 6. Optional services
Compose already defines a MySQL container. If you use an external database, remove the `db` service and update the `DB_*` values. For background processing you can add services based on the same PHP image, for example:
```yaml
  queue:
    image: ${APP_IMAGE:-laravel-app}
    command: php artisan queue:work --verbose --tries=3 --timeout=90
    depends_on:
      - app
    env_file:
      - ${APP_ENV_FILE:-.env}
    environment:
      APP_ENV: ${APP_ENV:-production}
```

## 7. Redeploying updates
After pushing new code:
```bash
git pull
docker compose -f docker-compose.prod.yml --env-file ${APP_ENV_FILE:-.env.production} build app web
docker compose -f docker-compose.prod.yml --env-file ${APP_ENV_FILE:-.env.production} up -d app web
```

That's it - the application is ready to run on your VPS using Docker.
