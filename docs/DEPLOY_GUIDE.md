# DEPLOY GUIDE — Pi Dentist

> **Hướng dẫn deploy website Pi Dentist lên Shared Hosting WordPress.**
> Hai phương pháp: ZIP thủ công & GitHub Actions tự động.

---

## MỤC LỤC

- [A. Thông tin hosting](#a-thông-tin-hosting)
- [B. Chuẩn bị chung (bắt buộc cả 2 cách)](#b-chuẩn-bị-chung)
- [C. Migration lần đầu — Local → Hosting](#c-migration-lần-đầu)
- [D. CÁCH 1 — Cập nhật bằng ZIP thủ công](#d-cách-1--zip-thủ-công)
- [E. CÁCH 2 — Auto deploy qua GitHub Actions](#e-cách-2--github-actions-auto-deploy)
- [F. Post-deploy checklist](#f-post-deploy-checklist)
- [G. Troubleshooting](#g-troubleshooting)

---

## A. Thông tin hosting

| Thông số | Giá trị |
|----------|---------|
| Gói | WordPress #1 |
| CPU | Intel Xeon Gold 4.2 GHz Gen5 × 2 cores |
| RAM | 2 GB |
| Storage | 4 GB |
| Web Server | LiteSpeed |
| Control Panel | DirectAdmin / cPanel |
| SSL | Miễn phí (Let's Encrypt) |
| Redis / LSCache | Có |
| HTTP/3 | Có |
| PHP | Đa phiên bản |

> **⚠️ LƯU Ý:** 4 GB storage rất hạn chế. WordPress core ~60MB, theme ~10MB, plugins ~100MB, DB ~10MB → còn ~3.8GB cho uploads. Tối ưu ảnh (WebP, <200KB/ảnh) là bắt buộc.

---

## B. Chuẩn bị chung

### B.1 — Mua hosting & trỏ domain

1. **Mua hosting** WordPress #1 → nhận email chứa:
   - Link đăng nhập DirectAdmin/cPanel
   - Nameserver (vd: `ns1.hosting.vn`, `ns2.hosting.vn`)
   - IP server

2. **Trỏ domain** `pidentist.vn` về hosting:
   - Đăng nhập **nhà quản lý domain** (nơi mua domain)
   - Đổi Nameserver sang nameserver của hosting
   - **Hoặc** tạo A Record trỏ về IP server hosting
   - Chờ **2–48 giờ** để DNS propagate

3. **Kiểm tra DNS** đã trỏ thành công:
   ```
   nslookup pidentist.vn
   ping pidentist.vn
   ```

### B.2 — Cài WordPress trên hosting

> Hầu hết shared hosting WP có tính năng "Cài đặt nhanh" (Softaculous / WordPress Manager).

**Qua Softaculous (cPanel):**
1. Login cPanel → **Softaculous Apps Installer** → WordPress
2. Chọn **Install**:
   - Protocol: `https://`
   - Domain: `pidentist.vn`
   - Directory: để trống (cài ở root)
   - Site Name: `Pi Dentist`
   - Admin Username: **KHÔNG dùng `admin`** → đặt tên riêng
   - Admin Password: mật khẩu mạnh (16+ ký tự)
   - Admin Email: email thật
   - Language: `Vietnamese`
   - Table Prefix: `wp_`
3. Click **Install**

**Qua DirectAdmin WordPress Manager:**
1. Login DirectAdmin → **WordPress Manager** → Install
2. Điền tương tự như trên
3. Click Install

**Sau khi cài xong:**
- Truy cập `https://pidentist.vn/wp-admin` → login
- Vào **Settings → General**: kiểm tra URL là `https://pidentist.vn`
- Vào **Settings → Permalinks**: chọn **Post name** (`/%postname%/`) → Save

### B.3 — Cài SSL

1. DirectAdmin/cPanel → **SSL/TLS** hoặc **Let's Encrypt**
2. Chọn domain `pidentist.vn` → Issue certificate
3. Bật **Force HTTPS redirect**
4. Kiểm tra: truy cập `https://pidentist.vn` → có khóa xanh

### B.4 — Cài GeneratePress (Parent Theme)

1. WP Admin → **Appearance → Themes → Add New**
2. Tìm **GeneratePress** → Install → **KHÔNG Activate ngay** (đợi upload child theme)

### B.5 — Cài Plugins

WP Admin → **Plugins → Add New**, cài lần lượt:

| # | Plugin | Slug tìm kiếm |
|---|--------|---------------|
| 1 | Custom Post Type UI | `custom-post-type-ui` |
| 2 | Rank Math SEO | `seo-by-rank-math` |
| 3 | LiteSpeed Cache | `litespeed-cache` |
| 4 | Wordfence Security | `wordfence` |
| 5 | UpdraftPlus Backup | `updraftplus` |
| 6 | Redis Object Cache | `redis-cache` |
| 7 | Nginx Helper | `nginx-helper` |

→ **Activate** tất cả sau khi cài.

> **GHI CHÚ:** LiteSpeed Cache hoạt động native trên hosting LiteSpeed — không cần cấu hình phức tạp.

---

## C. Migration lần đầu

### C.1 — Export Database từ Local

Mở **LocalWP Site Shell** (hoặc terminal tại thư mục WP local):

```bash
wp db export pidentist-local.sql
```

File `pidentist-local.sql` sẽ xuất hiện trong thư mục WP root local.

**Nếu không có WP-CLI**, dùng phpMyAdmin local:
1. Truy cập phpMyAdmin local (LocalWP → Database → Open Adminer)
2. Chọn database → **Export** → Format SQL → Download

### C.2 — Upload Child Theme lên Hosting

**Cách A — Qua WP Admin (đơn giản nhất):**

1. **Nén theme thành ZIP** trên máy local:
   - Vào thư mục `wp-content/themes/`
   - Click chuột phải vào folder `pidentist` → **Send to → Compressed (zipped) folder**
   - Được file `pidentist.zip`

2. WP Admin trên hosting → **Appearance → Themes → Add New → Upload Theme**
3. Chọn file `pidentist.zip` → **Install Now**
4. **Activate** child theme `pidentist`

**Cách B — Qua File Manager (nếu ZIP > upload limit):**

1. Login DirectAdmin/cPanel → **File Manager**
2. Navigate đến `public_html/wp-content/themes/`
3. Upload file `pidentist.zip`
4. Click chuột phải → **Extract** → giải nén tại chỗ
5. Xóa file ZIP sau khi giải nén
6. WP Admin → Appearance → Themes → Activate `pidentist`

### C.3 — Import Database

1. Login DirectAdmin/cPanel → **phpMyAdmin**
2. Chọn database WordPress (tên thường là `username_wp` hoặc xem trong `wp-config.php`)
3. **Xóa tất cả tables hiện có**: Check all → Drop (vì sẽ import từ local)
4. Tab **Import** → Choose file `pidentist-local.sql` → **Go**

> **⚠️ LƯU Ý:** Nếu file SQL > 50MB (limit phpMyAdmin), liên hệ hosting hoặc chia nhỏ file. Với site mới, file thường < 5MB nên không gặp vấn đề.

### C.4 — Search-Replace Domain

**Cách 1 — Plugin (khuyên dùng):**

1. WP Admin → **Plugins → Add New** → cài **Better Search Replace**
2. Vào **Tools → Better Search Replace**
3. Thực hiện 2 lần replace:

| Search for | Replace with |
|-----------|-------------|
| `http://pidentist.local` | `https://pidentist.vn` |
| `//pidentist.local` | `//pidentist.vn` |

4. Chọn **ALL tables** → bỏ tick "Dry run" → **Run Search/Replace**
5. **Gỡ plugin** Better Search Replace sau khi xong

**Cách 2 — WP-CLI (nếu hosting có SSH):**

```bash
wp search-replace 'http://pidentist.local' 'https://pidentist.vn' --all-tables --skip-columns=guid
wp search-replace '//pidentist.local' '//pidentist.vn' --all-tables --skip-columns=guid
```

### C.5 — Upload thư mục Uploads

Thư mục `wp-content/uploads/` chứa ảnh, media. Cần upload lên hosting:

1. **Nén** folder `uploads/` thành `uploads.zip` trên máy local
2. File Manager trên hosting → navigate đến `public_html/wp-content/`
3. **Upload** `uploads.zip`
4. **Extract** tại chỗ → xóa ZIP

**Hoặc dùng FTP client (FileZilla):**
1. Tải [FileZilla](https://filezilla-project.org/)
2. Kết nối FTP với thông tin từ email hosting
3. Upload toàn bộ folder `uploads/` vào `public_html/wp-content/uploads/`

### C.6 — Cập nhật wp-config.php

File Manager → mở `public_html/wp-config.php` → Edit, đảm bảo có:

```php
define( 'WP_ENVIRONMENT_TYPE', 'production' );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'FORCE_SSL_ADMIN', true );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'WP_POST_REVISIONS', 5 );
define( 'AUTOSAVE_INTERVAL', 120 );
```

### C.7 — Flush & Verify

1. WP Admin → **Settings → Permalinks** → click **Save Changes** (flush rewrite rules)
2. WP Admin → **LiteSpeed Cache → Purge All**
3. Truy cập `https://pidentist.vn` → kiểm tra site hoạt động
4. Kiểm tra vài trang: Về Pi, Dịch vụ, Bác sĩ, Liên hệ
5. Kiểm tra ảnh hiển thị đúng

---

## D. CÁCH 1 — ZIP thủ công

> **Workflow:** Sửa code local → Nén ZIP → Upload lên hosting → Ghi đè theme cũ.

### D.1 — Quy trình

```
Sửa code local → Test trên LocalWP → Nén ZIP pidentist/ → Upload qua File Manager → Clear cache
```

### D.2 — Các bước chi tiết

**Bước 1: Sửa code & test local**
- Mở code trong VS Code, sửa file PHP/CSS/JS
- Test trên `http://pidentist.local`

**Bước 2: Nén theme**
- Vào: `C:\Users\Admin\Local Sites\pidentist\app\public\wp-content\themes\`
- Chuột phải folder `pidentist` → **Send to → Compressed (zipped) folder**
- Chỉ nén folder `pidentist/` — KHÔNG nén `generatepress/` hay thư mục khác

**Bước 3: Upload & ghi đè trên hosting**

**Qua File Manager (khuyên dùng):**
1. Login DirectAdmin/cPanel → File Manager
2. Navigate: `public_html/wp-content/themes/`
3. **Xóa** folder `pidentist` cũ
4. **Upload** file `pidentist.zip`
5. Chuột phải → **Extract**
6. Xóa file ZIP
7. Kiểm tra folder `pidentist/` đã có đầy đủ file

**Bước 4: Clear cache**
1. WP Admin → LiteSpeed Cache → Purge All
2. Truy cập site, Ctrl+Shift+R để hard refresh

### D.3 — Script nén nhanh (PowerShell)

```powershell
# Pi Dentist — Quick ZIP Script
$themePath = "C:\Users\Admin\Local Sites\pidentist\app\public\wp-content\themes\pidentist"
$outputPath = "$env:USERPROFILE\Desktop\pidentist.zip"

if (Test-Path $outputPath) { Remove-Item $outputPath }
Compress-Archive -Path $themePath -DestinationPath $outputPath

Write-Host "Done: $outputPath" -ForegroundColor Green
Write-Host "Size: $([math]::Round((Get-Item $outputPath).Length / 1MB, 2)) MB"
```

### D.4 — Ưu & nhược điểm

| Ưu điểm | Nhược điểm |
|---------|-----------|
| Đơn giản, không cần setup | Tốn thời gian mỗi lần update |
| Hoạt động mọi hosting | Dễ quên file, upload nhầm |
| An toàn — kiểm soát hoàn toàn | Khó rollback khi lỗi |

---

## E. CÁCH 2 — GitHub Actions Auto Deploy

> **Workflow:** Push code lên GitHub → GitHub Actions tự FTP upload lên hosting.
> **Branch strategy:** `main` = production. Push to `main` = auto deploy.

### E.1 — Lấy thông tin FTP từ hosting

Login DirectAdmin/cPanel → **FTP Accounts**, ghi lại:

| Thông tin | Ví dụ |
|----------|-------|
| FTP Server | `pidentist.vn` hoặc `ftp.pidentist.vn` |
| FTP Username | username hosting |
| FTP Password | mật khẩu FTP |
| FTP Port | `21` (FTP) hoặc `22` (SFTP) |
| Remote Path | `/public_html/wp-content/themes/pidentist` |

> **MẸO:** Nếu hosting hỗ trợ SFTP (port 22), ưu tiên dùng SFTP vì an toàn hơn.

### E.2 — Tạo GitHub Secrets

1. Vào repo: `https://github.com/QuocDat937/pidentist`
2. **Settings → Secrets and variables → Actions → New repository secret**
3. Thêm 4 secrets:

| Secret Name | Value |
|-------------|-------|
| `FTP_SERVER` | `ftp.pidentist.vn` (hoặc IP server) |
| `FTP_USERNAME` | username FTP |
| `FTP_PASSWORD` | password FTP |
| `REMOTE_PATH` | `/public_html/wp-content/themes/pidentist/` |

> **QUAN TRỌNG:** KHÔNG BAO GIỜ commit thông tin FTP vào code. Luôn dùng GitHub Secrets.

### E.3 — Tạo GitHub Actions Workflow

Tạo file `.github/workflows/deploy.yml` trong repo:

```yaml
# Pi Dentist — Auto Deploy to Hosting via FTP
name: Deploy to Production

on:
  push:
    branches:
      - main

jobs:
  deploy:
    name: Deploy theme via FTP
    runs-on: ubuntu-latest
    
    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Deploy via FTP
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          server-dir: ${{ secrets.REMOTE_PATH }}
          exclude: |
            **/.git*
            **/.git*/**
            .gitignore
            .gitattributes
            .editorconfig
            **/.vscode/**
            **/node_modules/**
            **/docs/**
            **/deploy/**
            **/*.md
            .github/**
```

### E.4 — Cấu trúc folder cần tạo

```
pidentist/                    (repo root)
├── .github/
│   └── workflows/
│       └── deploy.yml        (file workflow)
├── assets/
├── inc/
├── ...các file theme khác
```

### E.5 — Push lần đầu & kiểm tra

```bash
cd "C:\Users\Admin\Local Sites\pidentist\app\public\wp-content\themes\pidentist"

# Commit & push
git add .
git commit -m "feat: add GitHub Actions auto-deploy"
git push origin main
```

**Kiểm tra:**
1. GitHub repo → tab **Actions**
2. Thấy workflow đang chạy (30–60 giây)
3. Nếu xanh → deploy thành công
4. Truy cập `https://pidentist.vn` → Ctrl+Shift+R

### E.6 — Workflow hàng ngày

```bash
# 1. Sửa code trong VS Code
# 2. Test trên local
# 3. Commit & push → tự động deploy
git add .
git commit -m "fix: sửa lỗi header mobile"
git push origin main
# 4. Đợi 30-60s → site production đã cập nhật
```

### E.7 — Ưu & nhược điểm

| Ưu điểm | Nhược điểm |
|---------|-----------|
| Tự động, chỉ cần `git push` | Cần setup ban đầu |
| Có lịch sử thay đổi (Git) | FTP có thể bị hosting block |
| Dễ rollback (`git revert`) | Chỉ deploy theme, không DB |
| Miễn phí 2000 phút/tháng | Cần hiểu Git cơ bản |

---

## F. Post-deploy checklist

### F.1 — Sau migration lần đầu

- [ ] `https://pidentist.vn` accessible, HTTPS khóa xanh
- [ ] Homepage hiển thị đúng
- [ ] Header + Footer render đúng
- [ ] Menu navigation hoạt động
- [ ] Trang Dịch vụ, Bác sĩ, Case hiển thị
- [ ] Single pages (Về Pi, Bảng giá, Liên hệ) OK
- [ ] Ảnh hiển thị đúng
- [ ] Floating CTA + Back to top hoạt động
- [ ] Mobile responsive OK

### F.2 — Cấu hình plugins production

**LiteSpeed Cache:** Enable Cache, Object Cache → Redis, CSS/JS Minify ON, WebP ON

**Rank Math SEO:** Setup Wizard, verify sitemap, kết nối Google Search Console

**Wordfence:** Initial scan, setup 2FA, enable Firewall

**UpdraftPlus:** Remote Storage (Google Drive), Schedule daily DB + weekly files

---

## G. Troubleshooting

| Lỗi | Giải pháp |
|-----|-----------|
| Trang trắng | Bật `WP_DEBUG` tạm, xem error log |
| 404 tất cả trang con | Settings → Permalinks → Save |
| Ảnh không hiển thị | Upload `uploads/` + chạy search-replace |
| CSS/JS không load | Chạy search-replace lại |
| "Error establishing database" | Kiểm tra `wp-config.php` DB settings |
| Theme "broken" | Cài GeneratePress parent trước |
| GitHub Actions timeout | Liên hệ hosting whitelist IP GitHub |

### Bật Debug tạm

```php
// Sửa wp-config.php trên hosting
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
// Xem log: wp-content/debug.log
// NHỚ TẮT khi xong!
```

### Rollback

**Cách 1 (ZIP):** Upload lại bản ZIP cũ.

**Cách 2 (GitHub):**
```bash
git log --oneline -10
git revert <commit-hash>
git push origin main
```

---

## Khuyến nghị

> **Nên dùng Cách 2 (GitHub Actions)** vì tiết kiệm thời gian, có lịch sử thay đổi, dễ rollback, professional.
> Cách 1 dùng làm **backup plan** khi GitHub Actions gặp sự cố.

---

*Cập nhật: 2026-05-12 | Pi Dentist Deployment Guide v1.0*
