# GEMINI.md — Pi Dentist WordPress Project Rules

> **Tài liệu quy tắc bắt buộc cho AI coding agent.**
> Mọi code sinh ra PHẢI tuân thủ file này từ đầu đến cuối.
> Source of truth: `PROJECT_SPEC_WP.md` + `index.html` (85KB reference).

---

## 1. DỰ ÁN TỔNG QUAN

- **Tên:** Pi Dentist — Website chỉnh nha chuyên sâu
- **Domain:** pidentist.vn
- **Stack:** WordPress 6.4+ | GeneratePress Free (parent) | Child theme `pidentist` | Block Patterns | CPT native
- **Phong cách:** Medical Premium — sang trọng y khoa, KHÔNG phải spa luxury
- **Ngôn ngữ nội dung:** Tiếng Việt
- **Đối tượng:** Người trưởng thành 25-45 tuổi, phụ huynh, Gen Z

---

## 2. NGUYÊN TẮC KIẾN TRÚC — KHÔNG ĐƯỢC VI PHẠM

### 2.1 Block-first, KHÔNG ACF
- **KHÔNG** dùng Advanced Custom Fields (ACF) — dùng `register_post_meta()` + meta boxes native
- **KHÔNG** dùng Elementor, WPBakery, hoặc bất kỳ page builder nào
- Chỉ dùng **Block Editor (Gutenberg)** native + Block Patterns + Synced Patterns
- Block Patterns = "stamp" (copy vào page, sửa độc lập)
- Synced Patterns = "reference" (sửa 1 chỗ, update mọi nơi)

### 2.2 Triết lý "1 file = 1 việc"
- **KHÔNG** nhồi logic vào `functions.php` — chỉ `require_once` các module từ `inc/`
- Mỗi file `inc/*.php` xử lý **1 concern duy nhất**
- Mỗi pattern có file CSS riêng trong `assets/css/patterns/`
- Thứ tự require trong functions.php **QUAN TRỌNG** — xem section 4.3 của spec

### 2.3 GeneratePress Hooks thay vì Override Templates
- Ưu tiên dùng **GP hooks** (`generate_before_header`, `generate_after_header`, etc.) để inject HTML
- Chỉ override template khi thật sự cần (header.php, footer.php, front-page.php, single/archive CPT)
- KHÔNG copy toàn bộ template parent về child — giảm xung đột khi update GP

### 2.4 No jQuery
- Tất cả JavaScript phải là **Vanilla JS** — KHÔNG dùng jQuery
- Defer tất cả JS scripts
- Lazy load khi có thể (carousel chỉ load ở front-page hoặc archive doctor)

### 2.5 Plugin Minimalism
- Chỉ **6 plugins chính**: Custom Post Type UI, Rank Math, Fluent Forms, LiteSpeed Cache, Wordfence, UpdraftPlus
- **3 plugins bổ trợ**: Redis Cache, Nginx Helper, WPS Hide Login
- **KHÔNG** cài thêm plugin ngoài danh sách trên mà không có lý do rõ ràng
- KHÔNG Yoast, KHÔNG WPForms, KHÔNG Elementor, KHÔNG bloat plugins

---

## 3. DESIGN SYSTEM — TOKENS BẮT BUỘC

### 3.1 Color Palette — Chỉ dùng các màu này

```css
--pi-navy:        #002147;
--pi-navy-light:  #003366;
--pi-navy-dark:   #001a33;
--pi-gold:        #C9A96E;
--pi-gold-light:  #E8D5A8;
--pi-gold-hover:  #b8944f;
--pi-white:       #FFFFFF;
--pi-off-white:   #F8F7F4;
--pi-light-gray:  #EDECEA;
--pi-text:        #1A1A1A;
--pi-text-soft:   #666666;
--pi-success:     #2E7D5B;
```

- **Navy chủ đạo** — Gold chỉ điểm nhấn tiết chế
- Block Editor chỉ cho phép 9 màu palette Pi — `add_theme_support('disable-custom-colors')`
- Section rhythm: xen kẽ background `#FFFFFF` ↔ `#F8F7F4`

### 3.2 Typography

```css
--pi-font-heading: 'Playfair Display', Georgia, 'Times New Roman', serif;
--pi-font-body:    'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
```

