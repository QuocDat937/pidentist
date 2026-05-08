# PHASE 5 — DEPLOY VPS PRODUCTION (1–2 ngày)

> **Mục tiêu:** Site live trên VPS, HTTPS, Cloudflare, monitoring. Smoke test pass.
> **Ref:** PROJECT_SPEC_WP.md — Section 18

---

## PROMPT 5.1 — Provision VPS (script 01-provision.sh)

```
Tham chiếu PROJECT_SPEC_WP.md section 18.3.

Viết script `deploy/01-provision.sh` chạy trên VPS Ubuntu 22.04 fresh:

Copy NGUYÊN script từ spec section 18.3 gồm 14 bước:

1. System update + install dependencies
2. Set timezone Asia/Ho_Chi_Minh + locale vi_VN.UTF-8
3. Create deploy user + SSH key setup
4. Disable root SSH login + password auth
5. UFW firewall: deny incoming, allow 22, 80, 443
6. Install Nginx
7. Install PHP 8.2 FPM + extensions (mysql, curl, gd, mbstring, xml, zip, intl, bcmath, imagick, redis, opcache)
8. Install MariaDB
9. Install Redis + config maxmemory 256mb + allkeys-lru
10. Install Certbot
11. Install Fail2ban + wordpress filter (POST wp-login.php + xmlrpc.php)
12. Install WP-CLI
13. Create directory structure /var/www/pidentist.vn/public + /logs
14. Create FastCGI cache dir

Script phải set -e, output progress messages.
```

---

## PROMPT 5.2 — Cấu hình Nginx vhost + SSL

```
Tham chiếu PROJECT_SPEC_WP.md section 18.5.

Viết 2 files:

### 1. deploy/nginx.conf (main config)
Copy từ spec section 18.5:
- worker_processes auto, worker_rlimit_nofile 65535
- events: 4096 connections, epoll
- http: sendfile, keepalive, server_tokens off, client_max_body_size 32M
- SSL: TLSv1.2 + 1.3, session cache, OCSP stapling
- Gzip: level 6, text/css/js/json/xml/svg
- Rate limiting zones: login 5r/m, api 30r/m
- FastCGI cache config

### 2. deploy/pidentist.vn.conf (site vhost)
Copy từ spec section 18.5:
- HTTP → HTTPS redirect (port 80 → 301)
- WWW → non-WWW redirect
- Main server block:
  - SSL cert paths (Let's Encrypt)
  - Security headers: HSTS, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy
  - Security blocks: .git, .env, wp-config.php, xmlrpc.php, PHP in uploads, author enumeration
  - Rate limit /wp-login.php + /wp-json/
  - Static assets: 1 year cache, immutable
  - Cache bypass rules: POST, query string, logged-in cookies, admin URLs
  - WordPress permalinks: try_files $uri /index.php
  - PHP handler: FastCGI cache + buffer tuning
  - Cache purge endpoint for Nginx Helper
  - PHP status/ping (internal only)

### 3. Deploy commands:
ln -s sites-available → sites-enabled
nginx -t
systemctl reload nginx
certbot --nginx -d pidentist.vn -d www.pidentist.vn
certbot renew --dry-run
```

---

## PROMPT 5.3 — Setup MariaDB + tuning

```
Tham chiếu PROJECT_SPEC_WP.md section 18.7.

Viết script `deploy/04-database.sh`:

### A. Create database + users:
CREATE DATABASE pidentist_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'pidentist_wp'@'localhost' IDENTIFIED BY '<password>';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, INDEX, REFERENCES ON pidentist_db.*;
CREATE USER 'pidentist_backup'@'localhost' (read-only grants);
FLUSH PRIVILEGES;

### B. MariaDB tuning file:
File `/etc/mysql/mariadb.conf.d/60-pi.cnf`:
- innodb_buffer_pool_size = 512M
- innodb_log_file_size = 64M
- innodb_flush_log_at_trx_commit = 2
- max_connections = 100
- query_cache_type = 1, query_cache_size = 32M
- slow_query_log = 1, long_query_time = 2
- utf8mb4 charset

systemctl restart mariadb
```

---

## PROMPT 5.4 — PHP-FPM tuning + OPcache

```
Tham chiếu PROJECT_SPEC_WP.md section 18.4.

Viết script `deploy/02-php-config.sh`:

### A. PHP-FPM pool config:
File /etc/php/8.2/fpm/pool.d/www.conf:
- pm = dynamic
- pm.max_children = 30
- pm.start_servers = 5
- pm.min_spare_servers = 3
- pm.max_spare_servers = 10
- pm.max_requests = 500
- request_terminate_timeout = 60s
- slowlog + request_slowlog_timeout = 5s
- pm.status_path = /php-status

### B. PHP.ini overrides:
File /etc/php/8.2/fpm/php.ini:
- memory_limit = 256M
- upload_max_filesize = 32M
- post_max_size = 32M
- max_execution_time = 60
- max_input_vars = 5000
- date.timezone = Asia/Ho_Chi_Minh
- expose_php = Off
- Session security: httponly, secure, samesite Lax
- Disable dangerous functions: exec, passthru, shell_exec, system, etc.

### C. OPcache config:
File /etc/php/8.2/fpm/conf.d/10-opcache.ini:
- opcache.enable = 1
- opcache.memory_consumption = 256
- opcache.max_accelerated_files = 20000
- opcache.revalidate_freq = 2
- opcache.jit = 1255
- opcache.jit_buffer_size = 128M

systemctl restart php8.2-fpm
```

---

## PROMPT 5.5 — Install WordPress + theme + plugins production

