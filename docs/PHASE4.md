# PHASE 4 — PLUGIN STACK + SEO + FORM + SECURITY (1–2 ngày)

> **Mục tiêu:** Tất cả plugin installed + configured. Form booking hoạt động, SEO schema đúng, security hardening applied.
> **Ref:** PROJECT_SPEC_WP.md — Section 11, 12, 13, 14, 15

---

## PROMPT 4.1 — Cài plugin stack qua wp-cli

```
Viết script wp-cli (hoặc hướng dẫn manual) để cài + activate 6 plugins chính + 3 plugins bổ trợ:

### Plugins chính:
wp plugin install custom-post-type-ui --activate
wp plugin install seo-by-rank-math --activate
wp plugin install fluentform --activate
wp plugin install litespeed-cache --activate
wp plugin install wordfence --activate
wp plugin install updraftplus --activate

### Plugins bổ trợ:
wp plugin install redis-cache --activate
wp plugin install nginx-helper --activate
wp plugin install wps-hide-login --activate

### Plugin auto-update config:
Viết code trong `inc/plugin-config.php` (thêm require vào functions.php):
- add_filter('auto_update_plugin') — chỉ auto-update: rank-math, fluentform, wordfence, updraftplus, custom-post-type-ui
- KHÔNG auto-update: litespeed-cache (có thể break)
- add_filter('allow_minor_auto_core_updates', '__return_true')
- add_filter('allow_major_auto_core_updates', '__return_false')

### Post-install checklist:
- Tất cả plugins Active
- No PHP errors trong debug.log
- WP Admin sidebar có menu mới: Rank Math, Fluent Forms, LiteSpeed Cache, Wordfence, UpdraftPlus
```

---

## PROMPT 4.2 — Cấu hình Rank Math SEO

```
Tham chiếu PROJECT_SPEC_WP.md section 12.

Hướng dẫn cấu hình Rank Math STEP BY STEP:

### A. Setup Wizard:
- Site Type: Local Business → Dentist
- Business Name: Pi Dentist
- Logo: upload logo (hoặc skip nếu chưa có)
- Default Social Share Image: placeholder 1200x630
- Sitemaps: ON cho Posts, Pages, pi_service, pi_doctor, pi_case, Categories
- Noindex: Tags, Author archives

### B. Titles & Meta (Rank Math > Titles & Meta):
Homepage: %sitename% - %sitedesc%
Page: %title% - %sitename%
Post: %title% - %sitename%
pi_service: %title% - Dịch vụ chỉnh nha tại Pi Dentist
pi_doctor: %title% - Bác sĩ chỉnh nha tại Pi Dentist
pi_case: Case %title% - Pi Dentist

### C. Schema LocalBusiness:
Rank Math > Titles & Meta > Local SEO:
- Business Name: Pi Dentist
- Type: Dentist
- Phone, Email, Address (NAP)
- Opening Hours
- Price Range: $$$
- Geo coordinates

### D. Breadcrumbs:
Enable, separator ›, home label "Trang chủ"

### E. Code bổ sung schema cho pi_service:
Viết trong `inc/rank-math-defaults.php`:
- add_filter('rank_math/snippet/rich_snippet_service_entity')
- Thêm offers: @type Offer, priceCurrency VND, price = meta * 1000000
- Thêm provider: @type Dentist

### F. robots.txt filter:
Viết trong `inc/rank-math-defaults.php`:
- add_filter('robots_txt') — custom rules: Disallow wp-admin, wp-login, search; Allow admin-ajax; Sitemap URL

### G. Sitemap verification:
- Browse /sitemap_index.xml → phải có post, page, pi_service, pi_doctor, pi_case sitemaps
```

---

## PROMPT 4.3 — Tạo Fluent Forms "Đặt lịch tư vấn"

```
Tham chiếu PROJECT_SPEC_WP.md section 13.

Hướng dẫn tạo form Fluent Forms STEP BY STEP:

### A. Tạo form mới:
Fluent Forms > New Form > Blank Form
Tên: "Đặt lịch tư vấn"

### B. Fields (drag & drop):
1. fullName — Name (Text), Required, min 2, max 50
2. phone — Phone, Required, regex /^(0|\+84)[0-9]{9,10}$/
3. email — Email, NOT required, valid format
4. service — Dropdown, Required, Options:
   - Mắc cài kim loại
   - Mắc cài sứ
   - Niềng trong suốt
   - Niềng mặt trong
   - Chưa biết — cần tư vấn
5. preferredDate — Date Picker, NOT required, min today
6. preferredTime — Radio, NOT required: Sáng (8-12h) | Chiều (13-17h) | Tối (17-20h)
7. message — Textarea, NOT required, max 500
8. Hidden: source = "website"
9. Hidden: _referer = auto

### C. Submit Settings:
Confirmation message:
"✓ Cảm ơn bạn đã đặt lịch!
Đội ngũ Pi Dentist sẽ liên hệ trong vòng 30 phút.
Hotline: 0909 XXX XXX"

### D. Notifications:
Notification 1 (Admin):
- To: sales@pidentist.vn
- Subject: [BOOKING] {inputs.fullName} - {inputs.service}
- Body: Chi tiết khách hàng + source + timestamp

Notification 2 (Auto-reply):
- To: {inputs.email}
- Subject: Cảm ơn bạn đã đặt lịch tại Pi Dentist
- Body: Xác nhận + sẽ liên hệ trong 30 phút

### E. Anti-spam:
- Honeypot: ON
- reCAPTCHA v3: placeholder (setup keys sau go-live)

### F. Embed form:
- Shortcode: [fluentform id="1"]
- Đã chèn trong Synced Pattern "Pi - CTA Booking"
```

---

## PROMPT 4.4 — Cấu hình LiteSpeed Cache + Redis