| Vai trò | Font | Size Desktop | Size Mobile | Weight |
|---------|------|-------------|-------------|--------|
| Hero H1 | Playfair Display | clamp(36px, 5vw, 68px) | 36px | 600 |
| Section H2 | Playfair Display | 42px | 28px | 600 |
| Sub H3 | Inter / Playfair | 18-22px | 18px | 600 |
| Body | Inter | 15-17px | 15-16px | 400 |
| Caption | Inter | 13-14px | 13px | 400 |
| Label uppercase | Inter, letter-spacing 3px | 13px | 13px | 600 |

- Line height body: **1.6–1.8**
- Self-host fonts (woff2) — KHÔNG gọi Google Fonts CDN trên production

### 3.3 Spacing, Radius, Shadows

```css
--pi-radius-card:  16px;
--pi-radius-btn:   6px;
--pi-shadow-sm:    0 2px 8px rgba(0,0,0,0.06);
--pi-shadow-md:    0 8px 30px rgba(0,0,0,0.08);
--pi-shadow-lg:    0 16px 48px rgba(0,0,0,0.12);
--pi-transition:   0.3s cubic-bezier(0.22, 1, 0.36, 1);
--pi-container:    1200px;
```

- Section padding: 100px desktop / 80px tablet / 64px mobile
- Container: max-width 1200px, padding 0 24px
- Gold separator: line 60px × 2px, margin-top 24px

### 3.4 Button Variants — 4 loại duy nhất

| Class | Dùng khi |
|-------|----------|
| `.btn-gold` | CTA chính (nền sáng) |
| `.btn-outline-white` | CTA phụ (nền navy) |
| `.btn-outline-navy` | CTA phụ (nền sáng) |
| `.btn-ghost-white` | CTA trên nền navy, ít nổi bật |

### 3.5 Responsive Breakpoints

- Desktop: ≥1200px
- Tablet: 768px – 1199px
- Mobile: <768px
- **Mobile-first**: >70% traffic dự kiến là mobile

---

## 4. CẤU TRÚC CHILD THEME — PHẢI TUÂN THỦ

```
pidentist/
├── style.css                    # Metadata only (Template: generatepress)
├── functions.php                # Entry point: constants + require modules
├── assets/
│   ├── css/
│   │   ├── tokens.css           # CSS custom properties
│   │   ├── base.css             # Reset, typography, container
│   │   ├── buttons.css          # 4 button variants
│   │   ├── header.css           # Sticky header
│   │   ├── footer.css           # Footer 4 columns
│   │   ├── sections.css         # Common section patterns
│   │   ├── cards.css            # Card hover, shadow
│   │   ├── animations.css       # Reveal, fade-in (CSS-only)
│   │   ├── floating.css         # FloatingCTA, Widgets, BackToTop
│   │   ├── editor.css           # Block Editor admin styles
│   │   └── patterns/            # CSS riêng cho từng Block Pattern
│   ├── js/                      # Vanilla JS, NO jQuery
│   ├── fonts/                   # Self-hosted woff2
│   └── images/
├── inc/                         # PHP modules (1 file = 1 concern)
│   ├── enqueue.php              # wp_enqueue_scripts
│   ├── theme-supports.php       # add_theme_support
│   ├── menus.php                # register_nav_menus + Pi_Nav_Walker
│   ├── cpt.php                  # register_post_type (3 CPT)
│   ├── taxonomies.php           # register_taxonomy (2)
│   ├── meta-fields.php          # register_post_meta + meta boxes
│   ├── block-patterns.php       # register_block_pattern
│   ├── pattern-categories.php   # register_block_pattern_category
│   ├── customizer.php           # theme_mod settings
│   ├── gp-hooks.php             # GeneratePress hook injections
│   ├── floating-elements.php    # wp_footer floating elements
│   ├── shortcodes.php           # [pi_phone], [pi_services_grid], etc.
│   ├── editor-config.php        # Block Editor settings + palette
│   ├── security.php             # Security hardening
│   └── rank-math-defaults.php   # Rank Math custom schema
├── template-parts/              # Reusable fragments (get_template_part)
│   ├── header/                  # site-branding.php, nav-mobile.php
│   ├── footer/                  # footer-brand.php, footer-links.php, footer-bottom.php
│   ├── card/                    # service-card.php, doctor-card.php, case-card.php, post-card.php
│   ├── section/                 # section-header.php, booking-cta.php, page-hero.php
│   └── floating/                # cta.php, contact-widgets.php, back-to-top.php
├── front-page.php               # Trang chủ (render the_content với patterns)
├── header.php                   # Override GP header
├── footer.php                   # Override GP footer
├── single-pi_service.php        # Chi tiết dịch vụ
├── archive-pi_service.php       # Listing dịch vụ /dich-vu/
├── single-pi_doctor.php         # Chi tiết bác sĩ
├── archive-pi_doctor.php        # Listing bác sĩ /bac-si/
├── single-pi_case.php           # Chi tiết case
├── archive-pi_case.php          # Listing case /case/
├── single.php, archive.php      # Blog
├── page.php, 404.php, search.php
└── deploy/                      # Scripts deploy VPS
```

