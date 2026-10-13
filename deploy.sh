#!/usr/bin/env bash
# Deploy ai.patriksolutions.com (Docker app on the Hostinger VPS).
# Run this ON THE SERVER (Hostinger > VPS > Browser terminal, or SSH as root).
# Usage:  bash deploy.sh
set -euo pipefail

APP_DIR="/docker/client-sites/apps/ai-patriksolutions"
CONTAINER="client-sites-ai-patriksolutions-1"
BRANCH="feature/course-access"
STAMP="$(date +%F_%H%M)"

echo ">> Switching to app dir: $APP_DIR"
cd "$APP_DIR"

echo ">> Backing up .env + app code to /root ..."
cp -a .env "/root/ai_env_backup_${STAMP}.bak" 2>/dev/null || true
tar -czf "/root/ai_app_backup_${STAMP}.tar.gz" --exclude='./node_modules' --exclude='./vendor' . 2>/dev/null || true

echo ">> Pulling latest code ($BRANCH) ..."
git fetch origin
git reset --hard "origin/${BRANCH}"
chown -R 1000:1000 .

echo ">> Running database migrations (safe no-op if none) ..."
docker exec "$CONTAINER" php artisan migrate --force

echo ">> Rebuilding caches ..."
docker exec "$CONTAINER" php artisan optimize:clear
docker exec "$CONTAINER" php artisan config:cache
docker exec "$CONTAINER" php artisan route:cache
docker exec "$CONTAINER" php artisan view:cache

echo ">> DEPLOY DONE. Now on commit: $(git rev-parse --short HEAD)"