```
Tham chiếu PROJECT_SPEC_WP.md section 14.4.

Viết hướng dẫn cấu hình CHI TIẾT cho local (một số features chỉ hoạt động trên production):

### A. LiteSpeed Cache > General:
- Enable Cache: ON (local dùng LiteSpeed plugin ở mức page cache cơ bản)
- Auto Purge: ON

### B. Cache TTL:
- Default Public Cache TTL: 604800 (7 ngày)
- Front Page TTL: 604800
- 404 TTL: 3600

### C. Page Optimization:
CSS:
- Minify: ON
- CSS Combine: ON (test kỹ)
- Load CSS Asynchronously: ON
- Font Display: swap

JS:
- Minify: ON
- Load JS Deferred: ON

HTML:
- Minify: ON
- Remove Query Strings: ON
- Remove WordPress Emoji: ON

Media:
- Lazy Load Images: ON
- Lazy Load Iframes: ON
- Add Missing Sizes: ON

### D. Database:
- Clean revisions (max 3 per post): schedule weekly
- Clean transients: schedule daily
- Optimize tables: schedule weekly

### E. Redis Object Cache:
- Cài plugin redis-cache
- wp redis enable
- Verify: Status Connected, Drop-in Installed
- Cache Key Salt: pidentist_

### F. Self-host Google Fonts (thay vì gọi CDN):
Viết code trong `inc/enqueue.php` hoặc file mới:
- Tải font files Inter + Playfair Display (woff2)
- Copy vào assets/fonts/
- @font-face declarations trong base.css hoặc file fonts.css
- add_action('wp_head', 'pi_preload_fonts', 1) — preload critical fonts
- XÓA wp_enqueue_style('pi-fonts') Google Fonts CDN từ enqueue.php
```

---

## PROMPT 4.5 — Cấu hình Wordfence + 2FA + Security hardening


Tham chiếu PROJECT_SPEC_WP.md section 15.

### A. Wordfence config:
Firewall:
- WAF Status: ENABLED
- Rate Limiting: 240 req/min throttle, 404 > 30/min block 1h
- Brute Force: lock after 5 failures / 4h, lock for 4h
- Invalid usernames: immediate lock
- Hide valid users in login errors: ON
- Block blank User-Agent POST: ON

Malware Scan:
- Schedule: Daily 03:00
- Scan core, themes, plugins against repo
- Scan for malicious files, backdoors, trojans
- Monitor SSL cert expiration

Login Security:
- 2FA: Required for Administrator + Editor
- reCAPTCHA: placeholder (setup sau go-live)
- Disable XML-RPC auth: ON

### B. Security hardening code:
Viết file `inc/security.php` (thêm require vào functions.php):
Copy TẤT CẢ code từ PROJECT_SPEC_WP.md section 15.4:

1. Disable XML-RPC: xmlrpc_enabled __return_false, xmlrpc_methods __return_empty_array
2. Remove WP version: wp_generator, the_generator, style/script ver query
3. DISALLOW_FILE_EDIT
4. Block author enumeration: /?author=N → 403
5. Hide login errors: "Thông tin đăng nhập không hợp lệ."
6. Disable REST API /wp/v2/users endpoint
7. REST API restrict cho logged-out (cho phép public routes: posts, services, doctors, cases, fluent-form)
8. Security headers: X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy, CSP
9. Disable Application Passwords
10. (Optional) Limit login IP

### C. wp-config.php additions (hướng dẫn thêm thủ công):
FORCE_SSL_ADMIN = true
DISALLOW_FILE_EDIT = true
WP_POST_REVISIONS = 5
EMPTY_TRASH_DAYS = 30
DISABLE_WP_CRON = true
$table_prefix = 'pi_'
```

---

## PROMPT 4.6 — Cấu hình UpdraftPlus backup

```
Tham chiếu PROJECT_SPEC_WP.md section 16.

Hướng dẫn cấu hình UpdraftPlus:

### Settings:
- Files backup schedule: Weekly, Retain 4
- Database backup schedule: Daily, Retain 14
- Remote Storage: Google Drive
  - Authenticate với Google account backup
  - Folder: UpdraftPlus/pidentist.vn/
- Include: Plugins, Themes, Uploads, Others
- Exclude: cache, upgrade folders
- Email report: admin email

### First backup test:
1. Click "Backup Now"
2. Include database + files
3. Send to remote storage
4. Wait 5-10 minutes
5. Verify on Google Drive

### Backup script bổ sung (cho production):
File `deploy/pi-db-backup.sh`:
Copy từ spec section 16.7.2:
- mysqldump single-transaction → gzip
- Retention 14 days
- rsync to backup VPS (optional)

Crontab: 0 4 * * * /usr/local/bin/pi-db-backup.sh
```

---

## PROMPT 4.7 — Custom roles + plugin auto-update

```
Tham chiếu PROJECT_SPEC_WP.md section 19.2.

Viết file `inc/roles.php` (thêm require vào functions.php):

### Custom role pi_marketing:
- Clone từ Editor capabilities
- Thêm: fluentform_view_forms, fluentform_view_form_entries, fluentform_export_forms
- Thêm: edit/publish/delete cho pi_service, pi_doctor, pi_case
- Chạy 1 lần qua option flag 'pi_roles_registered_v1'
```

---

**✅ PHASE 4 DONE khi:**
- [ ] Tất cả 9 plugins Active, không lỗi
- [ ] Submit form đặt lịch → email đến đúng
- [ ] Rank Math score homepage ≥ 85
- [ ] /sitemap_index.xml accessible
- [ ] Schema LocalBusiness validated
- [ ] LiteSpeed Cache active
- [ ] Redis Object Cache connected
- [ ] Wordfence scan: 0 critical
- [ ] UpdraftPlus backup thành công
