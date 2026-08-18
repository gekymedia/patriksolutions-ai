#!/bin/bash
set -e
APP_DIR=/home/gekymedia/web/ai.patriksolutions.com/public_html
MAIN_ENV=/home/gekymedia/web/patriksolutions.com/public_html/.env
cd "$APP_DIR"

git pull origin main
composer install --no-dev --optimize-autoloader --no-interaction
npm ci --silent && npm run build

# Copy Stripe keys from main site if not set
if ! grep -q "^STRIPE_SECRET_KEY=" .env || grep -q "^STRIPE_SECRET_KEY=$" .env; then
  for key in STRIPE_PUBLISHABLE_KEY STRIPE_SECRET_KEY STRIPE_WEBHOOK_SECRET STRIPE_TEST_MODE; do
    val=$(grep "^${key}=" "$MAIN_ENV" 2>/dev/null | cut -d= -f2- || true)
    if [ -n "$val" ]; then
      if grep -q "^${key}=" .env; then
        sed -i "s|^${key}=.*|${key}=${val}|" .env
      else
        echo "${key}=${val}" >> .env
      fi
    fi
  done
fi

php artisan migrate --force
php artisan optimize:clear
php artisan optimize
chown -R gekymedia:gekymedia "$APP_DIR"
chmod -R 775 storage bootstrap/cache
echo "DEPLOY_OK"
