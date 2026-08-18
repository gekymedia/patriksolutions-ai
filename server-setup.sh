#!/bin/bash
set -e
APP_DIR=/home/gekymedia/web/ai.patriksolutions.com/public_html
MAIN_ENV=/home/gekymedia/web/patriksolutions.com/public_html/.env
cd "$APP_DIR"

cp .env.example .env

python3 << 'PY'
import re
from pathlib import Path

main = Path("/home/gekymedia/web/patriksolutions.com/public_html/.env").read_text()
env = Path(".env").read_text()

def get(key):
    m = re.search(rf"^{re.escape(key)}=(.*)$", main, re.M)
    return m.group(1).strip().strip('"') if m else ""

overrides = {
    "APP_URL": "https://ai.patriksolutions.com",
    "APP_ENV": "production",
    "APP_DEBUG": "false",
    "DB_CONNECTION": "mysql",
    "DB_HOST": get("DB_HOST") or "127.0.0.1",
    "DB_PORT": get("DB_PORT") or "3306",
    "DB_DATABASE": "gekymedia_patriksolutions_ai",
    "DB_USERNAME": get("DB_USERNAME"),
    "DB_PASSWORD": get("DB_PASSWORD"),
}

for key, val in overrides.items():
    pattern = rf"^{re.escape(key)}=.*$"
    replacement = f'{key}="{val}"' if re.search(r'[#"\s]', val) else f"{key}={val}"
    if re.search(pattern, env, re.M):
        env = re.sub(pattern, replacement, env, flags=re.M)
    else:
        env += f"\n{replacement}\n"

Path(".env").write_text(env)
PY

mariadb -e "CREATE DATABASE IF NOT EXISTS gekymedia_patriksolutions_ai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

php artisan key:generate --force
chown -R gekymedia:gekymedia "$APP_DIR"
chmod -R 775 storage bootstrap/cache

npm ci --silent
npm run build

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link 2>/dev/null || true
php artisan optimize

echo "DEPLOY_OK"
