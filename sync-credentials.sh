#!/bin/bash
set -e
MAIN=/home/gekymedia/web/patriksolutions.com/public_html/.env
AI=/home/gekymedia/web/ai.patriksolutions.com/public_html/.env

python3 << 'PYEOF'
import re
from pathlib import Path

main = {}
for line in Path("/home/gekymedia/web/patriksolutions.com/public_html/.env").read_text().splitlines():
    if "=" in line and not line.strip().startswith("#"):
        k, _, v = line.partition("=")
        main[k.strip()] = v.strip().strip('"')

keys = [
    "STRIPE_PUBLISHABLE_KEY",
    "STRIPE_SECRET_KEY",
    "STRIPE_WEBHOOK_SECRET",
    "STRIPE_TEST_MODE",
    "ANTHROPIC_API_KEY",
]

ai_path = Path("/home/gekymedia/web/ai.patriksolutions.com/public_html/.env")
text = ai_path.read_text()

for key in keys:
    val = main.get(key, "")
    if not val:
        print(f"SKIP {key}")
        continue
    line = f'{key}="{val}"' if re.search(r'[#"\s]', val) else f"{key}={val}"
    if re.search(rf"^{re.escape(key)}=", text, re.M):
        text = re.sub(rf"^{re.escape(key)}=.*$", line, text, flags=re.M)
    else:
        text += f"\n{line}\n"
    print(f"OK {key}")

ai_path.write_text(text)
PYEOF

cd /home/gekymedia/web/ai.patriksolutions.com/public_html
php artisan config:clear
php artisan config:cache
php artisan view:clear
echo "CREDENTIALS_SYNCED"
