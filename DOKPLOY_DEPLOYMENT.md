# Dokploy Deployment Guide (This Project)

This project is now configured for Dokploy using a multi-stage Docker build with Laravel + Filament + Inertia Vue and a Smarty demo route.

## What Was Added

- `Dockerfile` (multi-stage build)
- `.dockerignore`
- `docker/start.sh`
- `docker/nginx/default.conf`
- `docker/php/php-fpm.conf`
- `docker/php/opcache.ini`
- `docker/php/uploads.ini`
- `docker/supervisor/supervisord.conf`

## Runtime Model

Single container running under Supervisor:

- Nginx
- PHP-FPM
- Laravel queue worker
- Laravel scheduler (`schedule:work`)

Frontend assets are built at image build time and copied to `public/build`.

## Dokploy App Settings

- Build source: repository root
- Dockerfile: `Dockerfile`
- Exposed container port: `80`

## Required Environment Variables

Minimum required:

- `APP_NAME`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.com`
- `APP_KEY=base64:...`
- `DB_CONNECTION=mysql`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `CACHE_STORE`
- `QUEUE_CONNECTION`
- `SESSION_DRIVER`
- `RUN_MIGRATIONS=true` (first deploy only)

You can copy from the provided template and paste into Dokploy env settings:

- `.env.dokploy.example`

Optional (Redis):

- `REDIS_HOST`
- `REDIS_PASSWORD`
- `REDIS_PORT`

## First Deployment Checklist

1. Push this branch to your connected Dokploy repository.
2. Copy values from `.env.dokploy.example` into Dokploy and replace placeholders.
3. Deploy with `RUN_MIGRATIONS=true`.
4. Validate:
   - storefront (`/`)
   - Filament admin (`/admin`)
   - Smarty demo (`/smarty/products`)
5. Confirm queue and scheduler are running.
6. Set `RUN_MIGRATIONS=false` for normal redeploys.

## Post-Deploy Validation

Run in the container shell:

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan config:show app.env
```

## Notes

- Production requires `APP_DEBUG=false`.
- Keep secrets in Dokploy env vars only.
- If you see Vite manifest errors, ensure the image build succeeds and `public/build` exists in the running container.