**Khi tạo file mới:** Đặt đúng vị trí theo cấu trúc trên. KHÔNG tạo file PHP rời ngoài cấu trúc.

---

## 5. CUSTOM POST TYPES & DATA

### 5.1 Ba CPT — Prefix `pi_`

| CPT | Slug | Archive | REST base |
|-----|------|---------|-----------|
| `pi_service` | `dich-vu` | `/dich-vu/` | `services` |
| `pi_doctor` | `bac-si` | `/bac-si/` | `doctors` |
| `pi_case` | `case` | `/case/` | `cases` |

- Tất cả CPT phải có `show_in_rest => true` (bắt buộc cho Block Editor)
- Blog dùng built-in Posts, base đổi sang `/kien-thuc/`

### 5.2 Hai Taxonomies

| Taxonomy | Attach to | Hierarchical | Slug |
|----------|-----------|-------------|------|
| `pi_service_category` | `pi_service` | true (categories) | `loai-dich-vu` |
| `pi_case_tag` | `pi_case` | false (tags) | `tag-case` |

### 5.3 Meta Fields — Convention

- Prefix meta keys với `_pi_` (underscore đầu = ẩn khỏi Custom Fields UI)
- Dùng `register_post_meta()` với `show_in_rest => true`
- Sanitize callback phù hợp cho mỗi field type
- V1.0 dùng **Meta Box truyền thống** (`add_meta_box`) — KHÔNG build JS sidebar panel

### 5.4 Globals — Customizer

Thông tin global (phone, email, address, social, hours, promo, map) lưu qua **Customizer** (`get_theme_mod()`):

```php
get_theme_mod('pi_phone')
get_theme_mod('pi_email')
get_theme_mod('pi_address')
get_theme_mod('pi_facebook_url')  // + instagram, youtube, tiktok, zalo
get_theme_mod('pi_hours_weekday') // + saturday, sunday
get_theme_mod('pi_promo_active')
get_theme_mod('pi_promo_text')
get_theme_mod('pi_map_embed')
```

---

## 6. URL STRUCTURE — KHÔNG ĐƯỢC ĐỔI

```
pidentist.vn/
├── /                          Trang chủ (front-page.php)
├── /ve-pi/                    Page
├── /dich-vu/                  Archive pi_service
│   └── /dich-vu/[slug]/       Single pi_service
├── /bac-si/                   Archive pi_doctor
│   └── /bac-si/[slug]/        Single pi_doctor
├── /case/                     Archive pi_case
│   └── /case/[slug]/          Single pi_case
├── /bang-gia/                 Page
├── /kien-thuc/                Blog archive
│   └── /kien-thuc/[slug]/     Single post
├── /lien-he/                  Page
├── /privacy-policy/           Page
└── /terms/                    Page
```

Permalinks: `/%postname%/`

---

## 7. TRANG CHỦ — 11 SECTIONS THEO THỨ TỰ CỐ ĐỊNH

| # | Section | Background | Loại |
|---|---------|-----------|------|
| 1 | Hero Banner | Navy gradient | Block Pattern |
| 2 | Cam kết Pi | #FFFFFF | Block Pattern |
| 3 | Triết lý π | #F8F7F4 | Block Pattern |
| 4 | Đội ngũ BS | #FFFFFF | Dynamic (CPT query) |
| 5 | Công nghệ | #002147 navy | Block Pattern |
| 6 | Dịch vụ | #F8F7F4 | Dynamic (CPT query) |
| 7 | Simulation CTA | #FFFFFF | Block Pattern |
| 8 | Hành trình 5 bước | #F8F7F4 | Block Pattern |
| 9 | Bảng giá | #FFFFFF | Block Pattern |
| 10 | Kiến thức | #F8F7F4 | Dynamic (Posts query) |
| 11 | CTA Booking | #002147 navy | **Synced Pattern** (reuse mọi trang) |

