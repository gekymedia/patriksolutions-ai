#!/bin/bash
for f in /home/gekymedia/conf/web/ai.patriksolutions.com/apache2.ssl.conf /home/gekymedia/conf/web/ai.patriksolutions.com/apache2.conf; do
  sed -i 's|DocumentRoot /home/gekymedia/web/ai.patriksolutions.com/public_html$|DocumentRoot /home/gekymedia/web/ai.patriksolutions.com/public_html/public|' "$f"
  sed -i 's|<Directory /home/gekymedia/web/ai.patriksolutions.com/public_html>|<Directory /home/gekymedia/web/ai.patriksolutions.com/public_html/public>|' "$f"
done
systemctl restart apache2
echo "APACHE_FIXED"
