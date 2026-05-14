# Hướng dẫn Deploy WordPress Theme qua DirectAdmin Git + GitHub Webhook

> **Tài liệu thực chiến** — Ghi lại chính xác workflow đã triển khai thành công cho dự án Pi Dentist (pidentist.vn).
> Áp dụng cho mọi project WordPress child theme deploy lên shared hosting có DirectAdmin.

---

## Mục lục

1. [Tổng quan kiến trúc](#1-tổng-quan-kiến-trúc)
2. [Yêu cầu trước khi bắt đầu](#2-yêu-cầu-trước-khi-bắt-đầu)
3. [Bước 1 — Chuẩn bị GitHub Repository](#3-bước-1--chuẩn-bị-github-repository)
4. [Bước 2 — Cấu hình DirectAdmin Git](#4-bước-2--cấu-hình-directadmin-git)
5. [Bước 3 — Thêm Webhook trên GitHub](#5-bước-3--thêm-webhook-trên-github)
6. [Bước 4 — Force Pull lần đầu](#6-bước-4--force-pull-lần-đầu)
7. [Bước 5 — Test pipeline end-to-end](#7-bước-5--test-pipeline-end-to-end)
8. [Bước 6 — Xử lý Cache sau deploy](#8-bước-6--xử-lý-cache-sau-deploy)
9. [Troubleshooting & Lỗi thường gặp](#9-troubleshooting--lỗi-thường-gặp)
10. [Checklist nhanh](#10-checklist-nhanh)

---

## 1. Tổng quan kiến trúc

```
┌──────────────┐   git push    ┌───────────┐   webhook POST   ┌───────────────────┐
│  Local Dev   │ ────────────→ │  GitHub    │ ────────────────→│  DirectAdmin Git  │
│  (LocalWP)   │               │  (remote)  │                  │  (hosting server) │
└──────────────┘               └───────────┘                  └────────┬──────────┘
                                                                       │ git pull +
                                                                       │ checkout
                                                                       ▼
                                                          ┌─────────────────────────┐
                                                          │  Deploy Directory       │
                                                          │  public_html/wp-content │
                                                          │  /themes/{theme-name}/  │
                                                          └────────────┬────────────┘
                                                                       │
                                                                       ▼
                                                              ┌────────────────┐
                                                              │  LIVE WEBSITE  │
                                                              └────────────────┘
```

### Tại sao chọn DirectAdmin Git thay vì FTP?

| Tiêu chí               | DirectAdmin Git         | GitHub Actions FTP       |
|------------------------|-------------------------|--------------------------|
| Tốc độ deploy          | ~5-10 giây (git pull)   | ~20-60 giây (FTP upload) |
| Cấu hình               | Đơn giản, native        | Phải setup secrets + YAML |
| Bảo mật                | Không lưu FTP password  | FTP credentials trên GitHub |
| Selective deploy       | Pull toàn bộ repo       | Có thể exclude files     |
| Độ tin cậy             | Cao (server tự pull)    | Phụ thuộc GitHub Actions |

**Kết luận:** DirectAdmin Git phù hợp cho shared hosting, đơn giản và nhanh hơn.

---

## 2. Yêu cầu trước khi bắt đầu

### Phía Local (máy dev)
- [ ] Git đã cài đặt
- [ ] Code theme nằm trong thư mục child theme (VD: `wp-content/themes/pidentist/`)
- [ ] `.gitignore` đã cấu hình đúng (loại trừ node_modules, .DS_Store, etc.)
- [ ] Repository đã push lên GitHub

### Phía Hosting
- [ ] Shared hosting có **DirectAdmin** (không phải cPanel)
- [ ] DirectAdmin hỗ trợ tính năng **Git** (kiểm tra trong Dashboard)
- [ ] WordPress đã cài đặt trên hosting
- [ ] Parent theme (VD: GeneratePress) đã cài trên hosting
- [ ] Biết đường dẫn domain trên server (VD: `/home/username/domains/example.com/`)

### Phía GitHub
- [ ] Repository ở chế độ **Public** (hoặc Private + SSH key)
- [ ] Có quyền truy cập **Settings → Webhooks**

---

## 3. Bước 1 — Chuẩn bị GitHub Repository

### 3.1 Cấu trúc repository

Repository **CHỈ chứa thư mục child theme**, KHÔNG chứa toàn bộ WordPress:

```
repository-root/
├── style.css              ← Theme metadata (QUAN TRỌNG)
├── functions.php
├── header.php
├── footer.php
├── front-page.php
├── assets/
│   ├── css/
│   ├── js/
│   ├── fonts/
│   └── images/
├── inc/
├── template-parts/
├── .gitignore
├── .github/               ← GitHub Actions (backup, optional)
│   └── workflows/
│       └── deploy.yml
└── docs/                  ← Documentation (không deploy)
```

### 3.2 File `.gitignore` khuyến nghị

```gitignore
# OS files
.DS_Store
Thumbs.db
desktop.ini

# IDE
.vscode/
.idea/
*.sublime-*

# Node (nếu dùng build tools)
node_modules/
package-lock.json

# WordPress (KHÔNG commit WP core)
wp-config.php
wp-content/uploads/
wp-content/plugins/
wp-content/cache/

# Logs
*.log
debug.log
```

### 3.3 Push code lên GitHub

```bash
cd /path/to/theme/
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/username/repo-name.git
git branch -M main
git push -u origin main
```

---

## 4. Bước 2 — Cấu hình DirectAdmin Git

### 4.1 Truy cập DirectAdmin Git

1. Đăng nhập DirectAdmin: `https://server-hostname:2222`
2. Chọn đúng **domain** ở góc phải (VD: `pidentist.vn`)
3. Vào **Dashboard → Git** (hoặc tìm "Git" trong menu)

### 4.2 Tạo Repository

1. Click **"+ CREATE REPOSITORY"**
2. Điền thông tin:

| Trường          | Giá trị                                          | Ghi chú                    |
|----------------|--------------------------------------------------|---------------------------|
| **Name**        | `pidentist` (tên dễ nhớ)                          | Không cần trùng repo GitHub |
| **Remote URL**  | `https://github.com/username/repo-name.git`       | HTTPS cho public repo      |
| **Branch**      | `main`                                            | Branch chính               |

3. Click **SAVE** hoặc **CREATE**

### 4.3 Cấu hình Deploy Directory (⚠️ QUAN TRỌNG)

Sau khi tạo repo, click **Edit** (hoặc icon `...` → Modify):

| Trường              | Giá trị                                       |
|--------------------|-----------------------------------------------|
| **Deploy Branch**   | `main`                                         |
| **Deploy Directory**| `public_html/wp-content/themes/{theme-name}`   |
| **Key file**        | Để trống (public repo) hoặc SSH key (private)  |

> ⚠️ **LƯU Ý QUAN TRỌNG:**
> - Deploy Directory phải là **đường dẫn TƯƠNG ĐỐI** (relative), KHÔNG phải tuyệt đối.
> - Tương đối từ thư mục domain: `domains/{domain}/`
> - **ĐÚNG:** `public_html/wp-content/themes/pidentist`
> - **SAI:** `/home/user/domains/domain.com/public_html/wp-content/themes/pidentist`
> - Nếu nhập absolute path → Lỗi: `"Bad Request: invalid update arguments deploy dir: must be relative"`

### 4.4 Xác nhận cấu hình

Sau khi save, kiểm tra trang **Info** của repo:

| Trường          | Giá trị mong đợi                                      |
|----------------|-------------------------------------------------------|
| **name**        | `pidentist`                                            |
| **url**         | `user@server:domains/domain.com/pidentist.git`        |
| **webhook url** | `https://server:2222/api/git/user/.../webhook`        |
| **deploy dir**  | `public_html/wp-content/themes/pidentist`              |
| **deploy branch**| `main`                                                |
| **remote**      | `https://github.com/username/repo-name.git`           |
| **valid**       | `true` ✅                                              |

> 💡 **Copy lại webhook URL** — sẽ cần ở Bước 3.

---

## 5. Bước 3 — Thêm Webhook trên GitHub

Webhook là "cầu nối" — khi bạn push code, GitHub gửi POST request đến DirectAdmin, báo hiệu có code mới.

### 5.1 Truy cập Webhook Settings

1. Vào GitHub repo → **Settings** → **Webhooks** → **Add webhook**
2. URL: `https://github.com/username/repo-name/settings/hooks`

### 5.2 Điền thông tin

| Trường                | Giá trị                                                    |
|----------------------|-----------------------------------------------------------|
| **Payload URL**       | Paste webhook URL từ DirectAdmin (Bước 4.4)                |
| **Content type**      | `application/json`                                          |
| **Secret**            | Để trống                                                    |
| **SSL verification**  | ⚠️ **Disable** (xem giải thích bên dưới)                   |
| **Which events**      | Chọn **"Just the push event"**                              |
| **Active**            | ✅ Checked                                                  |

3. Click **"Add webhook"**

### 5.3 Tại sao phải Disable SSL verification?

DirectAdmin panel chạy trên port `2222`, thường dùng **self-signed SSL certificate**.
GitHub sẽ reject webhook nếu cert không hợp lệ. Disable SSL verification để GitHub chấp nhận gửi request.

> ⚠️ Điều này chỉ ảnh hưởng webhook delivery, KHÔNG ảnh hưởng SSL của website chính (port 443).

### 5.4 Xác nhận Webhook hoạt động

Sau khi thêm, GitHub sẽ gửi **ping event** để test:
- ✅ **Tick xanh** + "Last delivery was successful" → Thành công
- ❌ **Tick đỏ** + Error → Kiểm tra lại URL hoặc SSL setting

---

## 6. Bước 4 — Force Pull lần đầu

Sau khi webhook kết nối OK, cần **pull code lần đầu** từ GitHub về hosting.

### 6.1 Pull từ DirectAdmin

1. Vào DirectAdmin → **Git**
2. Click vào tên repo (VD: `pidentist`)
3. Tìm nút **"Pull"** hoặc **"Force Deploy"** → Click

### 6.2 Kiểm tra files đã checkout

Sau khi pull, kiểm tra bằng cách truy cập trực tiếp file trên live site:

```
https://yourdomain.com/wp-content/themes/{theme-name}/style.css
```

Nếu thấy nội dung `style.css` của theme → files đã checkout thành công.

> ⚠️ **Lưu ý:** Nếu trước đó bạn đã upload theme bằng ZIP, Force Pull sẽ **ghi đè** toàn bộ files cũ bằng code từ GitHub. Đảm bảo GitHub repo có code mới nhất trước khi pull.

---

## 7. Bước 5 — Test pipeline end-to-end

Đây là bước **bắt buộc** để xác nhận toàn bộ pipeline hoạt động.

### 7.1 Tạo thay đổi nhỏ trên local

Sửa **Version** trong `style.css`:

```css
/* TRƯỚC */
Version: 1.0.0

/* SAU */
Version: 1.0.1
```

### 7.2 Commit và Push

```bash
git add style.css
git commit -m "test: version bump 1.0.1 - verify deploy pipeline"
git push origin main
```

### 7.3 Đợi và kiểm tra

1. **Đợi 10-30 giây** (thời gian webhook → pull → checkout)
2. Truy cập: `https://yourdomain.com/wp-content/themes/{theme-name}/style.css`
3. Kiểm tra Version:
   - Thấy `Version: 1.0.1` → ✅ **Pipeline hoạt động!**
   - Vẫn `Version: 1.0.0` → ❌ Xem phần [Troubleshooting](#9-troubleshooting--lỗi-thường-gặp)

### 7.4 Kiểm tra bổ sung (khuyến nghị)

```bash
# Kiểm tra qua command line (PowerShell)
Invoke-WebRequest -Uri "https://yourdomain.com/wp-content/themes/{theme-name}/style.css" -UseBasicParsing | Select-Object -ExpandProperty Content
```

---

## 8. Bước 6 — Xử lý Cache sau deploy

### 8.1 Vấn đề Cache

Shared hosting thường dùng cache plugins (LiteSpeed Cache, WP Super Cache, etc.). Sau khi deploy code mới, bạn có thể KHÔNG thấy thay đổi ngay vì:

- **Server-side cache** (LiteSpeed, Nginx) trả về HTML/CSS cũ
- **Browser cache** lưu CSS/JS cũ trên máy khách
- **CDN cache** (Cloudflare) có thể cache static files

### 8.2 Giải pháp

| Loại cache     | Cách xử lý                                              |
|---------------|--------------------------------------------------------|
| **Browser**    | Hard refresh: `Ctrl + Shift + R` (hoặc `Cmd + Shift + R`) |
| **LiteSpeed**  | WP Admin → LiteSpeed Cache → **Purge All**              |
| **Cloudflare** | Cloudflare Dashboard → Caching → **Purge Everything**   |
| **Redis/OPcache** | WP Admin → Redis Object Cache → **Flush Cache**      |

### 8.3 Tự động Purge sau deploy (nâng cao)

Nếu hosting hỗ trợ, cấu hình LiteSpeed Cache tự purge khi phát hiện file thay đổi:
- WP Admin → LiteSpeed Cache → General → Auto Purge: **ON**

### 8.4 CSS/JS Versioning

Theme nên sử dụng version parameter trong `wp_enqueue_style/script` để bust cache tự động:

```php
// Trong enqueue.php
$ver = PIDENTIST_VERSION; // Lấy từ style.css Version field
wp_enqueue_style('pi-tokens', $uri . '/assets/css/tokens.css', array(), $ver);
```

Mỗi khi bump version trong `style.css`, URL CSS sẽ đổi thành:
```
tokens.css?ver=1.0.1  →  tokens.css?ver=1.0.2
```
→ Browser tự tải file mới, không cần hard refresh.

---

## 9. Troubleshooting & Lỗi thường gặp

### 9.1 Lỗi "deploy dir: must be relative"

**Nguyên nhân:** Nhập đường dẫn tuyệt đối (bắt đầu bằng `/`).

**Fix:** Dùng đường dẫn tương đối:
```
❌ /home/user/domains/domain.com/public_html/wp-content/themes/mytheme
✅ public_html/wp-content/themes/mytheme
```

### 9.2 Webhook GitHub hiện ❌ đỏ

**Nguyên nhân phổ biến:**
- SSL verification đang Enable → **Disable** nó
- Webhook URL sai → Copy lại từ DirectAdmin Info panel
- Port 2222 bị firewall block → Liên hệ hosting provider

**Kiểm tra:** Click vào webhook → tab **Recent Deliveries** → xem Response code và body.

### 9.3 Push thành công nhưng live site không cập nhật

**Checklist:**
1. Webhook delivery thành công? (GitHub → Settings → Webhooks → Recent Deliveries)
2. DirectAdmin repo valid? (DirectAdmin → Git → Info → valid: true)
3. Deploy directory đúng? (phải trỏ đến thư mục theme)
4. Cache? (Purge All từ LiteSpeed/Cloudflare + Hard refresh browser)
5. Đúng branch? (Deploy branch phải khớp với branch bạn push)

### 9.4 CSS/Layout khác biệt giữa Local và Live

**Nguyên nhân phổ biến:**
- **WordPress version khác nhau** — WP có thể thêm wrapper HTML khác nhau giữa các version
- **Block Editor output** — WP thêm `wp-block-group__inner-container` wrapper với class `is-layout-flow` (flex column), phá vỡ grid layout
- **Plugin conflicts** — Plugins trên hosting có thể inject CSS/JS ảnh hưởng layout

**Fix cho WP Block Editor wrapper:**
Khi dùng CSS grid với WordPress Group blocks, luôn target cả inner container:

```css
/* Grid cho trường hợp KHÔNG có WP wrapper (local dev) */
.my-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}

/* Khi WP thêm inner wrapper: parent → block, inner → grid */
.my-grid:has(> .wp-block-group__inner-container) {
  display: block !important;
}

.my-grid > .wp-block-group__inner-container,
.my-grid > .wp-block-group__inner-container.is-layout-flow {
  display: grid !important;
  grid-template-columns: repeat(3, 1fr) !important;
  gap: 32px !important;
  flex-direction: unset !important;
}
```

> 💡 **Quy tắc vàng:** Sau mỗi lần deploy, luôn hard refresh (`Ctrl+Shift+R`) và kiểm tra trực quan tất cả sections trên live site. So sánh với local để phát hiện khác biệt sớm.

### 9.5 Private Repository — Lỗi authentication

Nếu repo GitHub là **Private**, DirectAdmin không thể clone qua HTTPS mà không có credentials.

**Giải pháp:** Dùng SSH key:
1. DirectAdmin → Git → tạo repo → điền SSH URL: `git@github.com:username/repo.git`
2. DirectAdmin sẽ tạo SSH key → copy public key
3. GitHub → repo Settings → Deploy keys → Add key → paste public key
4. Check "Allow write access" nếu cần

---

## 10. Checklist nhanh

Dùng checklist này cho mỗi lần setup deploy mới:

```
PRE-DEPLOY
□ Code đã push lên GitHub (branch main)
□ WordPress + Parent theme đã cài trên hosting
□ Biết đường dẫn thư mục theme trên hosting

DIRECTADMIN GIT
□ Tạo repository trong DirectAdmin Git
□ Remote URL trỏ đến GitHub repo
□ Deploy Branch = main
□ Deploy Directory = public_html/wp-content/themes/{theme-name}  (TƯƠNG ĐỐI!)
□ Valid = true

GITHUB WEBHOOK
□ Payload URL = webhook URL từ DirectAdmin
□ Content type = application/json
□ SSL verification = Disable
□ Events = Just the push event
□ Active = checked
□ Delivery test = ✅ green tick

FIRST DEPLOY
□ Force Pull từ DirectAdmin
□ Kiểm tra style.css trên live site (URL trực tiếp)
□ Website hiển thị đúng

TEST PIPELINE
□ Bump version trong style.css (local)
□ git commit + git push
□ Đợi 10-30 giây
□ Kiểm tra version mới trên live site
□ Hard refresh (Ctrl+Shift+R) nếu cần
□ Purge cache plugins nếu có

POST-DEPLOY
□ Kiểm tra trực quan tất cả trang chính
□ So sánh local vs live — fix khác biệt CSS/layout
□ Purge LiteSpeed/Cloudflare cache
□ Kiểm tra responsive (mobile, tablet)
```

---

## Phụ lục: Giữ lại GitHub Actions FTP làm Backup

Nếu muốn giữ GitHub Actions FTP như phương án dự phòng (chạy thủ công khi DirectAdmin Git gặp sự cố):

```yaml
# .github/workflows/deploy.yml
name: 🔧 Backup Deploy (FTP Manual)

on:
  workflow_dispatch:
    # Chỉ chạy khi bạn vào Actions tab → click "Run workflow"

jobs:
  deploy:
    name: Deploy theme via FTP
    runs-on: ubuntu-latest
    steps:
      - name: 📥 Checkout code
        uses: actions/checkout@v4

      - name: 🚀 Deploy via FTP
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          server-dir: ${{ secrets.REMOTE_PATH }}
          exclude: |
            **/.git*
            **/.git*/**
            **/node_modules/**
            **/docs/**
            **/*.md
            .github/**
```

**Cách trigger thủ công:**
GitHub → Actions tab → "Backup Deploy (FTP Manual)" → **Run workflow** → Run

---

> 📝 **Tài liệu này được tạo dựa trên kinh nghiệm thực tế deploy dự án Pi Dentist (pidentist.vn), tháng 5/2026.**
> Hosting: DirectAdmin trên Winston (maychu.cloud) | GitHub: QuocDat937/pidentist