- `front-page.php` chỉ render `the_content()` — admin compose từ Block Editor
- Thứ tự 11 sections **KHÔNG ĐỔI**

---

## 8. QUY TẮC CODE PHP

### 8.1 Security
- Mọi file PHP phải bắt đầu: `defined('ABSPATH') || exit;`
- Sanitize tất cả input: `sanitize_text_field()`, `absint()`, `esc_url_raw()`, `wp_kses_post()`
- Escape tất cả output: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- Nonce cho mọi form/meta box: `wp_nonce_field()` + `wp_verify_nonce()`
- Check capability: `current_user_can('edit_post', $post_id)`
- Check autosave: `defined('DOING_AUTOSAVE') && DOING_AUTOSAVE`

### 8.2 WordPress Coding Standards
- Dùng WordPress hooks/filters — KHÔNG hack core
- Dùng `wp_enqueue_scripts` để load CSS/JS — KHÔNG inline trực tiếp trong templates
- CSS dependency chain: tokens.css phải load TRƯỚC mọi CSS khác
- Enqueue priority 20 (sau parent theme)

### 8.3 Template Parts
- Dùng `get_template_part()` cho mọi fragment reusable
- Truyền data qua `$args` parameter (WP 5.5+)
- Naming: `template-parts/{group}/{name}.php`

### 8.4 Queries
- Dùng `WP_Query` hoặc `get_posts()` — KHÔNG raw SQL
- Luôn `wp_reset_postdata()` sau custom query
- Pagination: `the_posts_pagination()`

---

## 9. QUY TẮC CODE CSS

- Dùng CSS custom properties từ `tokens.css` — KHÔNG hardcode màu/font/shadow
- KHÔNG dùng `!important` trừ khi override GP styles thật sự cần
- Mobile-first approach: base styles cho mobile, `@media (min-width)` cho lớn hơn
- BEM-like naming cho components: `.service-card`, `.service-card__title`
- Animation: dùng `var(--pi-transition)` cho mọi transition
- `prefers-reduced-motion`: tắt animation khi user yêu cầu

---

## 10. QUY TẮC CODE JS

- **Vanilla JS only** — KHÔNG jQuery, KHÔNG framework
- `defer` cho tất cả scripts
- `DOMContentLoaded` listener
- `IntersectionObserver` cho scroll reveal (threshold 0.15)
- Passive event listeners cho scroll: `{ passive: true }`
- Accessibility: `aria-expanded`, `aria-label`, keyboard navigation

---

## 11. SEO — KHÔNG BỎ QUA

- Mọi trang phải có **1 H1 duy nhất** + heading hierarchy H1 > H2 > H3
- Mọi `<img>` phải có `alt` text mô tả bằng tiếng Việt
- Mọi `<a>` phải có text rõ ràng hoặc `aria-label`
- Featured image: 16:9, ≥1200×675, <200KB
- Rank Math SEO score target: ≥80 cho mọi content
- Schema: LocalBusiness/Dentist site-wide, Service+Offer cho CPT service
- Breadcrumbs: `rank_math_the_breadcrumbs()` trong page-hero

---

## 12. PERFORMANCE — MỤC TIÊU

| Chỉ số | Target |
|--------|--------|
| PageSpeed Mobile | ≥ 85 (go-live ≥ 90) |
| PageSpeed Desktop | ≥ 95 |
| LCP | < 2.5s |
| CLS | < 0.1 |
| INP | < 200ms |
| Page weight (homepage) | < 1.5 MB |

- Lazy load images dưới fold
- Preload hero image + critical fonts
- Pattern CSS chỉ load khi cần (`is_front_page()`)
- Carousel JS chỉ load khi cần (front-page hoặc archive doctor)

---

## 13. SECURITY — BẮT BUỘC

- Disable XML-RPC hoàn toàn
- Remove WP version từ headers/scripts
- DISALLOW_FILE_EDIT trong wp-config
- Block author enumeration (`/?author=N` → 403)
- Hide login errors: trả generic message
- Disable REST API `/wp/v2/users` endpoint
- Security headers: X-Content-Type-Options, X-Frame-Options, CSP, Referrer-Policy
- Disable Application Passwords
- DB table prefix: `pi_` (KHÔNG dùng `wp_`)
- Login URL rename: `/dang-nhap-pi/`