```
Tham chiếu PROJECT_SPEC_WP.md section 18.8.

Viết script `deploy/05-wordpress-install.sh`:

1. Download WP core (Vietnamese): wp core download --locale=vi
2. Create wp-config.php với wp config create:
   - DB credentials
   - Prefix pi_
   - Extra PHP: WP_DEBUG false, DISALLOW_FILE_EDIT, FORCE_SSL_ADMIN, DISABLE_WP_CRON, Redis config
3. Generate fresh salts: wp config shuffle-salts
4. Install WP: wp core install --url, --title, --admin_user, --admin_password, --admin_email
5. Install + activate GeneratePress: wp theme install generatepress --activate
6. Clone child theme từ git → activate
7. Install all plugins via wp plugin install (9 plugins)
8. Enable Redis: wp redis enable
9. Set permalinks: wp rewrite structure '/%postname%/'
10. Create essential pages (6 pages): Trang chủ, Về Pi, Đặt lịch, Liên hệ, Giá niềng, Khoảnh khắc Pi
11. Set static front page
12. Setup system cron: crontab www-data */5 * * * * wp-cron.php
```

---

## PROMPT 5.6 — Migrate local → production

```
Viết script `deploy/06-migrate.sh`:

### A. Export từ local:
cd local-site
wp db export local-export.sql

### B. Upload lên VPS:
scp local-export.sql deploy@vps:/tmp/
rsync -avz uploads/ deploy@vps:/var/www/pidentist.vn/public/wp-content/uploads/

### C. Import trên VPS:
wp db import /tmp/local-export.sql

### D. Search/Replace domain:
wp search-replace 'http://pidentist.local' 'https://pidentist.vn' --all-tables --skip-columns=guid
wp search-replace '//pidentist.local' '//pidentist.vn' --all-tables --skip-columns=guid

### E. Search/Replace path (nếu absolute paths):
wp search-replace '<local-path>' '/var/www/pidentist.vn/public' --all-tables

### F. Post-migration:
wp cache flush
wp rewrite flush
wp transient delete --all

### G. File permissions:
chown -R www-data:www-data /var/www/pidentist.vn/public
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 wp-config.php
```

---

## PROMPT 5.7 — Setup Cloudflare

```
Tham chiếu PROJECT_SPEC_WP.md section 14.8.

Hướng dẫn setup Cloudflare STEP BY STEP:

### A. DNS:
A    @    <VPS_IP>    Proxied
A    www  <VPS_IP>    Proxied

### B. SSL/TLS:
- Mode: Full (strict)
- Always Use HTTPS: ON
- HSTS: Enable (max-age 31536000)
- Minimum TLS: 1.2
- TLS 1.3: ON
- Auto HTTPS Rewrites: ON

### C. Speed:
- Auto Minify HTML only (CSS/JS handled by LiteSpeed)
- Brotli: ON
- Rocket Loader: OFF
- Early Hints: ON

### D. Caching:
- Level: Standard
- Browser Cache TTL: 1 year
- Always Online: ON

### E. Page Rules (3 free rules):
1. pidentist.vn/wp-admin/* → Cache Bypass, Security High
2. pidentist.vn/wp-login.php → Cache Bypass, Security I'm Under Attack
3. pidentist.vn/* → Cache Everything, Edge TTL 1 month, Browser TTL 4h

### F. Firewall Rules:
1. Block bad bots (except Google/Bing)
2. Challenge wp-login.php
3. Block xmlrpc.php
```

---

## PROMPT 5.8 — Setup monitoring + deploy script

```
Tham chiếu PROJECT_SPEC_WP.md section 18.11 + 18.9.

### A. UptimeRobot:
- Monitor 1: https://pidentist.vn/ — keyword "Pi Dentist"
- Monitor 2: https://pidentist.vn/wp-admin/admin-ajax.php?action=heartbeat
- Alert: Email

### B. Deploy script cho subsequent updates:
File `deploy/deploy.sh`:
Copy từ spec section 18.9:
- PHP syntax check local
- Confirm prompt
- git push
- SSH: git pull on server, wp cache flush, LiteSpeed purge, Nginx cache clear, reload services
- Smoke test curl

### C. System cron setup:
- WP Cron: */5 * * * *
- DB backup: 0 4 * * *
- Certbot auto-renew: systemd timer (already installed)
```

---

## PROMPT 5.9 — Reconnect plugins trên production

```
Sau khi migrate, một số plugins cần reconnect:

### A. UpdraftPlus:
- Settings > UpdraftPlus > Settings
- Remote Storage: Google Drive → Authenticate lại
- Test backup

### B. Wordfence:
- Chạy initial scan
- Setup 2FA cho admin account production
- Verify firewall mode: Optimized

### C. LiteSpeed Cache:
- Object Cache: Redis → Host 127.0.0.1, Port 6379
- Enable cache
- Page Optimization: CSS/JS/HTML minify ON
- Image Optimization: WebP ON

### D. WPS Hide Login:
- Confirm /dang-nhap-pi/ hoạt động
- Bookmark URL mới!

### E. Rank Math:
- Verify sitemap: /sitemap_index.xml
- Local SEO: verify business info
- Schema: test qua Google Rich Results Test

### F. Fluent Forms:
- Test submit form → email nhận được
- reCAPTCHA: add keys (Google reCAPTCHA v3)
```

---

**✅ PHASE 5 DONE khi:**
- [ ] https://pidentist.vn accessible, HTTPS valid
- [ ] SSL Labs grade: A
- [ ] WP Admin login /dang-nhap-pi/
- [ ] Site render giống local
- [ ] PageSpeed mobile ≥ 85, desktop ≥ 95
- [ ] Form submit → email received
- [ ] Backup → Google Drive success
- [ ] UptimeRobot monitoring active
- [ ] Wordfence scan: 0 critical
- [ ] Cloudflare proxy ON, caching working
