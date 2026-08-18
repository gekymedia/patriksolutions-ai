# ai.patriksolutions.com Production Deployment
# Server: gekymedia.com
# Path: /home/gekymedia/web/ai.patriksolutions.com/public_html

Write-Host "Building frontend assets..." -ForegroundColor Cyan
npm ci
npm run build
if ($LASTEXITCODE -ne 0) { throw "Vite build failed" }

Write-Host "Pushing to GitHub..." -ForegroundColor Cyan
git add .
git commit -m "Deploy: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
if ($LASTEXITCODE -ne 0) { Write-Host "No changes to commit" -ForegroundColor Yellow }
git push origin main

Write-Host "Deploying to ai.patriksolutions.com..." -ForegroundColor Cyan
$remoteCmd = @'
cd /home/gekymedia/web/ai.patriksolutions.com/public_html && \
git pull origin main && \
chown -R gekymedia:gekymedia storage bootstrap/cache && \
chmod -R 775 storage bootstrap/cache && \
composer install --no-dev --optimize-autoloader && \
npm ci --silent && npm run build && \
php artisan migrate --force && \
php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && \
php artisan storage:link || true
'@
ssh root@gekymedia.com $remoteCmd