---

## 14. ACCESSIBILITY — CHECKLIST

- Skip-to-content link trong header
- ARIA landmarks: `<main>`, `<nav>`, `<header>`, `<footer>`
- `aria-label` cho icon-only buttons (hamburger, back-to-top, social)
- `aria-expanded` cho dropdowns/menus
- Color contrast ≥ 4.5:1
- Keyboard navigation hoạt động cho mọi interactive element
- Focus visible: outline rõ ràng khi Tab
- Lighthouse Accessibility target: ≥ 95

---

## 15. PHASES — THỨ TỰ TRIỂN KHAI

| Phase | Nội dung | Thời gian |
|-------|----------|-----------|
| **0** | LocalWP + child theme skeleton + Git | 0.5-1 ngày |
| **1** | Convert index.html → header/footer/floating/CSS/JS | 2-3 ngày |
| **2** | CPT + Taxonomies + Meta + Templates | 1-2 ngày |
| **3** | Block Patterns + Synced Patterns + Homepage compose | 2-3 ngày |
| **4** | Plugin stack + SEO + Form + Security | 1-2 ngày |
| **5** | Deploy VPS + Nginx + SSL + Cloudflare | 1-2 ngày |
| **6** | Content + Polish + Go-live | 1 ngày |

- Mỗi phase có file prompt riêng: `PHASE0.md` → `PHASE6.md`
- **KHÔNG nhảy phase** — mỗi phase phụ thuộc phase trước
- Kiểm tra "DONE criteria" cuối mỗi phase trước khi tiếp

---

## 16. CONVENTIONS KHI SINH CODE

### 16.1 Khi tạo file mới
- PHP: `<?php defined('ABSPATH') || exit;` dòng đầu tiên
- CSS: comment header `/* Pi Dentist — [module name] */`
- JS: comment header `// Pi Dentist — [module name]`
- Đặt đúng vị trí trong cây thư mục section 4

### 16.2 Khi sửa file hiện có
- Giữ nguyên comments/docstrings không liên quan
- KHÔNG xóa code cũ mà không có lý do
- Tuân thủ pattern đã có trong file

### 16.3 Naming
- PHP functions/hooks: prefix `pi_` (vd: `pi_render_service_meta_box`)
- CSS classes: lowercase-hyphen (vd: `service-card`, `hero-heading`)
- JS: camelCase cho variables, UPPERCASE cho constants
- CPT: prefix `pi_` (vd: `pi_service`)
- Meta keys: prefix `_pi_` (vd: `_pi_service_price_from`)
- Customizer settings: prefix `pi_` (vd: `pi_phone`)
- Enqueue handles: prefix `pi-` (vd: `pi-tokens`, `pi-header`)

### 16.4 Khi không chắc
- **Luôn tham chiếu** `PROJECT_SPEC_WP.md` — đó là "single source of truth"
- **Luôn tham chiếu** `index.html` cho visual/markup reference
- **Luôn tham chiếu** PHASE files cho context của task hiện tại
- Hỏi nếu spec không rõ ràng — KHÔNG tự suy diễn

---

## 17. ĐIỀU TUYỆT ĐỐI KHÔNG LÀM

1. ❌ **KHÔNG** dùng ACF, Elementor, WPBakery, Divi, hoặc bất kỳ page builder
2. ❌ **KHÔNG** dùng jQuery — chỉ Vanilla JS
3. ❌ **KHÔNG** hardcode màu/font — dùng CSS custom properties
4. ❌ **KHÔNG** nhồi logic vào functions.php — tách ra inc/
5. ❌ **KHÔNG** cài plugin ngoài danh sách approved
6. ❌ **KHÔNG** dùng `wp_` prefix cho DB tables — dùng `pi_`
7. ❌ **KHÔNG** để file PHP chạy được trong /wp-content/uploads/
8. ❌ **KHÔNG** dùng `!important` trong CSS trừ khi override GP bắt buộc
9. ❌ **KHÔNG** raw SQL queries — dùng WP_Query/get_posts
10. ❌ **KHÔNG** bỏ qua sanitize/escape — mọi input/output phải xử lý
11. ❌ **KHÔNG** skip nonce verification trong form/meta box
12. ❌ **KHÔNG** đổi URL structure đã định trong spec
13. ❌ **KHÔNG** tạo file ngoài cấu trúc child theme đã định
