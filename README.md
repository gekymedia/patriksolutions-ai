# patriksolutions-ai

Standalone AI learning platform for **ai.patriksolutions.com**.

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm ci && npm run build
php artisan serve
```

## Production path

`/home/gekymedia/web/ai.patriksolutions.com/public_html`
