# PI DENTIST — PROJECT SPECIFICATION (WORDPRESS EDITION)
> Version 3.0 | March 2026
> Tài liệu kỹ thuật tổng thể — "Single source of truth" cho dự án WordPress
> Replace bản Payload CMS cũ. Stack mới: WordPress + GeneratePress + Block Patterns + CPT.

---

## MỤC LỤC

1. [Tổng quan dự án](#1-tổng-quan-dự-án)
2. [Brand Identity & Design System](#2-brand-identity--design-system)
3. [Tech Stack & Kiến trúc WordPress](#3-tech-stack--kiến-trúc-wordpress)
4. [Cấu trúc Child Theme `pidentist`](#4-cấu-trúc-child-theme-pidentist)
5. [Database Schema — CPT + Taxonomy + Meta](#5-database-schema--cpt--taxonomy--meta)
6. [Sitemap & URL Structure](#6-sitemap--url-structure)
7. [Mapping `index.html` → Template Files](#7-mapping-indexhtml--template-files)
8. [Block Pattern Library (5 patterns chính)](#8-block-pattern-library)
9. [Synced Patterns — Khối tái sử dụng](#9-synced-patterns--khối-tái-sử-dụng)
10. [GeneratePress Hook System](#10-generatepress-hook-system)
11. [Plugin Stack chi tiết](#11-plugin-stack-chi-tiết)
12. [SEO Config với Rank Math](#12-seo-config-với-rank-math)
13. [Form Config với Fluent Forms](#13-form-config-với-fluent-forms)
14. [Performance & Cache](#14-performance--cache)
15. [Security với Wordfence](#15-security-với-wordfence)
16. [Backup Strategy với UpdraftPlus](#16-backup-strategy)
17. [Local Development Environment](#17-local-development-environment)
18. [Deploy Plan — VPS](#18-deploy-plan--vps)
19. [Workflow quản trị nội dung](#19-workflow-quản-trị-nội-dung)
20. [Maintenance & Migration sau này](#20-maintenance--migration)
21. [Timeline triển khai](#21-timeline-triển-khai)

---

## 1. TỔNG QUAN DỰ ÁN

### 1.1 Mục tiêu

Xây dựng website chỉnh nha chuyên sâu đẳng cấp **Medical Premium** cho thương hiệu MỚI **Pi Dentist**. Hệ thống bao gồm 3 phần kết nối 100%:
- **Frontend website công khai** — hiển thị cho khách hàng (pidentist.vn)
- **WP Admin** (`/wp-admin`) — quản lý nội dung, upload ảnh, viết bài, cập nhật giá
- **Database MySQL/MariaDB** — lưu trữ toàn bộ nội dung và cấu hình

### 1.2 Lý do chọn WordPress (thay vì Next.js + Payload)

| Tiêu chí | Next.js + Payload | **WordPress (chọn)** |
|----------|-------------------|----------------------|
| Đường cong học | Cao (cần biết React/TypeScript) | Thấp (admin trực quan, gần như ai cũng dùng được) |
| Vibe code | Cần senior dev hỗ trợ | Tự chỉnh được phần lớn qua admin |
| Plugin ecosystem | Phải tự build | 60.000+ plugins miễn phí |
| Cập nhật nội dung | Phải qua Git redeploy đôi khi | Trực tiếp trên admin, hiện ngay |
| Hosting cost | Vercel + Neon ~$20-40/tháng | VPS 2GB ~$5-10/tháng |
| Backup | Phải tự setup | UpdraftPlus 1 click |
| SEO | Phải tự code metadata | Rank Math GUI đầy đủ |

**Quyết định:** WordPress phù hợp nhất với (1) nhu cầu "upload ảnh, viết bài giống WordPress" của Đạt, (2) team chỉ có 1 người vibe code, (3) ngân sách hosting tối ưu, (4) Brand mới — cần linh hoạt đổi nội dung liên tục giai đoạn đầu.

### 1.3 Nguyên tắc thiết kế (giữ nguyên từ bản cũ)

- **Medical Premium**: Sang trọng y khoa, đáng tin cậy — KHÔNG phải spa luxury
- **Content-driven**: 100% nội dung trên website đều quản trị được từ WP Admin
- **Mobile-first**: Tối ưu mobile (>70% traffic dự kiến)
- **SEO-first**: Server-side rendering native của WP, structured data Rank Math
- **Scalable**: Mở rộng được khi thêm dịch vụ, chi nhánh, bác sĩ
- **No page builder**: KHÔNG dùng Elementor/WPBakery — chỉ Block Editor (Gutenberg) native + Block Patterns + Synced Patterns

### 1.4 Đối tượng khách hàng mục tiêu (giữ nguyên)
- Người trưởng thành 25-45 tuổi, thu nhập cao
- Phụ huynh có con cần niềng răng (12-18 tuổi)
- Giới trẻ Gen Z quan tâm thẩm mỹ

### 1.5 Lưu ý đặc biệt — Brand mới
Pi Dentist là thương hiệu mới hoàn toàn → chưa có case thực tế, testimonials, số liệu kinh nghiệm. Chiến lược nội dung giai đoạn đầu tập trung vào: tầm nhìn, cam kết, tiêu chuẩn, công nghệ, minh bạch giá cả.

### 1.6 Triết lý "Block-first" thay cho "ACF + Custom Fields"

Bản cũ Payload CMS dùng custom fields kiểu schema cố định. Bản WordPress này chọn hướng khác:

- **Block Patterns** = các "khối thiết kế sẵn" insert vào Block Editor → admin tự do compose layout
- **Synced Patterns** = phần nội dung ít thay đổi (footer info, CTA box) — sửa 1 chỗ, update mọi trang
- **CPT (Service, Doctor, Case)** = chỉ những entity thực sự là "danh sách lặp lại" mới cần CPT
- **KHÔNG ACF** (Advanced Custom Fields) trong v1.0 — giảm phụ thuộc plugin, giảm DB query, dễ migrate

**Hệ quả:** Admin Đạt có thể mở 1 Page → click "Pattern" → chọn "Pi - Cam kết grid" → có ngay 4 cột cam kết với style đúng brand → chỉnh chữ là xong. KHÔNG cần code.

---

## 2. BRAND IDENTITY & DESIGN SYSTEM

> Phần này GIỮ NGUYÊN từ PROJECT_SPEC.md cũ — design tokens không đổi vì stack đổi nhưng visual giữ nguyên.

### 2.1 Brand
- **Tên:** Pi Dentist
- **Logo:** Biểu tượng π (pi) + chữ "Pi Dentist"
- **Tagline:** "Kỷ nguyên mới của chỉnh nha chính xác"
- **Triết lý:** Chính xác như hằng số Pi — mỗi ca chỉnh nha được tính toán tỉ mỉ đến từng milimet
- **Domain:** pidentist.vn

### 2.2 Color Palette → CSS Custom Properties

```css
/* assets/css/tokens.css — load qua child theme functions.php */
:root {
  /* Primary — Navy */
  --pi-navy:        #002147;
  --pi-navy-light:  #003366;
  --pi-navy-dark:   #001a33;

  /* Accent — Gold */
  --pi-gold:        #C9A96E;
  --pi-gold-light:  #E8D5A8;
  --pi-gold-hover:  #b8944f;

  /* Neutrals */
  --pi-white:       #FFFFFF;
  --pi-off-white:   #F8F7F4;
  --pi-light-gray:  #EDECEA;
  --pi-text:        #1A1A1A;
  --pi-text-soft:   #666666;
  --pi-success:     #2E7D5B;

  /* Typography */
  --pi-font-heading: 'Playfair Display', Georgia, 'Times New Roman', serif;
  --pi-font-body:    'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

  /* Spacing & Radius */
  --pi-radius-card:  16px;
  --pi-radius-btn:   6px;
  --pi-shadow-sm:    0 2px 8px rgba(0,0,0,0.06);
  --pi-shadow-md:    0 8px 30px rgba(0,0,0,0.08);
  --pi-shadow-lg:    0 16px 48px rgba(0,0,0,0.12);
  --pi-transition:   0.3s cubic-bezier(0.22, 1, 0.36, 1);

  /* Container */
  --pi-container:    1200px;
}
```

### 2.3 Typography Scale

| Vai trò | Font | Size Desktop | Size Mobile | Weight |
|---------|------|-------------|-------------|--------|
| Hero H1 | Playfair Display | clamp(36px, 5vw, 68px) | 36px | 600 |
| Section H2 | Playfair Display | 42px | 28px | 600 |
| Sub H3 | Inter / Playfair (cards) | 18-22px | 18px | 600 |
| Body | Inter | 15-17px | 15-16px | 400 |
| Caption | Inter | 13-14px | 13px | 400 |
| Label uppercase | Inter, letter-spacing 3px | 13px | 13px | 600 |

- Line height body: **1.6–1.8**
- Font weight: 400 / 500 / 600 / 700

### 2.4 Design Principles (đối chiếu với index.html)

- **Whitespace nhiều** — section padding 100px desktop / 80px tablet / 64px mobile
- **Navy chủ đạo** — gold chỉ điểm nhấn tiết chế (chỉ section 5 Technology + 11 CTA dùng nền navy)
- **Section rhythm** — xen kẽ background trắng (#FFF) ↔ off-white (#F8F7F4)
- **Gold separator** — line 60px × 2px, margin-top 24px, phân tách section header
- **Container** — max-width 1200px, padding 0 24px desktop / 0 20px mobile
- **Cards** — border-radius 16px, shadow-sm mặc định, hover translateY(-6px) + shadow-md
- **Buttons** — 4 variants (xem 2.5), border-radius 6px, padding 14px 32px, font-weight 600
- **Transitions** — 0.3s cubic-bezier(0.22, 1, 0.36, 1) cho mọi hover/animation
- **Photography** — ảnh sáng, sạch, tone trung tính. Hiện tại dùng gradient placeholder

### 2.5 Button Variants — class CSS

```css
/* assets/css/buttons.css */
.btn { display: inline-block; padding: 14px 32px; border-radius: 6px;
       font-weight: 600; font-size: 15px; transition: var(--pi-transition);
       text-decoration: none; cursor: pointer; }

.btn-gold { background: var(--pi-gold); color: var(--pi-navy); }
.btn-gold:hover { background: var(--pi-gold-hover); transform: translateY(-2px);
                  box-shadow: 0 8px 20px rgba(201,169,110,0.35); }

.btn-outline-white { background: transparent; border: 1.5px solid rgba(255,255,255,0.5);
                    color: white; }
.btn-outline-white:hover { background: rgba(255,255,255,0.1); border-color: white; }

.btn-outline-navy { background: transparent; border: 1.5px solid var(--pi-navy);
                   color: var(--pi-navy); }
.btn-outline-navy:hover { background: var(--pi-navy); color: white; }

.btn-ghost-white { background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.25);
                  color: white; backdrop-filter: blur(4px); }
.btn-ghost-white:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.5); }
```

### 2.6 Responsive Breakpoints
- Desktop: ≥1200px (container max-width: 1200px)
- Tablet: 768px – 1199px
- Mobile: <768px

---

## 3. TECH STACK & KIẾN TRÚC WORDPRESS

### 3.1 Stack chính thức

| Layer | Công nghệ | Phiên bản | Ghi chú |
|-------|-----------|-----------|---------|
| **CMS Core** | WordPress | 6.4+ | Bản gốc, KHÔNG hack core |
| **Theme cha** | GeneratePress (Free) | 3.4+ | Lightweight, chuẩn Schema, hook system mạnh |
| **Theme con** | `pidentist` (custom) | 1.0 | Code riêng, override style + template |
| **CPT plugin** | Custom Post Type UI | 1.16+ | Tạo CPT/Taxonomy GUI |
| **SEO** | Rank Math (Free) | 1.0.220+ | Meta, Schema, sitemap, breadcrumb |
| **Form** | Fluent Forms (Free) | 5.x | Booking form, lưu DB, gửi email |
| **Cache** | WP Rocket (paid) HOẶC LiteSpeed Cache (free) | mới nhất | Page cache, minify, lazy load |
| **Security** | Wordfence (Free) | 7.x | Firewall, malware scan |
| **Backup** | UpdraftPlus (Free) | 1.x | Auto backup → Google Drive |
| **Editor** | Gutenberg (built-in) | core | Block Editor — KHÔNG dùng Classic |
| **Database** | MariaDB / MySQL | 10.6+ / 8.0+ | InnoDB, utf8mb4 |
| **Server** | Nginx + PHP-FPM | Nginx 1.24+, PHP 8.2+ | OPCache enabled |

### 3.2 Tại sao GeneratePress (không phải Astra/Kadence/Hello)?

| Tiêu chí | GeneratePress | Astra | Kadence | Hello (Elementor) |
|----------|---------------|-------|---------|-------------------|
| Trọng lượng | ~10KB CSS | ~50KB | ~30KB | <2KB nhưng cần Elementor |
| Hooks system | Mạnh nhất, 50+ hooks | Trung bình | Trung bình | Phải dùng Elementor |
| Bản free dùng được? | Đủ cho dự án này | Đủ nhưng thua hooks | Đủ | Phải mua Elementor Pro |
| Schema markup | Đầy đủ | Đầy đủ | Đầy đủ | Phụ thuộc Elementor |
| Page builder dependency | KHÔNG | KHÔNG | KHÔNG | CÓ — không hợp triết lý dự án |
| Customization qua functions.php | Dễ nhất | Dễ | Dễ | Khó hơn |

**Quyết định:** GeneratePress free + child theme `pidentist`. Không cần GP Premium vì child theme tự code custom.

### 3.3 Kiến trúc hệ thống

```
                       pidentist.vn
                            │
                       ┌────┴────┐
                       │  Cloudflare │  (DNS + CDN + SSL + DDoS protection)
                       └────┬────┘
                            │
                       ┌────┴────────┐
                       │   VPS 2GB   │  (DigitalOcean/Vultr/Hetzner)
                       │   Ubuntu 22 │
                       │   Nginx 1.24│
                       │   PHP 8.2   │
                       │   MariaDB   │
                       │   Redis     │  (object cache)
                       └────┬────────┘
                            │
                ┌───────────┼───────────┐
                │           │           │
        ┌───────┴──────┐ ┌──┴──────┐ ┌─┴────────┐
        │  WP Frontend │ │WP Admin │ │ WP Cron  │
        │  /           │ │/wp-admin│ │ /wp-cron │
        └───────┬──────┘ └──┬──────┘ └─┬────────┘
                │           │          │
                └───────────┼──────────┘
                            │
                  ┌─────────┴──────────┐
                  │  MariaDB pidentist │
                  │  + Redis cache     │
                  │  + /wp-content/    │
                  │     uploads/       │
                  └────────────────────┘
                            │
                  ┌─────────┴──────────┐
                  │  Google Drive      │  (Backup destination)
                  │  via UpdraftPlus   │
                  └────────────────────┘
```

**Luồng hoạt động:**
- Khách → `pidentist.vn/*` → Cloudflare CDN → Nginx → PHP → MariaDB → render HTML
- Cache: WP Rocket page cache → Nginx microcache → Cloudflare edge cache (3 lớp)
- Admin → `pidentist.vn/wp-admin` → CRUD nội dung
- Backup hàng ngày: UpdraftPlus → đẩy ZIP lên Google Drive

### 3.4 Phân chia ranh giới: Code (theme) vs Content (admin)

Quy tắc vàng để tránh "spaghetti":

| Nội dung | Quản trị ở đâu | Lý do |
|----------|----------------|-------|
| Logo, font, color, layout cấu trúc | Child theme code | Brand identity — không đổi vặt |
| Header menu, Footer menu | WP Admin → Appearance → Menus | Đổi tần suất thấp nhưng admin cần kiểm soát |
| Hero heading trang chủ | Block Pattern trong Page edit | Marketing có thể A/B test |
| Danh sách dịch vụ (4 thẻ) | CPT `pi_service` | Dữ liệu lặp, có template chi tiết |
| Bài viết blog | Posts (built-in) | Standard WP |
| Số điện thoại, địa chỉ | Synced Pattern + Theme Customizer | Hiện ở footer/header/CTA — sửa 1 chỗ |
| Booking form | Fluent Forms | Plugin chuyên nghiệp |
| SEO meta | Rank Math meta box | Plugin chuyên nghiệp |

---

## 4. CẤU TRÚC CHILD THEME `pidentist`

### 4.1 Cây thư mục đầy đủ

```
pidentist/                                      # /wp-content/themes/pidentist/
│
├── style.css                                   # Theme metadata (BẮT BUỘC) + import GP
├── functions.php                               # Entry point: load tất cả module
├── screenshot.png                              # 1200x900 — hiển thị trong admin
│
├── assets/
│   ├── css/
│   │   ├── tokens.css                          # CSS custom properties (colors, fonts, ...)
│   │   ├── base.css                            # Reset, typography, container
│   │   ├── buttons.css                         # 4 button variants
│   │   ├── header.css                          # Sticky header, transparent → solid
│   │   ├── footer.css                          # Footer 4 columns
│   │   ├── sections.css                        # Common section patterns (label, h2, gold-line)
│   │   ├── cards.css                           # Card hover, shadow
│   │   ├── animations.css                      # Reveal, fade-in (CSS-only, không JS heavy)
│   │   ├── floating.css                        # FloatingCTA, ContactWidgets, BackToTop
│   │   ├── editor.css                          # Style cho Block Editor — admin thấy đúng frontend
│   │   └── patterns/                           # CSS riêng cho từng Block Pattern
│   │       ├── hero.css
│   │       ├── commitments.css
│   │       ├── philosophy.css
│   │       ├── services-grid.css
│   │       ├── pricing-table.css
│   │       └── ...
│   │
│   ├── js/
│   │   ├── header.js                           # Sticky scroll, mobile menu toggle
│   │   ├── reveal.js                           # IntersectionObserver — scroll reveal
│   │   ├── floating.js                         # Show/hide floating CTA on scroll
│   │   ├── carousel.js                         # Doctors carousel (vanilla JS)
│   │   └── smooth-scroll.js                    # Anchor link smooth scroll
│   │
│   ├── fonts/                                  # (Optional) self-host fonts để tối ưu
│   │   ├── Playfair-Display.woff2
│   │   └── Inter.woff2
│   │
│   └── images/
│       ├── logo.svg                            # Logo π
│       ├── logo-white.svg                      # Logo bản trắng (header navy)
│       └── placeholders/                       # Gradient placeholder dùng tạm
│
├── inc/                                        # PHP modules — split functions.php
│   ├── enqueue.php                             # wp_enqueue_scripts: load CSS/JS
│   ├── theme-supports.php                      # add_theme_support()
│   ├── menus.php                               # register_nav_menus()
│   ├── cpt.php                                 # register_post_type() — Service, Doctor, Case
│   ├── taxonomies.php                          # register_taxonomy() — Service Category, Tag
│   ├── meta-fields.php                         # register_post_meta() — custom fields cho CPT
│   ├── block-patterns.php                      # register_block_pattern() — 5 patterns chính
│   ├── pattern-categories.php                  # register_block_pattern_category() — group "Pi"
│   ├── customizer.php                          # add_theme_mod() — phone, address, social
│   ├── gp-hooks.php                            # GeneratePress hooks injection
│   ├── floating-elements.php                   # FloatingCTA + Widgets via wp_footer hook
│   ├── shortcodes.php                          # [pi_phone], [pi_address] dùng trong content
│   ├── editor-config.php                       # Block Editor: disable màu mặc định, set palette
│   └── rank-math-defaults.php                  # Pre-configure Rank Math defaults
│
├── template-parts/                             # Reusable template fragments (get_template_part)
│   ├── header/
│   │   ├── site-branding.php                   # Logo + tên
│   │   └── nav-mobile.php                      # Mobile overlay nav
│   ├── footer/
│   │   ├── footer-brand.php
│   │   ├── footer-links.php
│   │   └── footer-bottom.php                   # © + privacy links
│   ├── card/
│   │   ├── service-card.php                    # Card 1 dịch vụ
│   │   ├── doctor-card.php                     # Card 1 bác sĩ
│   │   ├── case-card.php                       # Card 1 case before/after
│   │   └── post-card.php                       # Card 1 bài viết
│   ├── section/
│   │   ├── section-header.php                  # Label + H2 + gold line
│   │   ├── booking-cta.php                     # Section navy CTA + form (cuối mọi trang)
│   │   └── page-hero.php                       # Hero cho trang con (heading + breadcrumb)
│   └── floating/
│       ├── cta.php
│       ├── contact-widgets.php
│       └── back-to-top.php
│
├── single-pi_service.php                       # Template: chi tiết 1 dịch vụ
├── archive-pi_service.php                      # Template: trang /dich-vu/
├── single-pi_doctor.php                        # Template: chi tiết 1 bác sĩ
├── archive-pi_doctor.php                       # Template: trang /bac-si/
├── single-pi_case.php                          # Template: chi tiết 1 case
├── archive-pi_case.php                         # Template: trang /case/
├── single.php                                  # Template: 1 bài viết blog
├── archive.php                                 # Template: blog listing /kien-thuc/
├── page.php                                    # Template: page mặc định
├── front-page.php                              # Template: TRANG CHỦ (override)
├── page-bang-gia.php                           # Template tùy chỉnh: /bang-gia
├── page-lien-he.php                            # Template tùy chỉnh: /lien-he
├── page-ve-pi.php                              # Template tùy chỉnh: /ve-pi
├── 404.php                                     # Custom 404
├── search.php                                  # Search results
├── searchform.php                              # Search form
├── header.php                                  # Site header (override GP)
├── footer.php                                  # Site footer (override GP)
└── sidebar.php                                 # (nếu cần — blog có sidebar phải)
```

### 4.2 `style.css` — Theme metadata

```css
/*
Theme Name: Pi Dentist
Theme URI: https://pidentist.vn
Description: Child theme của GeneratePress dành riêng cho Pi Dentist — Medical Premium Orthodontic Clinic.
Author: Pi Dentist Dev
Author URI: https://pidentist.vn
Template: generatepress
Version: 1.0.0
Text Domain: pidentist
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/* KHÔNG viết style trong file này — CSS thực tế ở /assets/css/. File này chỉ chứa metadata. */
```

**Quan trọng:**
- `Template: generatepress` → bắt buộc, để WP biết đây là child của GeneratePress
- Phải có folder `generatepress` parent theme cài đặt trước

### 4.3 `functions.php` — Entry point

```php
<?php
/**
 * Pi Dentist Child Theme — Bootstrap
 * KHÔNG viết logic ở đây. Chỉ require các module từ /inc/
 */

defined( 'ABSPATH' ) || exit;

// 1. Constants
define( 'PIDENTIST_VERSION', '1.0.0' );
define( 'PIDENTIST_DIR', get_stylesheet_directory() );
define( 'PIDENTIST_URI', get_stylesheet_directory_uri() );

// 2. Require modules — thứ tự QUAN TRỌNG
require_once PIDENTIST_DIR . '/inc/theme-supports.php';     // add_theme_support
require_once PIDENTIST_DIR . '/inc/enqueue.php';            // load CSS/JS
require_once PIDENTIST_DIR . '/inc/menus.php';              // register nav menus
require_once PIDENTIST_DIR . '/inc/cpt.php';                // CPT registration
require_once PIDENTIST_DIR . '/inc/taxonomies.php';         // taxonomies
require_once PIDENTIST_DIR . '/inc/meta-fields.php';        // post meta
require_once PIDENTIST_DIR . '/inc/customizer.php';         // theme_mod
require_once PIDENTIST_DIR . '/inc/pattern-categories.php'; // pattern groups
require_once PIDENTIST_DIR . '/inc/block-patterns.php';     // patterns
require_once PIDENTIST_DIR . '/inc/editor-config.php';      // block editor settings
require_once PIDENTIST_DIR . '/inc/gp-hooks.php';           // GeneratePress hooks
require_once PIDENTIST_DIR . '/inc/floating-elements.php';  // floating CTA, widgets
require_once PIDENTIST_DIR . '/inc/shortcodes.php';         // [pi_phone] etc.
require_once PIDENTIST_DIR . '/inc/rank-math-defaults.php'; // RM defaults
```

### 4.4 `inc/enqueue.php` — Load CSS/JS đúng cách

```php
<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function() {
    $ver = PIDENTIST_VERSION;

    // 1. Parent theme (GeneratePress) — BẮT BUỘC
    wp_enqueue_style( 'generatepress-style', get_template_directory_uri() . '/style.css' );

    // 2. Google Fonts — preconnect để tăng tốc
    wp_enqueue_style(
        'pi-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    // 3. Tokens (CSS custom properties) — phải load TRƯỚC base
    wp_enqueue_style( 'pi-tokens', PIDENTIST_URI . '/assets/css/tokens.css', [], $ver );

    // 4. Base styles
    wp_enqueue_style( 'pi-base',     PIDENTIST_URI . '/assets/css/base.css',     ['pi-tokens'], $ver );
    wp_enqueue_style( 'pi-buttons',  PIDENTIST_URI . '/assets/css/buttons.css',  ['pi-tokens'], $ver );
    wp_enqueue_style( 'pi-header',   PIDENTIST_URI . '/assets/css/header.css',   ['pi-tokens'], $ver );
    wp_enqueue_style( 'pi-footer',   PIDENTIST_URI . '/assets/css/footer.css',   ['pi-tokens'], $ver );
    wp_enqueue_style( 'pi-sections', PIDENTIST_URI . '/assets/css/sections.css', ['pi-tokens'], $ver );
    wp_enqueue_style( 'pi-cards',    PIDENTIST_URI . '/assets/css/cards.css',    ['pi-tokens'], $ver );
    wp_enqueue_style( 'pi-anim',     PIDENTIST_URI . '/assets/css/animations.css', ['pi-tokens'], $ver );
    wp_enqueue_style( 'pi-floating', PIDENTIST_URI . '/assets/css/floating.css', ['pi-tokens'], $ver );

    // 5. Pattern-specific CSS — chỉ load khi cần (nếu trang chủ thì load homepage patterns)
    if ( is_front_page() ) {
        wp_enqueue_style( 'pi-pat-hero',         PIDENTIST_URI . '/assets/css/patterns/hero.css',         ['pi-tokens'], $ver );
        wp_enqueue_style( 'pi-pat-commitments',  PIDENTIST_URI . '/assets/css/patterns/commitments.css',  ['pi-tokens'], $ver );
        wp_enqueue_style( 'pi-pat-philosophy',   PIDENTIST_URI . '/assets/css/patterns/philosophy.css',   ['pi-tokens'], $ver );
        wp_enqueue_style( 'pi-pat-services',     PIDENTIST_URI . '/assets/css/patterns/services-grid.css', ['pi-tokens'], $ver );
        wp_enqueue_style( 'pi-pat-pricing',      PIDENTIST_URI . '/assets/css/patterns/pricing-table.css', ['pi-tokens'], $ver );
    }

    // 6. JS — defer cho mọi script
    wp_enqueue_script( 'pi-header',  PIDENTIST_URI . '/assets/js/header.js',       [], $ver, true );
    wp_enqueue_script( 'pi-reveal',  PIDENTIST_URI . '/assets/js/reveal.js',       [], $ver, true );
    wp_enqueue_script( 'pi-float',   PIDENTIST_URI . '/assets/js/floating.js',     [], $ver, true );
    wp_enqueue_script( 'pi-smooth',  PIDENTIST_URI . '/assets/js/smooth-scroll.js',[], $ver, true );

    // 7. Carousel — chỉ load khi có /bac-si/ hoặc trang chủ
    if ( is_front_page() || is_post_type_archive('pi_doctor') ) {
        wp_enqueue_script( 'pi-carousel', PIDENTIST_URI . '/assets/js/carousel.js', [], $ver, true );
    }
}, 20 );

// Defer non-critical JS
add_filter( 'script_loader_tag', function( $tag, $handle ) {
    $defer = ['pi-header', 'pi-reveal', 'pi-float', 'pi-smooth', 'pi-carousel'];
    if ( in_array( $handle, $defer, true ) ) {
        return str_replace( ' src=', ' defer src=', $tag );
    }
    return $tag;
}, 10, 2 );

// Editor styles — admin Block Editor cũng phải đẹp giống frontend
add_action( 'after_setup_theme', function() {
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/tokens.css' );
    add_editor_style( 'assets/css/editor.css' );
});
```

### 4.5 Triết lý "1 file = 1 việc"

- KHÔNG nhồi mọi thứ vào `functions.php`
- Mỗi file `inc/*.php` xử lý 1 concern duy nhất → dễ debug, dễ maintain
- Mỗi pattern có file CSS riêng trong `assets/css/patterns/` → bật/tắt theo từng trang

---

## 5. DATABASE SCHEMA — CPT + TAXONOMY + META

### 5.1 Triết lý: WordPress native, KHÔNG ACF

WordPress đã có sẵn 5 bảng mạnh để lưu dữ liệu:

| Bảng | Dùng cho |
|------|----------|
| `wp_posts` | Post, Page, CPT items (tất cả "content") |
| `wp_postmeta` | Custom fields cho từng post (key/value) |
| `wp_terms` + `wp_term_taxonomy` + `wp_term_relationships` | Categories, Tags, Custom Taxonomies |
| `wp_options` | Global settings, theme mods (Customizer) |
| `wp_users` + `wp_usermeta` | Admin/Editor users |

→ Chỉ cần **3 CPT** + **2 Taxonomy** + **register_post_meta** là đủ. KHÔNG cần ACF.

### 5.2 Custom Post Types — đăng ký trong `inc/cpt.php`

#### CPT 1: `pi_service` — Dịch vụ chỉnh nha

```php
register_post_type( 'pi_service', [
    'label'              => 'Dịch vụ',
    'labels' => [
        'name'               => 'Dịch vụ',
        'singular_name'      => 'Dịch vụ',
        'add_new'            => 'Thêm dịch vụ',
        'add_new_item'       => 'Thêm dịch vụ mới',
        'edit_item'          => 'Chỉnh sửa dịch vụ',
        'all_items'          => 'Tất cả dịch vụ',
        'view_item'          => 'Xem dịch vụ',
        'search_items'       => 'Tìm dịch vụ',
        'not_found'          => 'Không có dịch vụ nào',
        'menu_name'          => 'Dịch vụ',
    ],
    'public'             => true,
    'has_archive'        => 'dich-vu',                  // /dich-vu/ → archive
    'rewrite'            => [ 'slug' => 'dich-vu', 'with_front' => false ],
    'menu_icon'          => 'dashicons-smiley',
    'menu_position'      => 20,
    'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ],
    // 'page-attributes' = bật field "Order" để sắp xếp thủ công
    'show_in_rest'       => true,                       // BẮT BUỘC để dùng Block Editor
    'rest_base'          => 'services',
    'taxonomies'         => [ 'pi_service_category' ],
] );
```

**Custom meta fields** (dùng `register_post_meta`):

| Meta key | Type | Mô tả | Show in REST |
|----------|------|--------|---------------|
| `_pi_service_tagline` | string | "Hiệu quả cao, chi phí hợp lý" | true |
| `_pi_service_price_from` | number | Giá từ (triệu VND) — VD: 25 | true |
| `_pi_service_duration` | string | "18-24 tháng" | true |
| `_pi_service_suitable_for` | string | "Mọi trường hợp chỉnh nha" | true |
| `_pi_service_advantages` | array of string | Ưu điểm | true |
| `_pi_service_disadvantages` | array of string | Nhược điểm | true |
| `_pi_service_faq` | array of object `{q, a}` | FAQ riêng dịch vụ | true |
| `_pi_service_thumb_color` | string | "metal" / "ceramic" / "clear" / "lingual" — dùng cho gradient placeholder | true |
| `_pi_service_is_featured` | boolean | Hiển thị trang chủ | true |

```php
// inc/meta-fields.php — ví dụ đăng ký 1 meta
register_post_meta( 'pi_service', '_pi_service_price_from', [
    'type'              => 'number',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'absint',
    'auth_callback'     => function() { return current_user_can( 'edit_posts' ); },
] );
```

**Editor side panel** — Để admin nhập các meta này dễ dàng, có 2 lựa chọn:

1. **Custom block với `useEntityProp`** (recommended) — viết 1 plugin nhỏ tạo Sidebar Panel custom trong Block Editor.
2. **Meta Box custom** (fallback) — nếu không muốn viết JS, dùng `add_meta_box` truyền thống.

→ **V1.0 dùng Meta Box custom** (đơn giản, ổn định, KHÔNG cần build JS). Migration sang Custom Block panel ở v2.0.

```php
// inc/meta-fields.php — Meta Box truyền thống
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'pi_service_details',
        'Thông tin dịch vụ Pi',
        'pi_render_service_meta_box',
        'pi_service',
        'side',
        'high'
    );
});

function pi_render_service_meta_box( $post ) {
    wp_nonce_field( 'pi_service_meta', 'pi_service_meta_nonce' );
    $tagline      = get_post_meta( $post->ID, '_pi_service_tagline', true );
    $price        = get_post_meta( $post->ID, '_pi_service_price_from', true );
    $duration     = get_post_meta( $post->ID, '_pi_service_duration', true );
    $suitable     = get_post_meta( $post->ID, '_pi_service_suitable_for', true );
    $thumb_color  = get_post_meta( $post->ID, '_pi_service_thumb_color', true );
    $is_featured  = get_post_meta( $post->ID, '_pi_service_is_featured', true );
    ?>
    <p>
        <label><strong>Tagline ngắn:</strong></label>
        <input type="text" name="pi_service_tagline" value="<?php echo esc_attr( $tagline ); ?>" class="widefat" />
    </p>
    <p>
        <label><strong>Giá từ (triệu VND):</strong></label>
        <input type="number" name="pi_service_price_from" value="<?php echo esc_attr( $price ); ?>" class="widefat" />
    </p>
    <p>
        <label><strong>Thời gian điều trị:</strong></label>
        <input type="text" name="pi_service_duration" value="<?php echo esc_attr( $duration ); ?>" class="widefat" placeholder="18-24 tháng" />
    </p>
    <p>
        <label><strong>Phù hợp cho:</strong></label>
        <input type="text" name="pi_service_suitable_for" value="<?php echo esc_attr( $suitable ); ?>" class="widefat" />
    </p>
    <p>
        <label><strong>Kiểu màu thumbnail:</strong></label>
        <select name="pi_service_thumb_color" class="widefat">
            <option value="metal"   <?php selected( $thumb_color, 'metal' ); ?>>Kim loại (xám)</option>
            <option value="ceramic" <?php selected( $thumb_color, 'ceramic' ); ?>>Sứ (trắng-vàng)</option>
            <option value="clear"   <?php selected( $thumb_color, 'clear' ); ?>>Trong suốt (xanh nhạt)</option>
            <option value="lingual" <?php selected( $thumb_color, 'lingual' ); ?>>Mặt trong (đen-vàng)</option>
        </select>
    </p>
    <p>
        <label>
            <input type="checkbox" name="pi_service_is_featured" value="1" <?php checked( $is_featured, '1' ); ?> />
            <strong>Hiển thị trên trang chủ</strong>
        </label>
    </p>
    <?php
}

add_action( 'save_post_pi_service', function( $post_id ) {
    if ( ! isset( $_POST['pi_service_meta_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['pi_service_meta_nonce'], 'pi_service_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [
        'pi_service_tagline'      => '_pi_service_tagline',
        'pi_service_price_from'   => '_pi_service_price_from',
        'pi_service_duration'     => '_pi_service_duration',
        'pi_service_suitable_for' => '_pi_service_suitable_for',
        'pi_service_thumb_color'  => '_pi_service_thumb_color',
    ];
    foreach ( $fields as $form => $meta ) {
        if ( isset( $_POST[ $form ] ) ) {
            update_post_meta( $post_id, $meta, sanitize_text_field( $_POST[ $form ] ) );
        }
    }
    update_post_meta( $post_id, '_pi_service_is_featured', isset( $_POST['pi_service_is_featured'] ) ? '1' : '0' );
});
```

#### CPT 2: `pi_doctor` — Bác sĩ

```php
register_post_type( 'pi_doctor', [
    'label'         => 'Bác sĩ',
    'labels'        => [
        'name' => 'Bác sĩ',
        'singular_name' => 'Bác sĩ',
        'add_new_item' => 'Thêm bác sĩ mới',
        'edit_item' => 'Chỉnh sửa bác sĩ',
        'all_items' => 'Tất cả bác sĩ',
        'menu_name' => 'Bác sĩ',
    ],
    'public'        => true,
    'has_archive'   => 'bac-si',
    'rewrite'       => [ 'slug' => 'bac-si', 'with_front' => false ],
    'menu_icon'     => 'dashicons-businessperson',
    'menu_position' => 21,
    'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ],
    'show_in_rest'  => true,
    'rest_base'     => 'doctors',
] );
```

**Meta fields:**

| Meta key | Type | Mô tả |
|----------|------|--------|
| `_pi_doctor_title` | string | "Bác sĩ chỉnh nha", "Trưởng khoa" |
| `_pi_doctor_credentials` | array of string | Bằng cấp |
| `_pi_doctor_specialties` | array of string | Chuyên sâu |
| `_pi_doctor_education` | string (HTML) | Quá trình đào tạo (richtext qua content editor) |
| `_pi_doctor_certifications` | array of object `{name, issuer, year}` | Chứng chỉ |
| `_pi_doctor_services` | array of int (post IDs) | Liên kết tới `pi_service` posts |
| `_pi_doctor_is_featured` | boolean | Hiển thị trang chủ |

#### CPT 3: `pi_case` — Ca điều trị (Before/After)

```php
register_post_type( 'pi_case', [
    'label'         => 'Ca điều trị',
    'labels'        => [
        'name' => 'Ca điều trị',
        'singular_name' => 'Ca điều trị',
        'add_new_item' => 'Thêm ca mới',
        'edit_item' => 'Chỉnh sửa ca',
        'all_items' => 'Tất cả ca',
        'menu_name' => 'Ca điều trị',
    ],
    'public'        => true,
    'has_archive'   => 'case',
    'rewrite'       => [ 'slug' => 'case', 'with_front' => false ],
    'menu_icon'     => 'dashicons-images-alt2',
    'menu_position' => 22,
    'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
    'show_in_rest'  => true,
    'rest_base'     => 'cases',
] );
```

**Meta fields:**

| Meta key | Type | Mô tả |
|----------|------|--------|
| `_pi_case_doctor_id` | int | ID bác sĩ điều trị (relation → pi_doctor) |
| `_pi_case_service_id` | int | ID dịch vụ sử dụng (relation → pi_service) |
| `_pi_case_patient_age` | string | "25 tuổi" |
| `_pi_case_patient_gender` | string | "male" / "female" |
| `_pi_case_duration` | string | "18 tháng" |
| `_pi_case_before_images` | array of int | IDs ảnh trong Media Library — TRƯỚC điều trị |
| `_pi_case_after_images` | array of int | IDs ảnh — SAU điều trị |
| `_pi_case_diagnosis` | string | Chẩn đoán ban đầu |
| `_pi_case_treatment_plan` | string (HTML) | Kế hoạch điều trị |
| `_pi_case_result` | string (HTML) | Kết quả đạt được |
| `_pi_case_is_featured` | boolean | Hiển thị trang chủ |

### 5.3 Taxonomies — `inc/taxonomies.php`

#### Taxonomy 1: `pi_service_category` — phân loại dịch vụ

```php
register_taxonomy( 'pi_service_category', [ 'pi_service' ], [
    'label'             => 'Loại dịch vụ',
    'hierarchical'      => true,                            // Hành xử như Categories (có parent/child)
    'show_in_rest'      => true,
    'show_admin_column' => true,
    'rewrite'           => [ 'slug' => 'loai-dich-vu' ],
] );
```

**Terms mặc định:** Mắc cài | Trong suốt | Mặt trong | Trẻ em (4 nhóm chính)

#### Taxonomy 2: `pi_case_tag` — tag cho ca điều trị

```php
register_taxonomy( 'pi_case_tag', [ 'pi_case' ], [
    'label'             => 'Tag ca',
    'hierarchical'      => false,                           // Hành xử như Tags
    'show_in_rest'      => true,
    'show_admin_column' => true,
    'rewrite'           => [ 'slug' => 'tag-case' ],
] );
```

**Terms gợi ý:** hô | móm | thưa | khấp khểnh | khớp cắn sâu | khớp cắn hở | tuổi teen | người lớn

### 5.4 Posts (built-in) — dùng cho Blog

Tận dụng built-in `Posts` của WordPress cho Blog. KHÔNG tạo CPT mới.

- URL: `/kien-thuc/[slug]/` (đổi permalink base từ default `/blog/` sang `/kien-thuc/`)
- Categories: "Kiến thức", "Hướng dẫn", "Tin tức", "Câu chuyện"
- Author: WP user (gán bác sĩ làm author bằng cách tạo user role "doctor")
- Custom meta: `_pi_post_read_time` (auto-calculate từ content length)

```php
// Đổi permalink base /category/* → /kien-thuc/category/* (optional)
add_action( 'init', function() {
    global $wp_rewrite;
    $wp_rewrite->set_category_base( '/kien-thuc/category' );
});
```

### 5.5 Bookings — Lưu vào Fluent Forms

KHÔNG tạo CPT cho Bookings. Fluent Forms tự lưu submissions vào bảng riêng:
- `wp_fluentform_forms` — định nghĩa form
- `wp_fluentform_submissions` — submissions của khách

→ Admin xem booking ở `/wp-admin/admin.php?page=fluent_forms` → tab "Submissions".

### 5.6 Globals — Customizer + Synced Patterns

Thay vì Payload "Globals", WordPress dùng kết hợp:

| Loại nội dung | Lưu ở đâu | Truy cập trong template |
|--------------|-----------|--------------------------|
| Logo, phone, email, address | **Customizer** (`theme_mod`) | `get_theme_mod('pi_phone')` |
| Working hours, social links | Customizer | `get_theme_mod('pi_facebook_url')` |
| Promo banner text | Customizer (boolean + text) | `get_theme_mod('pi_promo_active')` |
| Map embed | Customizer (textarea) | `get_theme_mod('pi_map_embed')` |
| Hero heading trang chủ | **Block Pattern** trong Page edit | Edit page "Trang chủ" |
| Featured cases / posts | **Block** "Latest Posts/CPT" với filter `_pi_*_is_featured = 1` | Auto query |
| Pricing rows | **Synced Pattern** "Pi - Bảng giá" | Insert vào Page bảng giá |

### 5.7 Customizer config — `inc/customizer.php`

```php
add_action( 'customize_register', function( $wp_customize ) {

    // Section: Pi Dentist - Thông tin chung
    $wp_customize->add_section( 'pi_general', [
        'title'    => 'Pi - Thông tin chung',
        'priority' => 30,
    ] );

    // Phone
    $wp_customize->add_setting( 'pi_phone', [
        'default'           => '0909 XXX XXX',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'pi_phone', [
        'label'   => 'Hotline',
        'section' => 'pi_general',
        'type'    => 'text',
    ] );

    // Email
    $wp_customize->add_setting( 'pi_email', [
        'default'           => 'info@pidentist.vn',
        'sanitize_callback' => 'sanitize_email',
    ] );
    $wp_customize->add_control( 'pi_email', [
        'label'   => 'Email',
        'section' => 'pi_general',
        'type'    => 'email',
    ] );

    // Address
    $wp_customize->add_setting( 'pi_address', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ] );
    $wp_customize->add_control( 'pi_address', [
        'label'   => 'Địa chỉ',
        'section' => 'pi_general',
        'type'    => 'textarea',
    ] );

    // Working hours (3 fields)
    foreach ( [
        'pi_hours_weekday'  => [ 'Thứ 2 – Thứ 6', '8:00 – 20:00' ],
        'pi_hours_saturday' => [ 'Thứ 7',         '8:00 – 17:00' ],
        'pi_hours_sunday'   => [ 'Chủ nhật',      'Nghỉ' ],
    ] as $key => $info ) {
        $wp_customize->add_setting( $key, [ 'default' => $info[1], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [
            'label'   => 'Giờ làm việc — ' . $info[0],
            'section' => 'pi_general',
            'type'    => 'text',
        ] );
    }

    // Section: Social Links
    $wp_customize->add_section( 'pi_social', [ 'title' => 'Pi - Mạng xã hội', 'priority' => 31 ] );
    foreach ( [ 'facebook', 'instagram', 'youtube', 'tiktok', 'zalo' ] as $sn ) {
        $wp_customize->add_setting( "pi_{$sn}_url", [ 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ] );
        $wp_customize->add_control( "pi_{$sn}_url", [
            'label'   => ucfirst( $sn ),
            'section' => 'pi_social',
            'type'    => 'url',
        ] );
    }

    // Section: Promo Banner
    $wp_customize->add_section( 'pi_promo', [ 'title' => 'Pi - Ưu đãi', 'priority' => 32 ] );
    $wp_customize->add_setting( 'pi_promo_active', [ 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean' ] );
    $wp_customize->add_control( 'pi_promo_active', [
        'label'   => 'Bật banner ưu đãi',
        'section' => 'pi_promo',
        'type'    => 'checkbox',
    ] );
    $wp_customize->add_setting( 'pi_promo_text', [
        'default'           => 'Ưu đãi khai trương: Scan 3D miễn phí + Giảm 20% phí điều trị',
        'sanitize_callback' => 'wp_kses_post',
    ] );
    $wp_customize->add_control( 'pi_promo_text', [
        'label'   => 'Nội dung ưu đãi',
        'section' => 'pi_promo',
        'type'    => 'textarea',
    ] );

    // Section: Map embed
    $wp_customize->add_section( 'pi_map', [ 'title' => 'Pi - Bản đồ Google', 'priority' => 33 ] );
    $wp_customize->add_setting( 'pi_map_embed', [
        'default'           => '',
        'sanitize_callback' => function( $val ) {
            // Chỉ cho phép iframe Google Maps
            return wp_kses( $val, [ 'iframe' => [
                'src' => true, 'width' => true, 'height' => true, 'style' => true,
                'allowfullscreen' => true, 'loading' => true, 'referrerpolicy' => true,
            ] ] );
        },
    ] );
    $wp_customize->add_control( 'pi_map_embed', [
        'label'       => 'Iframe Google Maps embed',
        'description' => 'Vào Google Maps → Share → Embed a map → copy iframe paste vào đây',
        'section'     => 'pi_map',
        'type'        => 'textarea',
    ] );
});
```

### 5.8 Sơ đồ quan hệ dữ liệu

```
                        ┌─────────────────┐
                        │  pi_service     │
                        │  (CPT)          │
                        └────────┬────────┘
                                 │
                ┌────────────────┼────────────────┐
                │                │                │
                │ taxonomy       │ meta           │ relation
                │                │                │
        ┌───────┴────────┐ ┌─────┴─────┐  ┌──────┴──────┐
        │pi_service_     │ │ price_from│  │  pi_doctor  │ (qua _pi_doctor_services)
        │  category      │ │ duration  │  │   (CPT)     │
        │  (Taxonomy)    │ │ tagline   │  └─────────────┘
        └────────────────┘ └───────────┘

                        ┌─────────────────┐
                        │   pi_case       │
                        │   (CPT)         │
                        └────────┬────────┘
                                 │
                ┌────────────────┼────────────────┐
                │                │                │
                │ taxonomy       │ meta           │ relations
                │                │                │
        ┌───────┴────────┐ ┌─────┴────────────┐ ┌─┴────────────┐
        │ pi_case_tag    │ │ before_images[]  │ │ doctor_id     │
        │  (Taxonomy)    │ │ after_images[]   │ │ service_id    │
        └────────────────┘ │ patient_age      │ └───────────────┘
                          │ duration         │
                          └──────────────────┘
```

---

## 6. SITEMAP & URL STRUCTURE

### 6.1 URL chính thức

```
pidentist.vn/
├── /                                       Trang chủ — front-page.php
├── /ve-pi/                                 Page → page-ve-pi.php
├── /dich-vu/                               Archive pi_service → archive-pi_service.php
│   ├── /dich-vu/nieng-mac-cai-kim-loai/    Single → single-pi_service.php
│   ├── /dich-vu/nieng-mac-cai-su/
│   ├── /dich-vu/nieng-trong-suot/
│   └── /dich-vu/nieng-mat-trong/
├── /loai-dich-vu/[slug]/                   Term archive — taxonomy-pi_service_category.php
├── /bac-si/                                Archive pi_doctor
│   └── /bac-si/[slug]/
├── /case/                                  Archive pi_case
│   ├── /case/[slug]/
│   └── /tag-case/[term]/                   Term archive
├── /bang-gia/                              Page → page-bang-gia.php
├── /kien-thuc/                             Posts archive (đổi base)
│   ├── /kien-thuc/[slug]/                  Single post
│   └── /kien-thuc/category/[cat]/          Category archive
├── /lien-he/                               Page → page-lien-he.php
│
├── /wp-admin/                              Admin Panel
├── /wp-login.php                           (RENAME → /pi-login để bảo mật)
│
├── /sitemap_index.xml                      Rank Math auto-generated
├── /robots.txt                             WP virtual robots.txt
└── /favicon.ico
```

### 6.2 WP Settings → Permalinks

```
Settings → Permalinks → Custom Structure:
  /%postname%/

Optional (nếu blog cần date archive):
  /kien-thuc/%postname%/    via Post Permalink Base
```

### 6.3 Đổi base `/blog/` → `/kien-thuc/`

```php
// inc/cpt.php — bottom of file
add_action( 'init', function() {
    // Posts (built-in) base
    global $wp_rewrite;
    $wp_rewrite->set_permastruct( 'post', '/kien-thuc/%postname%/' );
});

// Flush rewrite rules MỘT LẦN sau khi update — không tự động trong init
register_activation_hook( __FILE__, 'flush_rewrite_rules' );
```

→ Sau khi đổi: vào Settings → Permalinks → click "Save" để rebuild rewrite rules.

### 6.4 Static vs Dynamic — Caching Strategy

| Route | Cache | Lý do |
|-------|-------|-------|
| `/` (trang chủ) | Page cache 1h, purge khi sửa | Trang home thay đổi không thường xuyên |
| `/ve-pi/`, `/lien-he/`, `/bang-gia/` | Page cache 24h | Static content |
| `/dich-vu/` archive + `/dich-vu/[slug]/` | Page cache 6h, purge on edit | Edit qua admin → purge cache |
| `/bac-si/`, `/case/` archive + single | Page cache 6h, purge on edit | Same |
| `/kien-thuc/` + bài viết | Page cache 12h, purge on publish | Bài mới ít → cache lâu OK |
| `/wp-admin/` | KHÔNG cache | Admin live data |
| Booking form submit | KHÔNG cache (nonce) | Bảo mật |

→ Cấu hình trong WP Rocket / LiteSpeed Cache.

### 6.5 Redirect mapping (bản cũ → bản mới nếu cần)

Nếu sau này migrate từ site cũ:

```nginx
# Nginx redirects — vào server block
location = /old-services { return 301 /dich-vu/; }
location = /old-team     { return 301 /bac-si/; }
```

Hoặc dùng Rank Math → Redirections (GUI).

---

## 7. MAPPING `index.html` → TEMPLATE FILES

> Đây là phần quan trọng nhất: chuyển 11 sections HTML hiện có thành **Block Patterns** + **Template files** WordPress.

### 7.1 Nguyên tắc mapping

| HTML hiện tại | WordPress equivalent | Ghi chú |
|--------------|---------------------|---------|
| `<header class="site-header">` | `header.php` (override GP) | Sticky scroll JS giữ nguyên |
| `<section class="hero">` | **Block Pattern** "Pi - Hero Banner" + chèn trong front-page.php | Admin có thể đổi heading/CTA qua editor |
| `<section class="commitments">` | **Block Pattern** "Pi - Cam kết grid" | Static content — pattern reusable |
| `<section class="philosophy">` | **Block Pattern** "Pi - Triết lý 2 columns" | Static |
| `<section class="doctors">` | **Template part** `template-parts/section/doctors-carousel.php` query CPT | Dynamic data |
| `<section class="technology">` | **Block Pattern** "Pi - Công nghệ navy" | Static |
| `<section class="services">` | **Template part** query CPT `pi_service` | Dynamic — dùng `template-parts/card/service-card.php` |
| `<section class="simulation">` | **Block Pattern** "Pi - Simulation CTA" | Static |
| `<section class="journey">` | **Block Pattern** "Pi - Timeline 5 bước" | Static |
| `<section class="pricing">` | **Block Pattern** "Pi - Bảng giá table" | Static (số liệu cập nhật qua editor) |
| `<section class="knowledge">` | **Template part** query Posts | Dynamic |
| `<section class="cta-booking">` | **Synced Pattern** "Pi - CTA Booking + Form" | Reusable cuối mọi trang |
| `<footer class="site-footer">` | `footer.php` + `template-parts/footer/*.php` | |
| Floating elements | `wp_footer` action hook trong `inc/floating-elements.php` | |

### 7.2 Template hierarchy đầy đủ

WordPress áp dụng [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/) — tự động chọn file template:

| URL | Template được dùng |
|-----|---------------------|
| `/` | `front-page.php` (chỉ định trong Settings → Reading) |
| `/ve-pi/` | `page-ve-pi.php` → fallback `page.php` |
| `/lien-he/` | `page-lien-he.php` |
| `/bang-gia/` | `page-bang-gia.php` |
| `/dich-vu/` | `archive-pi_service.php` → fallback `archive.php` |
| `/dich-vu/nieng-trong-suot/` | `single-pi_service.php` → fallback `single.php` |
| `/bac-si/` | `archive-pi_doctor.php` |
| `/bac-si/bs-nguyen-van-a/` | `single-pi_doctor.php` |
| `/case/` | `archive-pi_case.php` |
| `/case/[slug]/` | `single-pi_case.php` |
| `/loai-dich-vu/[term]/` | `taxonomy-pi_service_category.php` |
| `/kien-thuc/` | `home.php` (Posts page) → fallback `index.php` |
| `/kien-thuc/[slug]/` | `single.php` |
| 404 | `404.php` |
| Search | `search.php` |

### 7.3 `front-page.php` — Trang chủ

**Chiến lược:** Trang chủ là 1 Page WordPress (tên "Trang chủ"), chứa các Block Patterns. Template `front-page.php` chỉ cần render `the_content()` — admin tự compose từ Block Editor.

```php
<?php
/**
 * front-page.php — Trang chủ Pi Dentist
 * 
 * Trang chủ là 1 Page admin tạo (Settings → Reading → Static front page).
 * Nội dung gồm các Block Patterns đã insert vào Block Editor.
 * 11 sections theo thứ tự, KHÔNG đổi.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="pi-front-page">
    <?php
    // Render content từ Page editor — chứa tất cả 11 patterns
    while ( have_posts() ) {
        the_post();
        the_content();
    }
    ?>
</main>

<?php
// CTA Booking form được insert qua synced pattern, KHÔNG hardcode ở đây
// Floating elements load qua wp_footer hook
get_footer();
```

**Workflow tạo trang chủ:**
1. WP Admin → Pages → Add New → tiêu đề "Trang chủ"
2. Trong Block Editor: click `+` → Patterns tab → category "Pi Dentist - Homepage"
3. Insert lần lượt 11 patterns đúng thứ tự:
   - `Pi - Hero Banner` → `Pi - Cam kết grid` → `Pi - Triết lý` → `Pi - Đội ngũ bác sĩ` → `Pi - Công nghệ` → `Pi - Dịch vụ` → `Pi - Simulation CTA` → `Pi - Timeline` → `Pi - Bảng giá` → `Pi - Kiến thức` → `Pi - CTA Booking` (synced)
4. Publish
5. Settings → Reading → "Your homepage displays" → A static page → chọn "Trang chủ"

### 7.4 `archive-pi_service.php` — Trang `/dich-vu/`

```php
<?php
/**
 * archive-pi_service.php — Trang tổng dịch vụ
 * Match design "service grid" + page hero
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="pi-archive pi-archive-services">

    <?php
    // 1. Page Hero — template part chuẩn cho mọi archive/single
    get_template_part( 'template-parts/section/page-hero', null, [
        'label'    => 'DỊCH VỤ',
        'heading'  => 'Phương pháp chỉnh nha phù hợp cho bạn',
        'sub'      => 'Mỗi phương pháp được tối ưu cho từng nhu cầu và lối sống khác nhau',
    ] );
    ?>

    <section class="services-archive">
        <div class="container">
            <div class="services-grid">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/card/service-card' );
                    endwhile;
                else :
                    echo '<p>Chưa có dịch vụ nào.</p>';
                endif;
                ?>
            </div>

            <?php the_posts_pagination([
                'prev_text' => '← Trước',
                'next_text' => 'Sau →',
            ]); ?>
        </div>
    </section>

    <?php
    // 2. Bảng so sánh — Synced Pattern "Pi - So sánh phương pháp"
    block_template_part( 'pi-pricing-comparison' );
    ?>

    <?php
    // 3. CTA Booking cuối trang — Synced Pattern
    block_template_part( 'pi-cta-booking' );
    ?>

</main>

<?php get_footer();
```

### 7.5 `template-parts/card/service-card.php` — Card 1 dịch vụ

Match HTML index.html dòng 2442–2455:

```php
<?php
/**
 * template-parts/card/service-card.php
 * Render 1 service card. Cần $post setup từ The Loop.
 */

defined( 'ABSPATH' ) || exit;

$thumb_color = get_post_meta( get_the_ID(), '_pi_service_thumb_color', true ) ?: 'metal';
$tagline     = get_post_meta( get_the_ID(), '_pi_service_tagline', true );
$price       = get_post_meta( get_the_ID(), '_pi_service_price_from', true );
$suitable    = get_post_meta( get_the_ID(), '_pi_service_suitable_for', true );
?>
<article class="service-card reveal">
    <a href="<?php the_permalink(); ?>" class="service-thumb <?php echo esc_attr( $thumb_color ); ?>">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium_large', [ 'loading' => 'lazy', 'alt' => get_the_title() ] ); ?>
        <?php else : ?>
            <div class="service-thumb-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><rect x="3" y="8" width="18" height="8" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7 8V6a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
            </div>
        <?php endif; ?>
    </a>
    <div class="service-body">
        <h3 class="service-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php if ( $tagline ) : ?>
            <p class="service-tagline"><?php echo esc_html( $tagline ); ?></p>
        <?php endif; ?>
        <?php if ( $price ) : ?>
            <p class="service-price">Từ <?php echo esc_html( $price ); ?> triệu</p>
        <?php endif; ?>
        <?php if ( $suitable ) : ?>
            <p class="service-target">Phù hợp: <?php echo esc_html( $suitable ); ?></p>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="text-link">Tìm hiểu thêm →</a>
    </div>
</article>
```

### 7.6 `single-pi_service.php` — Chi tiết 1 dịch vụ

```php
<?php
/**
 * single-pi_service.php — Chi tiết dịch vụ
 */

defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
    the_post();
    $service_id = get_the_ID();
    $tagline    = get_post_meta( $service_id, '_pi_service_tagline', true );
    $price      = get_post_meta( $service_id, '_pi_service_price_from', true );
    $duration   = get_post_meta( $service_id, '_pi_service_duration', true );
    $suitable   = get_post_meta( $service_id, '_pi_service_suitable_for', true );
    $advantages = get_post_meta( $service_id, '_pi_service_advantages', true );
    $disadvantages = get_post_meta( $service_id, '_pi_service_disadvantages', true );
    $faq        = get_post_meta( $service_id, '_pi_service_faq', true );
?>

<main id="main-content" class="pi-single-service">

    <?php
    get_template_part( 'template-parts/section/page-hero', null, [
        'label'   => 'DỊCH VỤ',
        'heading' => get_the_title(),
        'sub'     => $tagline,
        'breadcrumb' => true,
    ]);
    ?>

    <article class="service-detail">
        <div class="container">

            <!-- Quick info bar -->
            <div class="service-meta">
                <div class="meta-item">
                    <span class="meta-label">Giá từ</span>
                    <strong><?php echo esc_html( $price ); ?> triệu</strong>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Thời gian</span>
                    <strong><?php echo esc_html( $duration ); ?></strong>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Phù hợp</span>
                    <strong><?php echo esc_html( $suitable ); ?></strong>
                </div>
            </div>

            <!-- Mô tả chi tiết -->
            <div class="service-description prose">
                <?php the_content(); ?>
            </div>

            <!-- Ưu điểm / Nhược điểm 2 columns -->
            <?php if ( $advantages || $disadvantages ) : ?>
                <div class="pros-cons-grid">
                    <?php if ( $advantages ) : ?>
                        <div class="pros">
                            <h3>Ưu điểm</h3>
                            <ul class="check-list">
                                <?php foreach ( (array) $advantages as $adv ) : ?>
                                    <li><span class="check-icon">✓</span> <?php echo esc_html( $adv ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if ( $disadvantages ) : ?>
                        <div class="cons">
                            <h3>Lưu ý</h3>
                            <ul class="cross-list">
                                <?php foreach ( (array) $disadvantages as $dis ) : ?>
                                    <li><span class="cross-icon">!</span> <?php echo esc_html( $dis ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- FAQ riêng -->
            <?php if ( $faq && is_array( $faq ) ) : ?>
                <section class="service-faq">
                    <h2>Câu hỏi thường gặp</h2>
                    <?php foreach ( $faq as $item ) : ?>
                        <details class="faq-item">
                            <summary><?php echo esc_html( $item['q'] ); ?></summary>
                            <div class="faq-answer"><?php echo wp_kses_post( $item['a'] ); ?></div>
                        </details>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <!-- Doctors phụ trách (query liên kết) -->
            <?php
            $doctors = get_posts([
                'post_type'      => 'pi_doctor',
                'posts_per_page' => -1,
                'meta_query'     => [
                    [
                        'key'     => '_pi_doctor_services',
                        'value'   => sprintf( ':"%d"', $service_id ),
                        'compare' => 'LIKE',
                    ],
                ],
            ]);
            if ( $doctors ) :
            ?>
                <section class="related-doctors">
                    <h2>Bác sĩ chuyên về dịch vụ này</h2>
                    <div class="doctors-grid">
                        <?php foreach ( $doctors as $doc ) : setup_postdata( $doc ); ?>
                            <?php get_template_part( 'template-parts/card/doctor-card' ); ?>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Cases liên quan -->
            <?php
            $cases = get_posts([
                'post_type'      => 'pi_case',
                'posts_per_page' => 4,
                'meta_query'     => [
                    [ 'key' => '_pi_case_service_id', 'value' => $service_id ],
                ],
            ]);
            if ( $cases ) :
            ?>
                <section class="related-cases">
                    <h2>Cases đã thực hiện</h2>
                    <div class="cases-grid">
                        <?php foreach ( $cases as $case ) : setup_postdata( $case ); ?>
                            <?php get_template_part( 'template-parts/card/case-card' ); ?>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </article>

    <?php block_template_part( 'pi-cta-booking' ); ?>

</main>

<?php
endwhile;
get_footer();
```

### 7.7 `header.php` — Override GeneratePress header

```php
<?php
/**
 * header.php — Pi Dentist
 * Override GeneratePress header để match index.html structure exactly.
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'pidentist' ); ?></a>

<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php bloginfo( 'name' ); ?> trang chủ">
                <span class="logo-symbol">π</span>
                <span class="logo-text">Pi Dentist</span>
            </a>

            <!-- Main nav -->
            <nav class="main-nav" aria-label="Menu chính">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'primary',
                    'container'       => false,
                    'items_wrap'      => '%3$s',                  // Bỏ <ul>
                    'walker'          => new Pi_Nav_Walker(),     // Custom walker (xem section 10.5)
                    'depth'           => 2,
                    'fallback_cb'     => false,
                ]);
                ?>
            </nav>

            <!-- CTA -->
            <div class="header-cta">
                <a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold">Đặt lịch tư vấn</a>
            </div>

            <!-- Hamburger (mobile only) -->
            <button class="hamburger" id="hamburger" aria-label="Mở menu" aria-expanded="false" aria-controls="mobileNav">
                <span></span><span></span><span></span>
            </button>

        </div>
    </div>
</header>

<!-- Mobile Nav Overlay -->
<?php get_template_part( 'template-parts/header/nav-mobile' ); ?>
```

### 7.8 `footer.php`

```php
<?php
/**
 * footer.php — Pi Dentist
 */
defined( 'ABSPATH' ) || exit;
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <?php
            get_template_part( 'template-parts/footer/footer-brand' );
            get_template_part( 'template-parts/footer/footer-links' );
            ?>
        </div>
        <?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
    </div>
</footer>

<?php
// Floating elements được hook vào wp_footer ở inc/floating-elements.php
wp_footer();
?>

</body>
</html>
```

### 7.9 Bảng tổng hợp — 11 sections trang chủ

| # | Section | Background | Implementation | File |
|---|---------|-----------|---------------|------|
| 1 | Hero Banner | Navy overlay | Block Pattern `pi/hero-banner` | `inc/block-patterns.php` + `assets/css/patterns/hero.css` |
| 2 | Cam kết Pi | #FFFFFF | Block Pattern `pi/commitments` | Same |
| 3 | Triết lý π | #F8F7F4 | Block Pattern `pi/philosophy` | Same |
| 4 | Đội ngũ BS | #FFFFFF | Template part query `pi_doctor` (insert qua block "Latest Posts") | `template-parts/section/doctors-carousel.php` |
| 5 | Công nghệ | #002147 | Block Pattern `pi/technology-navy` | Same |
| 6 | Dịch vụ | #F8F7F4 | Template part query `pi_service` | `template-parts/section/services-grid.php` |
| 7 | Simulation CTA | #FFFFFF | Block Pattern `pi/simulation-cta` | Same |
| 8 | Hành trình | #F8F7F4 | Block Pattern `pi/timeline-5` | Same |
| 9 | Bảng giá | #FFFFFF | Block Pattern `pi/pricing-table` | Same |
| 10 | Kiến thức | #F8F7F4 | Template part query Posts (insert qua block "Latest Posts") | `template-parts/section/knowledge-blog.php` |
| 11 | CTA Booking | #002147 | **Synced Pattern** `pi-cta-booking` (reuse mọi trang) | Tạo trong WP Admin |

→ 5 patterns chính cần code (#1, #2, #3, #5, #7, #8, #9 — thực ra là 7 nhưng gộp #4 #6 #10 #11 vào dynamic templates).

→ Mục tiêu "5 Block Patterns chính" của Đạt = các patterns *trang chủ static*: Hero, Cam kết, Triết lý, Technology, Simulation CTA, Timeline, Pricing. Trong đó **5 đặc trưng nhất** là:
1. **Pi - Hero Banner** (navy + gold CTA + scroll indicator)
2. **Pi - Commitments Grid** (4 cột icon + heading + desc)
3. **Pi - Philosophy 2-column** (π symbol bên trái + text bên phải)
4. **Pi - Technology Navy** (section navy với gold accents)
5. **Pi - Pricing Table** (table responsive + highlight row)

Còn `pi-cta-booking` là **Synced Pattern** (reuse cuối mọi trang).

---

## 8. BLOCK PATTERN LIBRARY

### 8.1 Block Pattern là gì? Tại sao chọn nó?

**Block Pattern** = một đoạn block markup được định nghĩa sẵn trong code, admin có thể **insert** vào bất kỳ Page/Post nào qua menu Patterns trong Block Editor. Sau khi insert, admin có thể chỉnh sửa nội dung từng block tự do — pattern KHÔNG ràng buộc lại.

**Ưu điểm so với Page Builder (Elementor/WPBakery):**
- KHÔNG plugin nặng — tận dụng Block Editor native
- Markup chuẩn HTML semantic (block group + block heading + block paragraph)
- CSS riêng theo class — không "div-soup"
- Dễ migrate (export → import block markup)

**Khác biệt với Synced Pattern:**
- Block Pattern: "stamp" — copy vào page, sửa độc lập
- Synced Pattern: "reference" — sửa 1 chỗ, update mọi nơi đã insert

### 8.2 Đăng ký Pattern Categories — `inc/pattern-categories.php`

```php
<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern_category( 'pi-homepage', [
        'label'       => 'Pi Dentist - Homepage',
        'description' => 'Các sections của trang chủ Pi Dentist',
    ] );
    register_block_pattern_category( 'pi-sections', [
        'label'       => 'Pi Dentist - Sections',
        'description' => 'Các block section dùng cho trang con',
    ] );
    register_block_pattern_category( 'pi-cta', [
        'label'       => 'Pi Dentist - CTA',
        'description' => 'Khối Call-to-Action',
    ] );
});

// Ẩn các pattern category mặc định của WP cho gọn
add_filter( 'should_load_remote_block_patterns', '__return_false' );
```

### 8.3 Đăng ký 5 Patterns chính — `inc/block-patterns.php`

```php
<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {

    // ═══════════════════════════════════════════════
    // PATTERN 1: Pi - Hero Banner
    // ═══════════════════════════════════════════════
    register_block_pattern( 'pi/hero-banner', [
        'title'       => 'Pi - Hero Banner (Navy)',
        'description' => 'Banner hero trang chủ với heading lớn và CTA gold/outline-white',
        'categories'  => [ 'pi-homepage' ],
        'keywords'    => [ 'hero', 'banner', 'home', 'trang chủ' ],
        'content'     => '
<!-- wp:group {"className":"pi-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group pi-hero">
  <!-- wp:html -->
  <div class="hero-bg" aria-hidden="true"></div>
  <!-- /wp:html -->
  <!-- wp:group {"className":"hero-content","layout":{"type":"constrained","contentSize":"800px"}} -->
  <div class="wp-block-group hero-content">
    <!-- wp:paragraph {"className":"hero-label"} -->
    <p class="hero-label">CHỈNH NHA CHUYÊN SÂU</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":1,"className":"hero-heading"} -->
    <h1 class="wp-block-heading hero-heading">Kỷ nguyên mới<br>của chỉnh nha chính xác</h1>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"className":"hero-sub"} -->
    <p class="hero-sub">Nơi mỗi nụ cười được thiết kế với độ chính xác tuyệt đối — như hằng số π</p>
    <!-- /wp:paragraph -->
    <!-- wp:buttons {"className":"hero-ctas"} -->
    <div class="wp-block-buttons hero-ctas">
      <!-- wp:button {"className":"btn btn-gold"} -->
      <div class="wp-block-button btn btn-gold"><a class="wp-block-button__link" href="/lien-he/">Đặt lịch tư vấn miễn phí</a></div>
      <!-- /wp:button -->
      <!-- wp:button {"className":"btn btn-outline-white"} -->
      <div class="wp-block-button btn btn-outline-white"><a class="wp-block-button__link" href="/ve-pi/">Khám phá Pi Dentist</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
  <!-- wp:html -->
  <div class="scroll-indicator" aria-hidden="true"><span>Cuộn xuống</span><div class="scroll-arrow"></div></div>
  <!-- /wp:html -->
</div>
<!-- /wp:group -->
        ',
    ] );

    // ═══════════════════════════════════════════════
    // PATTERN 2: Pi - Commitments Grid (4 cột)
    // ═══════════════════════════════════════════════
    register_block_pattern( 'pi/commitments', [
        'title'       => 'Pi - Cam kết grid (4 cột)',
        'description' => 'Grid 4 cam kết: chuyên chỉnh nha, BS quốc tế, công nghệ số, theo dõi trọn đời',
        'categories'  => [ 'pi-homepage', 'pi-sections' ],
        'content'     => '
<!-- wp:group {"className":"commitments","backgroundColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group commitments has-white-background-color has-background">
  <!-- wp:group {"className":"commitments-grid","layout":{"type":"grid","columnCount":4}} -->
  <div class="wp-block-group commitments-grid">

    <!-- wp:group {"className":"commitment-item"} -->
    <div class="wp-block-group commitment-item">
      <!-- wp:html -->
      <div class="commitment-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l7 4.5-7 4.5z" stroke="currentColor" fill="none" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" fill="none" stroke-width="1.5"/></svg></div>
      <!-- /wp:html -->
      <!-- wp:heading {"level":3,"className":"commitment-title"} -->
      <h3 class="wp-block-heading commitment-title">Chỉ chuyên chỉnh nha</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"commitment-desc"} -->
      <p class="commitment-desc">100% tập trung vào chỉnh nha — không dàn trải, không đa khoa. Mỗi ca là một tác phẩm.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"commitment-item"} -->
    <div class="wp-block-group commitment-item">
      <!-- wp:html -->
      <div class="commitment-icon"><svg viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3z" stroke="currentColor" fill="none" stroke-width="1.5"/></svg></div>
      <!-- /wp:html -->
      <!-- wp:heading {"level":3,"className":"commitment-title"} -->
      <h3 class="wp-block-heading commitment-title">Bác sĩ đào tạo quốc tế</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"commitment-desc"} -->
      <p class="commitment-desc">Đội ngũ bác sĩ được đào tạo tại các trung tâm chỉnh nha hàng đầu thế giới.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"commitment-item"} -->
    <div class="wp-block-group commitment-item">
      <!-- wp:html -->
      <div class="commitment-icon"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" fill="none" stroke-width="1.5"/><path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="1.5"/></svg></div>
      <!-- /wp:html -->
      <!-- wp:heading {"level":3,"className":"commitment-title"} -->
      <h3 class="wp-block-heading commitment-title">Công nghệ số 100%</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"commitment-desc"} -->
      <p class="commitment-desc">CBCT 3D, scan kỹ thuật số, phần mềm AI lập kế hoạch — chính xác đến từng milimet.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"commitment-item"} -->
    <div class="wp-block-group commitment-item">
      <!-- wp:html -->
      <div class="commitment-icon"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" fill="none" stroke-width="1.5"/></svg></div>
      <!-- /wp:html -->
      <!-- wp:heading {"level":3,"className":"commitment-title"} -->
      <h3 class="wp-block-heading commitment-title">Theo dõi trọn đời</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"commitment-desc"} -->
      <p class="commitment-desc">Cam kết đồng hành từ ngày đầu đến khi hoàn tất — và theo dõi kết quả trọn đời.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
        ',
    ] );

    // ═══════════════════════════════════════════════
    // PATTERN 3: Pi - Philosophy 2-column
    // ═══════════════════════════════════════════════
    register_block_pattern( 'pi/philosophy', [
        'title'       => 'Pi - Triết lý π (2 columns)',
        'description' => 'Section triết lý: ký tự π lớn bên trái, text giải thích bên phải',
        'categories'  => [ 'pi-homepage', 'pi-sections' ],
        'content'     => '
<!-- wp:group {"className":"philosophy","layout":{"type":"constrained"}} -->
<div class="wp-block-group philosophy">
  <!-- wp:columns {"className":"philosophy-grid"} -->
  <div class="wp-block-columns philosophy-grid">

    <!-- wp:column {"className":"philosophy-visual"} -->
    <div class="wp-block-column philosophy-visual">
      <!-- wp:html -->
      <span class="pi-symbol" aria-hidden="true">π</span>
      <!-- /wp:html -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"className":"philosophy-content"} -->
    <div class="wp-block-column philosophy-content">
      <!-- wp:paragraph {"className":"section-label"} -->
      <p class="section-label">VỀ PI DENTIST</p>
      <!-- /wp:paragraph -->
      <!-- wp:heading {"level":2,"className":"section-heading"} -->
      <h2 class="wp-block-heading section-heading">Chính xác như hằng số π</h2>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"philosophy-text"} -->
      <p class="philosophy-text">Pi (π) là hằng số vô tỉ, vô hạn — nhưng chính xác tuyệt đối. Pi Dentist mang triết lý đó vào từng ca chỉnh nha: mỗi milimet dịch chuyển, mỗi góc nghiêng răng đều được tính toán bằng công nghệ số hiện đại nhất.</p>
      <!-- /wp:paragraph -->
      <!-- wp:paragraph {"className":"philosophy-text"} -->
      <p class="philosophy-text">Chúng tôi tin rằng một nụ cười đẹp không đến từ may mắn — mà đến từ sự chính xác trong từng bước điều trị, từ chẩn đoán đến hoàn thiện.</p>
      <!-- /wp:paragraph -->
      <!-- wp:paragraph -->
      <p><a class="text-link" href="/ve-pi/">Tìm hiểu thêm về Pi →</a></p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
        ',
    ] );

    // ═══════════════════════════════════════════════
    // PATTERN 4: Pi - Technology Navy
    // ═══════════════════════════════════════════════
    register_block_pattern( 'pi/technology-navy', [
        'title'       => 'Pi - Công nghệ (nền navy)',
        'description' => 'Section nền navy với 3 cards công nghệ + CTA ghost-white',
        'categories'  => [ 'pi-homepage' ],
        'content'     => '
<!-- wp:group {"className":"technology pi-navy-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group technology pi-navy-bg" style="background-color:#002147;color:#fff">
  <!-- wp:group {"className":"section-header","layout":{"type":"constrained","contentSize":"720px"}} -->
  <div class="wp-block-group section-header">
    <!-- wp:paragraph {"className":"section-label section-label-gold"} -->
    <p class="section-label section-label-gold">CÔNG NGHỆ &amp; TIÊU CHUẨN</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":2,"className":"section-heading section-heading-white"} -->
    <h2 class="wp-block-heading section-heading section-heading-white">Hệ thống công nghệ chỉnh nha hiện đại nhất</h2>
    <!-- /wp:heading -->
    <!-- wp:html -->
    <div class="gold-line"></div>
    <!-- /wp:html -->
  </div>
  <!-- /wp:group -->

  <!-- wp:group {"className":"tech-grid","layout":{"type":"grid","columnCount":3}} -->
  <div class="wp-block-group tech-grid">
    <!-- wp:group {"className":"tech-item"} -->
    <div class="wp-block-group tech-item">
      <!-- wp:heading {"level":3} --><h3 class="wp-block-heading">CBCT 3D Scanner</h3><!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p>Chụp cắt lớp 3D toàn hàm, độ phân giải cao — chẩn đoán chính xác đến từng milimet.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    <!-- wp:group {"className":"tech-item"} -->
    <div class="wp-block-group tech-item">
      <!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Scan kỹ thuật số iTero</h3><!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p>Quét hàm không cần lấy dấu silicone — nhanh, sạch, không khó chịu.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    <!-- wp:group {"className":"tech-item"} -->
    <div class="wp-block-group tech-item">
      <!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Phần mềm AI lập kế hoạch</h3><!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p>Mô phỏng kết quả 3D trước khi điều trị — biết trước nụ cười tương lai.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:group -->

  <!-- wp:buttons {"className":"tech-cta"} -->
  <div class="wp-block-buttons tech-cta">
    <!-- wp:button {"className":"btn btn-ghost-white"} -->
    <div class="wp-block-button btn btn-ghost-white"><a class="wp-block-button__link" href="/lien-he/">Đặt lịch trải nghiệm scan miễn phí</a></div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->
</div>
<!-- /wp:group -->
        ',
    ] );

    // ═══════════════════════════════════════════════
    // PATTERN 5: Pi - Pricing Table
    // ═══════════════════════════════════════════════
    register_block_pattern( 'pi/pricing-table', [
        'title'       => 'Pi - Bảng giá (table)',
        'description' => 'Bảng so sánh 4 phương pháp — giá, thời gian, đặc điểm',
        'categories'  => [ 'pi-homepage', 'pi-sections' ],
        'content'     => '
<!-- wp:group {"className":"pricing","layout":{"type":"constrained"}} -->
<div class="wp-block-group pricing">

  <!-- wp:group {"className":"section-header","layout":{"type":"constrained","contentSize":"720px"}} -->
  <div class="wp-block-group section-header">
    <!-- wp:paragraph {"className":"section-label"} -->
    <p class="section-label">BẢNG GIÁ</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":2,"className":"section-heading"} -->
    <h2 class="wp-block-heading section-heading">Minh bạch từ chi phí đến kết quả</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"className":"section-sub"} -->
    <p class="section-sub">Cam kết không phát sinh — giá niêm yết là giá cuối cùng</p>
    <!-- /wp:paragraph -->
    <!-- wp:html --><div class="gold-line"></div><!-- /wp:html -->
  </div>
  <!-- /wp:group -->

  <!-- wp:html -->
  <table class="pricing-table">
    <thead>
      <tr>
        <th>Phương pháp</th>
        <th>Giá từ</th>
        <th>Thời gian</th>
        <th>Đặc điểm nổi bật</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>Mắc cài kim loại</strong></td>
        <td>XX triệu</td>
        <td>18-24 tháng</td>
        <td>Hiệu quả cao, chi phí hợp lý</td>
        <td><a href="/dich-vu/nieng-mac-cai-kim-loai/" class="text-link">Chi tiết →</a></td>
      </tr>
      <tr>
        <td><strong>Mắc cài sứ</strong></td>
        <td>XX triệu</td>
        <td>20-26 tháng</td>
        <td>Thẩm mỹ tốt cho người đi làm</td>
        <td><a href="/dich-vu/nieng-mac-cai-su/" class="text-link">Chi tiết →</a></td>
      </tr>
      <tr class="highlight">
        <td><strong>Niềng trong suốt</strong></td>
        <td>XX triệu</td>
        <td>12-18 tháng</td>
        <td>Gần như vô hình, thoải mái</td>
        <td><a href="/dich-vu/nieng-trong-suot/" class="text-link">Chi tiết →</a></td>
      </tr>
      <tr>
        <td><strong>Niềng mặt trong</strong></td>
        <td>XX triệu</td>
        <td>20-30 tháng</td>
        <td>Hoàn toàn ẩn, bí mật tuyệt đối</td>
        <td><a href="/dich-vu/nieng-mat-trong/" class="text-link">Chi tiết →</a></td>
      </tr>
    </tbody>
  </table>
  <!-- /wp:html -->

  <!-- wp:group {"className":"installment-box"} -->
  <div class="wp-block-group installment-box">
    <!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Trả góp 0% lãi suất</h3><!-- /wp:heading -->
    <!-- wp:paragraph -->
    <p>Hỗ trợ trả góp lên đến 24 tháng qua các thẻ tín dụng — chỉ từ XX triệu/tháng.</p>
    <!-- /wp:paragraph -->
  </div>
  <!-- /wp:group -->

</div>
<!-- /wp:group -->
        ',
    ] );

}); // end add_action init
```

### 8.4 CSS cho từng Pattern

Mỗi pattern có file CSS riêng trong `assets/css/patterns/`. Ví dụ `commitments.css`:

```css
/* assets/css/patterns/commitments.css */
.commitments {
    padding: 100px 0;
    background: var(--pi-white);
}
.commitments .commitments-grid {
    max-width: var(--pi-container);
    margin: 0 auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px;
}
.commitments .commitment-item {
    text-align: center;
    padding: 32px 16px;
    background: var(--pi-off-white);
    border-radius: var(--pi-radius-card);
    border: 1px solid var(--pi-light-gray);
    transition: var(--pi-transition);
}
.commitments .commitment-item:hover {
    transform: translateY(-6px);
    box-shadow: var(--pi-shadow-md);
    border-color: var(--pi-gold);
}
.commitments .commitment-icon {
    width: 56px; height: 56px;
    margin: 0 auto 20px;
    color: var(--pi-gold);
}
.commitments .commitment-icon svg { width: 100%; height: 100%; }
.commitments .commitment-title {
    font-family: var(--pi-font-heading);
    font-size: 20px;
    font-weight: 600;
    color: var(--pi-navy);
    margin: 0 0 12px;
}
.commitments .commitment-desc {
    font-size: 15px;
    line-height: 1.7;
    color: var(--pi-text-soft);
    margin: 0;
}
@media (max-width: 1199px) {
    .commitments .commitments-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
    .commitments { padding: 80px 0; }
}
@media (max-width: 600px) {
    .commitments .commitments-grid { grid-template-columns: 1fr; }
    .commitments { padding: 64px 0; }
}
```

### 8.5 Editor preview (đảm bảo admin thấy đúng frontend)

```php
// inc/editor-config.php
add_action( 'after_setup_theme', function() {
    add_theme_support( 'editor-styles' );

    // Load tokens + base + tất cả pattern CSS để editor render đúng
    add_editor_style( [
        'assets/css/tokens.css',
        'assets/css/base.css',
        'assets/css/buttons.css',
        'assets/css/sections.css',
        'assets/css/patterns/hero.css',
        'assets/css/patterns/commitments.css',
        'assets/css/patterns/philosophy.css',
        'assets/css/patterns/services-grid.css',
        'assets/css/patterns/pricing-table.css',
        'assets/css/editor.css',
    ] );

    // Disable Block Editor "Pattern Library" remote
    remove_theme_support( 'core-block-patterns' );
});

// Custom color palette — chỉ cho phép dùng màu Pi
add_action( 'after_setup_theme', function() {
    add_theme_support( 'editor-color-palette', [
        [ 'name' => 'Navy',       'slug' => 'navy',       'color' => '#002147' ],
        [ 'name' => 'Navy nhạt',  'slug' => 'navy-light', 'color' => '#003366' ],
        [ 'name' => 'Navy đậm',   'slug' => 'navy-dark',  'color' => '#001a33' ],
        [ 'name' => 'Vàng gold',  'slug' => 'gold',       'color' => '#C9A96E' ],
        [ 'name' => 'Vàng nhạt',  'slug' => 'gold-light', 'color' => '#E8D5A8' ],
        [ 'name' => 'Trắng',      'slug' => 'white',      'color' => '#FFFFFF' ],
        [ 'name' => 'Trắng warm', 'slug' => 'off-white',  'color' => '#F8F7F4' ],
        [ 'name' => 'Text',       'slug' => 'text',       'color' => '#1A1A1A' ],
        [ 'name' => 'Text nhạt',  'slug' => 'text-soft',  'color' => '#666666' ],
    ] );
    add_theme_support( 'disable-custom-colors' );
});
```

→ Admin chỉ chọn được 9 màu trong palette → KHÔNG thể "lệch brand".

---

## 9. SYNCED PATTERNS — KHỐI TÁI SỬ DỤNG

### 9.1 Synced Pattern là gì?

Trước WP 6.3 gọi là "Reusable Blocks". Synced Pattern lưu 1 đoạn block markup vào DB (post type `wp_block`) — admin insert vào nhiều page → khi sửa, mọi instance update đồng thời.

**Use case Pi Dentist:**

| Synced Pattern | Hiển thị ở đâu | Sửa ở 1 chỗ → cập nhật |
|----------------|----------------|------------------------|
| `pi-cta-booking` | Cuối trang chủ + mọi trang con | Đổi heading/promo text |
| `pi-pricing-comparison` | Trang chủ + /dich-vu/ + /bang-gia/ | Đổi giá → mọi nơi cập nhật |
| `pi-contact-info` | Footer + /lien-he/ + booking section | Đổi địa chỉ |
| `pi-business-hours` | Footer + /lien-he/ + Google Map area | Đổi giờ làm việc |
| `pi-promo-banner` | Top header (nếu có) + booking CTA | Đổi text khuyến mãi |

### 9.2 Tạo Synced Pattern

**Cách 1 — Trong Admin (recommended cho admin):**
1. Mở 1 page bất kỳ → Block Editor
2. Tạo block group cần làm reusable
3. Click 3 chấm → "Create pattern" → check "Synced"
4. Đặt tên: "Pi - CTA Booking"
5. Save

**Cách 2 — Code (cho dev seed initial):**
```php
// inc/synced-patterns-seed.php — chạy 1 lần, sau đó disable
add_action( 'admin_init', function() {
    if ( get_option( 'pi_synced_seeded' ) ) return;

    wp_insert_post([
        'post_title'   => 'Pi - CTA Booking',
        'post_status'  => 'publish',
        'post_type'    => 'wp_block',
        'post_content' => '
<!-- wp:group {"className":"cta-booking pi-navy-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group cta-booking pi-navy-bg" style="background-color:#002147;color:#fff">
  <!-- wp:columns {"className":"cta-grid"} -->
  <div class="wp-block-columns cta-grid">
    <!-- wp:column {"className":"cta-form-side"} -->
    <div class="wp-block-column cta-form-side">
      <!-- wp:heading {"level":2,"textColor":"white"} -->
      <h2 class="wp-block-heading has-white-color has-text-color">Bắt đầu hành trình<br>nụ cười hoàn hảo</h2>
      <!-- /wp:heading -->
      <!-- wp:html -->
      <div class="promo-badge"><span class="promo-emoji">🎉</span> Ưu đãi khai trương: Scan 3D miễn phí + Giảm 20% phí điều trị</div>
      <!-- /wp:html -->
      <!-- wp:shortcode -->
      [fluentform id="1"]
      <!-- /wp:shortcode -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column {"className":"cta-info"} -->
    <div class="wp-block-column cta-info">
      <!-- wp:html -->
      [pi_contact_block]
      <!-- /wp:html -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
        ',
    ]);

    update_option( 'pi_synced_seeded', 1 );
});
```

### 9.3 Insert Synced Pattern vào template (PHP)

```php
// Cách 1: Dùng block_template_part (WP 6.3+)
block_template_part( 'pi-cta-booking' );

// Cách 2: Render qua post ID (mọi WP version)
$pattern = get_page_by_path( 'pi-cta-booking', OBJECT, 'wp_block' );
if ( $pattern ) {
    echo do_blocks( $pattern->post_content );
}
```

### 9.4 Bảng đối chiếu: Pattern vs Synced Pattern

| Tình huống | Dùng cái gì |
|-----------|-------------|
| Hero banner trang chủ — chỉ trang chủ dùng | **Block Pattern** (insert 1 lần, sửa độc lập) |
| Cam kết grid — có thể dùng nhiều trang nhưng nội dung có thể khác | **Block Pattern** |
| CTA Booking + Form — dùng cuối mọi trang, nội dung GIỐNG NHAU | **Synced Pattern** |
| Bảng giá — nhiều trang nhưng giá đổi đồng bộ | **Synced Pattern** |
| Footer — luôn giống nhau toàn site | `footer.php` template (không cần pattern) |

---

## 10. GENERATEPRESS HOOK SYSTEM

### 10.1 Hook system của GeneratePress là gì?

GeneratePress cung cấp **50+ action hooks** cho phép inject HTML vào các vị trí cụ thể của template KHÔNG cần override file. Đây là cách "vibe code" sạch nhất — sửa qua hook thay vì copy template về child theme.

**Lợi ích:**
- KHÔNG copy template parent về child → giảm xung đột khi update GP
- Tách biệt logic theo concern (mỗi hook 1 file)
- Dễ tìm khi debug (`grep "generate_before_header"`)

### 10.2 Bản đồ các GP Hooks Pi Dentist sẽ dùng

```
┌────────────────────────────────────────────────────────┐
│ generate_before_header           ← Promo banner        │
├────────────────────────────────────────────────────────┤
│ generate_inside_header                                 │
│  ├─ generate_logo                ← Custom logo HTML    │
│  └─ generate_inside_navigation                         │
├────────────────────────────────────────────────────────┤
│ generate_after_header            ← Page Hero (nếu cần) │
├────────────────────────────────────────────────────────┤
│ generate_before_main_content                           │
│  └─ <main>                                            │
│       <article>                                        │
│        ├─ generate_before_content                     │
│        ├─ generate_after_entry_title                  │
│        ├─ the_content()                               │
│        └─ generate_after_content                      │
│       </article>                                       │
├────────────────────────────────────────────────────────┤
│ generate_before_footer           ← CTA Booking section │
├────────────────────────────────────────────────────────┤
│ generate_inside_footer_widgets                         │
│ generate_credits                 ← © + privacy links   │
├────────────────────────────────────────────────────────┤
│ wp_footer                                              │
│  ├─ Floating CTA                                       │
│  ├─ Contact widgets (Zalo + Phone)                     │
│  └─ Back to top                                        │
└────────────────────────────────────────────────────────┘
```

### 10.3 `inc/gp-hooks.php` — Inject custom HTML

```php
<?php
/**
 * inc/gp-hooks.php — GeneratePress hook injections
 */
defined( 'ABSPATH' ) || exit;

/**
 * 1. Promo banner phía trên header (nếu Customizer bật)
 */
add_action( 'generate_before_header', function() {
    if ( ! get_theme_mod( 'pi_promo_active', false ) ) return;
    $text = get_theme_mod( 'pi_promo_text', '' );
    if ( ! $text ) return;
    ?>
    <div class="pi-promo-banner">
        <div class="container">
            <span class="promo-emoji">🎉</span>
            <span class="promo-text"><?php echo wp_kses_post( $text ); ?></span>
        </div>
    </div>
    <?php
}, 10 );

/**
 * 2. Page Hero cho mọi trang con (NOT trang chủ)
 *    — gắn ngay sau header
 */
add_action( 'generate_after_header', function() {
    if ( is_front_page() ) return;
    if ( is_404() || is_search() ) return;

    // Single CPT: dùng title + label theo CPT
    if ( is_singular( 'pi_service' ) ) {
        $label = 'DỊCH VỤ';
    } elseif ( is_singular( 'pi_doctor' ) ) {
        $label = 'BÁC SĨ';
    } elseif ( is_singular( 'pi_case' ) ) {
        $label = 'CASE ĐIỀU TRỊ';
    } elseif ( is_singular( 'post' ) ) {
        $label = 'KIẾN THỨC';
    } elseif ( is_post_type_archive( 'pi_service' ) ) {
        $label = 'DỊCH VỤ';
    } elseif ( is_post_type_archive( 'pi_doctor' ) ) {
        $label = 'BÁC SĨ';
    } elseif ( is_post_type_archive( 'pi_case' ) ) {
        $label = 'CASE ĐIỀU TRỊ';
    } elseif ( is_page() ) {
        $label = '';      // Page tự define qua content
        return;           // Không tự auto, để page tự quyết định
    } else {
        return;
    }

    $heading = is_singular() ? get_the_title() : post_type_archive_title( '', false );

    get_template_part( 'template-parts/section/page-hero', null, [
        'label'      => $label,
        'heading'    => $heading,
        'breadcrumb' => true,
    ]);
}, 10 );

/**
 * 3. CTA Booking ở cuối mọi trang (TRỪ trang chủ vì đã có sẵn,
 *    và TRỪ /lien-he/ vì trang đó là form chính)
 */
add_action( 'generate_before_footer', function() {
    if ( is_front_page() ) return;
    if ( is_page( 'lien-he' ) ) return;
    if ( is_404() ) return;

    // Render synced pattern
    $pattern = get_page_by_path( 'pi-cta-booking', OBJECT, 'wp_block' );
    if ( $pattern ) {
        echo do_blocks( $pattern->post_content );
    }
}, 10 );

/**
 * 4. Override logo HTML — dùng π symbol custom
 */
add_filter( 'generate_logo_output', function( $logo_output ) {
    return sprintf(
        '<a href="%1$s" class="logo" rel="home" aria-label="%2$s trang chủ">
            <span class="logo-symbol">π</span>
            <span class="logo-text">%2$s</span>
        </a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name' ) )
    );
});

/**
 * 5. Custom credits / footer bottom
 */
add_action( 'generate_credits', function() {
    ?>
    <div class="footer-bottom">
        <span>© <?php echo date( 'Y' ); ?> Pi Dentist. All rights reserved.</span>
        <div class="footer-legal">
            <a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">Privacy Policy</a>
            <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">Terms of Service</a>
        </div>
    </div>
    <?php
}, 10 );
```

### 10.4 `inc/floating-elements.php` — Floating CTA + Contact Widgets + Back to Top

```php
<?php
/**
 * inc/floating-elements.php
 * Hook vào wp_footer → render 3 floating elements
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', function() {
    if ( is_admin() || is_404() ) return;

    $phone = get_theme_mod( 'pi_phone', '0909000000' );
    $zalo  = get_theme_mod( 'pi_zalo_url', 'https://zalo.me/' );
    $contact_url = home_url( '/lien-he/' );
    ?>

    <!-- Floating CTA -->
    <div class="floating-cta" id="floatingCta">
        <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-gold">Đặt lịch ngay</a>
    </div>

    <!-- Contact Widgets -->
    <div class="contact-widgets" id="contactWidgets">
        <a href="<?php echo esc_url( $zalo ); ?>" class="widget-btn widget-zalo" aria-label="Chat Zalo" target="_blank" rel="noopener">Z</a>
        <a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>" class="widget-btn widget-phone" aria-label="Gọi điện">📞</a>
    </div>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" aria-label="Lên đầu trang">↑</button>

    <?php
}, 30 );
```

JS xử lý show/hide load qua `assets/js/floating.js` (đã enqueue trong `inc/enqueue.php`).

```javascript
// assets/js/floating.js
document.addEventListener('DOMContentLoaded', () => {
    const floatCta = document.getElementById('floatingCta');
    const widgets  = document.getElementById('contactWidgets');
    const backTop  = document.getElementById('backToTop');
    const hero     = document.getElementById('siteHeader');
    const trigger  = hero ? hero.offsetHeight + 200 : 800;

    function update() {
        const y = window.scrollY;
        floatCta?.classList.toggle('show', y > trigger);
        widgets?.classList.toggle('show',  y > trigger);
        backTop?.classList.toggle('show',  y > 500);
    }
    window.addEventListener('scroll', update, { passive: true });
    update();

    backTop?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
```

### 10.5 `inc/menus.php` — Custom Walker cho dropdown

GeneratePress mặc định không output đúng format dropdown của Pi (xem index.html dòng 2155–2185). Custom Walker:

```php
<?php
defined( 'ABSPATH' ) || exit;

// Register menu locations
add_action( 'after_setup_theme', function() {
    register_nav_menus( [
        'primary' => 'Menu chính (header)',
        'mobile'  => 'Menu mobile',
        'footer-services' => 'Footer - Dịch vụ',
        'footer-info'     => 'Footer - Thông tin',
    ] );
});

// Custom Walker — output đúng class + chevron cho parent có submenu
class Pi_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "\n<div class=\"dropdown\" role=\"menu\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "</div>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $has_children = in_array( 'menu-item-has-children', $item->classes );
        $url   = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
        $title = esc_html( $item->title );

        if ( $depth === 0 ) {
            $output .= sprintf( '<div class="nav-item">' );
            $chevron = $has_children ? ' <span class="chevron">▼</span>' : '';
            $output .= sprintf( '<a href="%s" class="nav-link">%s%s</a>', $url, $title, $chevron );
        } else {
            $output .= sprintf( '<a href="%s" class="dropdown-item" role="menuitem">%s</a>', $url, $title );
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= "</div>\n";
        }
    }
}
```

### 10.6 Tổng hợp các Hook đã dùng

| Hook | Vị trí | Pi inject |
|------|--------|-----------|
| `after_setup_theme` | Init theme | Theme supports, color palette, editor styles |
| `init` | WP boot | Register CPT, Taxonomy, Pattern Categories, Block Patterns |
| `customize_register` | Customizer load | Register settings & controls |
| `wp_enqueue_scripts` | Frontend load | Enqueue CSS/JS |
| `add_meta_boxes` | Edit screen | Custom meta boxes cho CPT |
| `save_post_pi_service` | Save service | Lưu meta fields |
| `generate_before_header` | GP top | Promo banner |
| `generate_after_header` | Sau header | Page Hero |
| `generate_before_footer` | Trước footer | CTA Booking synced pattern |
| `generate_credits` | Footer bottom | © + legal links |
| `generate_logo_output` (filter) | Logo HTML | π symbol custom |
| `wp_footer` | Trước `</body>` | Floating elements |
| `script_loader_tag` (filter) | Script tag | Add `defer` |

---

## 11. PLUGIN STACK CHI TIẾT

### 11.1 Danh sách plugin chính thức (KHÔNG cài thêm)

| Plugin | Phiên bản tối thiểu | Bản | Mục đích | Active mọi trang? |
|--------|---------------------|-----|----------|-------------------|
| **Custom Post Type UI** | 1.16+ | Free | Quản lý CPT/Taxonomy GUI (backup nếu code lỗi) | Có |
| **Rank Math SEO** | 1.0.220+ | Free | SEO toàn diện | Có |
| **Fluent Forms** | 5.0+ | Free | Booking form | Chỉ load page có form |
| **WP Rocket** HOẶC **LiteSpeed Cache** | latest | Paid hoặc Free | Page cache, minify | Có |
| **Wordfence Security** | 7.x | Free | Firewall, malware scan | Có |
| **UpdraftPlus** | 1.x | Free | Backup → Google Drive | Backend chỉ |

**Tổng: 6 plugins.** Đây là điểm "minimalist" — KHÔNG cài Yoast (đã có RM), KHÔNG cài Elementor (đã có Block Editor), KHÔNG cài WPForms (đã có Fluent), KHÔNG cài bloat plugins.

### 11.2 Quyết định: Custom Post Type UI vs Code

**Câu hỏi:** Đã code `register_post_type()` trong `inc/cpt.php` rồi, có cần CPT UI nữa không?

**Trả lời:** Có lý do để cài CPT UI làm "fallback admin tool":

| Tình huống | Ai handle |
|-----------|-----------|
| Tạo CPT mới (vd: `pi_branch` chi nhánh) khi cần khẩn | CPT UI — admin click GUI |
| Sửa labels, slug nhỏ | CPT UI |
| Code chính thức CPT trong git | `inc/cpt.php` |

→ V1.0: tất cả 3 CPT chính (`pi_service`, `pi_doctor`, `pi_case`) **code trong `inc/cpt.php`**. CPT UI cài để dự phòng + cho admin nghịch khi muốn thêm tạm.

→ Nếu CPT đã code rồi mà CPT UI thấy nó "Registered Externally" — đó là behavior đúng.

### 11.3 Bảng quyết định: Plugin vs Code

| Chức năng | Plugin | Code custom | Quyết định |
|-----------|--------|-------------|------------|
| CPT registration | CPT UI | `register_post_type` | **Code** (v1.0) |
| Custom fields | ACF | `register_post_meta` + meta box | **Code** (giảm bloat) |
| Form contact | Fluent Forms | Custom form + email | **Plugin** (anti-spam, lưu DB, validation chuẩn) |
| SEO meta | Rank Math / Yoast | Code metadata + JSON-LD | **Plugin** (giải pháp toàn diện) |
| Cache | WP Rocket / LSCache | Custom transients | **Plugin** (page cache phức tạp) |
| Security | Wordfence | Self-coded | **Plugin** (firewall rules cập nhật) |
| Backup | UpdraftPlus | mysqldump cron | **Plugin** (1-click restore) |
| Image optimization | ShortPixel / Imagify | Manual | **WP Rocket built-in lazy** + ko optimize riêng v1.0 |

### 11.4 Plugin auto-update strategy

```php
// Bật auto-update cho 6 plugin chính, tắt cho mọi plugin khác
add_filter( 'auto_update_plugin', function( $update, $item ) {
    $allowed = [
        'rank-math/rank-math.php',
        'fluentform/fluentform.php',
        'wordfence/wordfence.php',
        'updraftplus/updraftplus.php',
        'custom-post-type-ui/custom-post-type-ui.php',
        // KHÔNG bật auto-update cho cache plugin (có thể break site)
    ];
    return in_array( $item->plugin, $allowed, true );
}, 10, 2 );

// WP core minor — auto-update on
add_filter( 'allow_minor_auto_core_updates', '__return_true' );
add_filter( 'allow_major_auto_core_updates', '__return_false' );
```

---

## 12. SEO CONFIG VỚI RANK MATH

### 12.1 Setup Wizard sau khi cài

Sau khi activate Rank Math, hoàn thành Setup Wizard với các options sau:

| Bước | Cấu hình |
|------|----------|
| **Compatibility** | Skip (không có Yoast/AIOSEO) |
| **Your Site** | Personal blog → đổi thành **"Local Business"** |
| **Business Type** | Dentist |
| **Site Type** | Business website |
| **Logo** | Upload logo Pi Dentist |
| **Default Social Share Image** | Upload ảnh OG 1200×630 |
| **Connect Google** | Bỏ qua v1.0, làm sau khi go-live |
| **Sitemaps** | ✅ All on (Posts, Pages, pi_service, pi_doctor, pi_case, Categories, Tags) |
| **Image SEO** | ✅ Auto-add alt text from filename |
| **Noindex** | Tags = noindex, Author archives = noindex |

### 12.2 Schema Markup config

#### 12.2.1 Site-wide: LocalBusiness / Dentist Schema

`Rank Math → Titles & Meta → Local SEO`:

```yaml
Business Name: Pi Dentist
Type: Dentist
URL: https://pidentist.vn
Phone: [Customizer pi_phone]
Email: info@pidentist.vn
Address:
  Street: 123 Đường ABC
  City: Hồ Chí Minh
  Region: Hồ Chí Minh
  Postal Code: 700000
  Country: VN
Geo:
  Latitude: 10.7769
  Longitude: 106.7009
Opening Hours:
  Monday-Friday: 08:00-20:00
  Saturday: 08:00-17:00
  Sunday: Closed
Price Range: $$$
Image: [Logo Pi]
Social Profiles: [Customizer values]
```

#### 12.2.2 Per-CPT Schema

| CPT | Schema Type | Cấu hình ở |
|-----|-------------|------------|
| `pi_service` | `Service` + `Offer` (price) | Rank Math → Titles & Meta → Post Type: Service |
| `pi_doctor` | `Person` + `Physician` | Rank Math → Titles & Meta → Post Type: Doctor |
| `pi_case` | `MedicalProcedure` + `Article` | Rank Math → Titles & Meta → Post Type: Case |
| `post` (blog) | `Article` (default) + `BlogPosting` | Default |
| `page` | `WebPage` (default) | Default |

**Code bổ sung schema cho `pi_service`** (Rank Math không tự generate price → bổ sung):

```php
// inc/rank-math-defaults.php
add_filter( 'rank_math/snippet/rich_snippet_service_entity', function( $entity, $jsonld ) {
    if ( ! is_singular( 'pi_service' ) ) return $entity;

    $price = get_post_meta( get_the_ID(), '_pi_service_price_from', true );
    if ( $price ) {
        $entity['offers'] = [
            '@type'         => 'Offer',
            'priceCurrency' => 'VND',
            'price'         => $price * 1000000,
            'availability'  => 'https://schema.org/InStock',
        ];
    }
    $entity['provider'] = [
        '@type' => 'Dentist',
        'name'  => get_bloginfo( 'name' ),
        'url'   => home_url( '/' ),
    ];
    return $entity;
}, 10, 2 );
```

### 12.3 Title & Meta templates

`Rank Math → Titles & Meta`:

| Object | Title | Meta Description |
|--------|-------|------------------|
| Homepage | `%sitename% - %sitedesc%` | `Pi Dentist — Nha khoa chuyên sâu chỉnh nha. Bác sĩ đào tạo quốc tế, công nghệ số 100%, theo dõi trọn đời.` |
| Page | `%title% - %sitename%` | Auto từ excerpt |
| Post (Blog) | `%title% - %sitename%` | Auto từ excerpt |
| `pi_service` | `%title% - Dịch vụ chỉnh nha tại Pi Dentist` | `%excerpt%` |
| `pi_doctor` | `%title% - Bác sĩ chỉnh nha tại Pi Dentist` | `%excerpt%` |
| `pi_case` | `Case %title% - Pi Dentist` | `%excerpt%` |
| Archive `pi_service` | `Dịch vụ chỉnh nha - Pi Dentist` | `Khám phá 4 phương pháp chỉnh nha hiện đại tại Pi Dentist...` |
| Search | `Tìm kiếm "%search%" - %sitename%` | — (noindex) |

### 12.4 Sitemap config

`Rank Math → Sitemap Settings`:

```yaml
General:
  Links per Sitemap: 200
  Images in Sitemap: ✅ Include
  Exclude Posts: (none)
  Exclude Terms: (none)

Sitemaps to include:
  ✅ Posts
  ✅ Pages
  ✅ pi_service
  ✅ pi_doctor
  ✅ pi_case
  ✅ Categories
  ✅ pi_service_category
  ❌ Tags (noindex anyway)
  ❌ Authors (noindex)
```

URL kết quả:
- `https://pidentist.vn/sitemap_index.xml` (master)
- `https://pidentist.vn/post-sitemap.xml`
- `https://pidentist.vn/page-sitemap.xml`
- `https://pidentist.vn/pi_service-sitemap.xml`
- `https://pidentist.vn/pi_doctor-sitemap.xml`
- `https://pidentist.vn/pi_case-sitemap.xml`

### 12.5 Breadcrumbs

`Rank Math → General Settings → Breadcrumbs`:
- ✅ Enable
- Separator: `›`
- Home label: `Trang chủ`
- Hide Post Title in Breadcrumb: ❌
- Show Category in Post: ✅

Render trong template:
```php
<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
    rank_math_the_breadcrumbs();
} ?>
```

Hoặc auto inject qua Page Hero template part:
```php
// template-parts/section/page-hero.php
<nav class="breadcrumb" aria-label="Breadcrumb">
    <?php rank_math_the_breadcrumbs(); ?>
</nav>
```

### 12.6 robots.txt

WP virtual robots.txt (không cần file vật lý):

```php
add_filter( 'robots_txt', function( $output, $public ) {
    if ( '0' === $public ) return $output;

    $custom = "User-agent: *\n";
    $custom .= "Disallow: /wp-admin/\n";
    $custom .= "Disallow: /wp-login.php\n";
    $custom .= "Disallow: /pi-login\n";
    $custom .= "Disallow: /?s=\n";
    $custom .= "Disallow: /search/\n";
    $custom .= "Allow: /wp-admin/admin-ajax.php\n";
    $custom .= "\nSitemap: " . home_url( '/sitemap_index.xml' ) . "\n";

    return $custom;
}, 10, 2 );
```

### 12.7 Open Graph & Twitter Cards

Rank Math tự handle. Per-page override qua meta box:
- `Edit page → Rank Math → Social → Facebook/Twitter` → upload ảnh riêng

**Default OG image:** Upload 1 ảnh 1200×630 chứa logo Pi + tagline tại `Rank Math → Titles & Meta → Social Meta`.

### 12.8 SEO checklist cho từng trang

Mỗi khi admin tạo bài viết / dịch vụ / bác sĩ mới, checklist:

- [ ] Focus keyword set (RM box)
- [ ] Title length 50-60 ký tự
- [ ] Meta description 150-160 ký tự, có keyword
- [ ] URL slug ngắn, không dấu, có keyword
- [ ] Featured image set (16:9, ≥1200×675)
- [ ] Featured image alt text
- [ ] H1 chỉ có 1, có keyword
- [ ] Internal links ≥2 (link sang dịch vụ/bài viết khác)
- [ ] External links ≥1 (link sang nguồn uy tín, target=_blank)
- [ ] RM SEO Score ≥80

---

## 13. FORM CONFIG VỚI FLUENT FORMS

### 13.1 Tạo Form "Đặt lịch tư vấn"

`Fluent Forms → New Form → Blank Form`

**Fields:**

| Field | Type | Required | Validation |
|-------|------|----------|-----------|
| `fullName` | Text | ✅ | min 2, max 50 |
| `phone` | Phone | ✅ | regex `/^(0|\+84)[0-9]{9,10}$/` |
| `email` | Email | — | valid email format |
| `service` | Dropdown | ✅ | Options: Mắc cài kim loại / Mắc cài sứ / Niềng trong suốt / Niềng mặt trong / Chưa biết |
| `preferredDate` | Date Picker | — | min today |
| `preferredTime` | Radio | — | Sáng / Chiều / Tối |
| `message` | Textarea | — | max 500 |
| Hidden `source` | Hidden | — | default `website` (đổi qua URL params) |
| Hidden `_referer` | Hidden | — | auto $_SERVER[HTTP_REFERER] |
| reCAPTCHA v3 | reCAPTCHA | ✅ | (cài sau go-live) |

### 13.2 Submit Settings

`Form Settings → Confirmation`:

```
Type: Show Message
Message: 
  ✓ Cảm ơn bạn đã đặt lịch! 
  Đội ngũ Pi Dentist sẽ liên hệ trong vòng 30 phút.
  Hotline: 0909 XXX XXX
Redirect after: (off, không redirect)
```

### 13.3 Notifications (Email)

`Form Settings → Notifications → Add New`:

**Notification 1: Email cho admin (sales team)**
```
To: sales@pidentist.vn, manager@pidentist.vn
Subject: [BOOKING] {inputs.fullName} - {inputs.service}
Email Body:
  Khách hàng vừa đặt lịch:
  - Họ tên: {inputs.fullName}
  - SĐT:    {inputs.phone}
  - Email:  {inputs.email}
  - Dịch vụ: {inputs.service}
  - Ngày mong muốn: {inputs.preferredDate}
  - Giờ:    {inputs.preferredTime}
  - Ghi chú: {inputs.message}
  
  Nguồn: {inputs.source}
  Trang: {inputs._referer}
  IP: {ip}
  Thời gian: {submission_date}
```

**Notification 2: Email auto-reply cho khách**
```
To: {inputs.email}
Subject: Cảm ơn bạn đã đặt lịch tại Pi Dentist
Email Body: (HTML — branded)
  [Logo]
  Xin chào {inputs.fullName},
  
  Chúng tôi đã nhận được yêu cầu đặt lịch tư vấn cho dịch vụ "{inputs.service}".
  Đội ngũ Pi Dentist sẽ liên hệ với bạn qua số {inputs.phone} trong vòng 30 phút...
```

### 13.4 Anti-spam config

```
Form Settings → Validations:
✅ Honeypot
✅ reCAPTCHA v3 (sau go-live, key từ Google)
✅ Akismet (nếu cài)
✅ Block IP after 5 failed submissions
✅ Submission throttling: 1 per IP / 5 minutes
```

### 13.5 Embed form

**Cách 1 — Shortcode trong Block:**
```
[fluentform id="1"]
```

**Cách 2 — Custom block (Fluent Forms ship sẵn):**
Block Editor → Add Block → tìm "Fluent Form" → chọn form

**Cách 3 — Trong template PHP:**
```php
echo do_shortcode( '[fluentform id="1"]' );
```

### 13.6 Lưu submissions vào CRM (optional v2)

Fluent Forms có built-in integrations:
- Google Sheets (sync auto)
- Slack (notification)
- Zapier
- HubSpot CRM
- Mailchimp (newsletter)

→ V1.0 chỉ dùng email + lưu DB. V2.0 sync Google Sheets cho team sales theo dõi.

---

## 14. PERFORMANCE & CACHE

### 14.1 Mục tiêu hiệu năng

| Chỉ số | Mục tiêu | Công cụ đo |
|--------|----------|------------|
| LCP (Largest Contentful Paint) | < 2.5s | PageSpeed Insights |
| FID / INP | < 100ms | Web Vitals |
| CLS | < 0.1 | PageSpeed Insights |
| TTFB | < 600ms | WebPageTest |
| Lighthouse Performance | ≥ 90 | Lighthouse |
| Lighthouse SEO | 100 | Lighthouse |
| Lighthouse Accessibility | ≥ 95 | Lighthouse |
| Page weight (homepage) | < 1.5 MB | Network tab |
| Total requests (homepage) | < 60 | Network tab |

**Triết lý:** Trang web nha khoa chủ yếu là khách mobile tìm kiếm — nếu load > 3s, 53% khách rời đi (Google data). Pi Dentist muốn cảm giác "premium phải đi đôi với mượt". Tốc độ là phần của brand.

### 14.2 Kiến trúc cache nhiều lớp

```
                        ┌──────────────┐
   Visitor (Browser)    │ Browser Cache│  ← Cache-Control headers
                        └──────┬───────┘
                               │
                        ┌──────▼───────┐
                        │  Cloudflare  │  ← Edge cache (HTML, CSS, JS, images)
                        │     CDN      │     TTL theo URL pattern
                        └──────┬───────┘
                               │
                        ┌──────▼───────┐
                        │    Nginx     │  ← FastCGI cache (HTML rendered)
                        │ (reverse px) │
                        └──────┬───────┘
                               │
                        ┌──────▼───────┐
                        │  WP Rocket   │  ← Page cache (HTML files trên disk)
                        │ (Page Cache) │
                        └──────┬───────┘
                               │
                        ┌──────▼───────┐
                        │     Redis    │  ← Object cache (DB queries, options)
                        │ Object Cache │
                        └──────┬───────┘
                               │
                        ┌──────▼───────┐
                        │  PHP OPcache │  ← Bytecode cache (PHP compiled)
                        └──────┬───────┘
                               │
                        ┌──────▼───────┐
                        │   MariaDB    │
                        │ (Query Cache)│
                        └──────────────┘
```

**Nguyên tắc:** Mỗi lớp xử lý một loại payload khác nhau. Khi user request `/dich-vu/`:
1. Cloudflare check edge cache → nếu có, trả về luôn (0ms server load).
2. Nếu Cloudflare miss → Nginx FastCGI cache check.
3. Nếu Nginx miss → PHP-FPM chạy WP, WP Rocket check page cache file.
4. Nếu WP Rocket miss → WP query DB, Redis cache object.
5. PHP OPcache giảm thời gian compile PHP mỗi request.

### 14.3 Chọn plugin cache: WP Rocket vs LiteSpeed Cache

| Tiêu chí | WP Rocket | LiteSpeed Cache | Quyết định |
|----------|-----------|-----------------|------------|
| Giá | $59/năm/site | Miễn phí | LiteSpeed thắng nếu budget thấp |
| Yêu cầu server | Bất kỳ (Apache/Nginx) | LiteSpeed Web Server hoặc OpenLiteSpeed | WP Rocket linh hoạt hơn |
| Cấu hình | Plug-and-play, ít option | Nhiều option, dễ overwhelm | WP Rocket dễ hơn cho người vibe code |
| Image optimization | Imagify (riêng) | QUIC.cloud built-in | LiteSpeed gói gọn hơn |
| CDN | Tích hợp CDN bất kỳ | QUIC.cloud CDN có sẵn | Tương đương |
| Critical CSS | Auto-generate | Auto-generate | Tương đương |

**[DECISION]** → V1.0 dùng **LiteSpeed Cache (free)** vì:
1. Miễn phí hoàn toàn.
2. Pi Dentist chạy trên VPS Nginx → không cần LiteSpeed Web Server, chỉ dùng plugin caching ở mức page cache + image optimization + critical CSS.
3. Nếu không hài lòng → upgrade WP Rocket sau, cấu hình tương tự.

> Nếu chọn server LiteSpeed/OpenLiteSpeed thay Nginx, plugin sẽ tự động dùng server-level cache (nhanh hơn). Quyết định: V1.0 vẫn dùng Nginx, V1.5 cân nhắc OpenLiteSpeed nếu cần.

### 14.4 LiteSpeed Cache config (free)

**Sau khi cài plugin → LiteSpeed Cache → Settings:**

#### 14.4.1 Cache tab

```
General:
✅ Enable Cache: ON
✅ Auto Purge Rules for Publish/Update: ON
✅ Serve Stale: ON (serve cache cũ trong khi rebuild)

TTL:
- Default Public Cache TTL: 604800 (7 ngày)
- Default Private Cache TTL: 1800 (30 phút)
- Default Front Page TTL: 604800
- Default Feed TTL: 604800
- Default 404 Page TTL: 3600 (1 giờ)
- Default 403 Page TTL: 3600
- Default 500 Page TTL: 3600

Purge:
✅ Purge All On Upgrade: ON
Auto Purge Rules:
  ✅ All pages
  ✅ Front page
  ✅ Home page
  ✅ Pages
  ✅ Author archive
  ✅ Post type archive (pi_service, pi_doctor, pi_case)
  ✅ Yearly archive
  ✅ Monthly archive
  ✅ Term archive (pi_service_category)

Excludes:
- Do Not Cache URIs:
  /dat-lich/
  /tai-khoan/  (nếu có v2)
  /gio-hang/   (nếu có v2)
  /thanh-toan/ (nếu có v2)

- Do Not Cache Query Strings:
  utm_source
  utm_medium
  utm_campaign
  fbclid
  gclid
  (Nhưng cache theo URL-only, ignore các tracking params)

- Do Not Cache Cookies:
  wp-postpass
  wordpress_logged_in_*

ESI (Edge Side Includes):
✅ Enable ESI: OFF (v1.0, bật khi cần personalization)

Object:
✅ Object Cache: ON
- Method: Redis
- Host: 127.0.0.1
- Port: 6379
- Default Object Lifetime: 360 (6 phút)
- Username/Password: (theo Redis config)
- Redis Database ID: 0
- Global Groups:
  users
  userlogins
  usermeta
  user_meta
  site-transient
  site-options
  site-lookup
  blog-lookup
  blog-details
  rss
  global-posts
  blog-id-cache
- Do Not Cache Groups:
  comment
  counts
  plugins

Browser:
✅ Browser Cache: ON
- Browser Cache TTL: 31557600 (1 năm cho assets)
```

#### 14.4.2 CDN tab

```
✅ QUIC.cloud CDN: OFF (v1.0 dùng Cloudflare riêng)
✅ Use CDN Mapping: ON nếu dùng Cloudflare Pro hoặc CDN khác
- CDN URL: https://cdn.pidentist.vn (sau khi setup Cloudflare R2 hoặc DigitalOcean Spaces)
- Include Files: images, css, js
- Exclude Files: .php, .html
```

> V1.0 không dùng CDN custom, chỉ proxy qua Cloudflare DNS. CDN R2/Spaces là v1.5 nếu traffic > 50K/tháng.

#### 14.4.3 Image Optimization tab

```
✅ Auto Request Cron: ON
✅ Auto Pull Cron: ON
✅ Optimize Original Images: ON
✅ Remove Original Backups: OFF (giữ backup phòng cần)
✅ Optimize Losslessly: ON (giữ chất lượng cao)
✅ Preserve EXIF/XMP data: OFF
✅ Create WebP Versions: ON
✅ Image WebP Replacement: ON
✅ WebP Attribute To Replace:
  src
  data-src
  srcset
  data-srcset
  data-lazy-src
  data-lazy-srcset
  poster
✅ WebP For Extra srcset: ON
✅ WordPress Image Quality Control: 82 (sweet spot chất lượng/dung lượng)
```

> **Lưu ý:** Image optimization chạy qua QUIC.cloud (free tier 5,000 ảnh/tháng). Pi Dentist v1.0 dự kiến < 200 ảnh → đủ free tier.

#### 14.4.4 Page Optimization tab

```
CSS Settings:
✅ CSS Minify: ON
✅ CSS Combine: ON (cẩn thận, test kỹ với GeneratePress)
✅ Generate UCSS: ON (Unique CSS — chỉ giữ CSS thực sự dùng)
✅ UCSS Inline: ON
✅ CSS Combine External and Inline: ON
✅ Load CSS Asynchronously: ON
✅ CCSS Per URL: ON (Critical CSS riêng cho từng URL)
✅ Inline CSS Async Lib: ON
✅ Font Display Optimization: swap

JS Settings:
✅ JS Minify: ON
✅ JS Combine: ON (test kỹ, có thể bật từng phần)
✅ JS Combine External and Inline: ON
✅ Load JS Deferred: ON
✅ Load Inline JS: After DOM Ready

HTML Settings:
✅ HTML Minify: ON
✅ DNS Prefetch:
  //fonts.googleapis.com
  //fonts.gstatic.com
  //www.google-analytics.com
  //connect.facebook.net
✅ DNS Preconnect:
  https://fonts.gstatic.com
✅ HTML Lazy Load Selectors: (custom nếu cần)
✅ Remove Query Strings: ON
✅ Remove WordPress Emoji: ON
✅ Remove Noscript Tags: OFF

Media Settings:
✅ Lazy Load Images: ON
✅ Basic Image Placeholder: data:image/gif;base64,R0lG... (1x1 transparent)
✅ Responsive Placeholder: ON
✅ LQIP Cloud Generator: OFF (v1.0)
✅ LQIP Quality: 4
✅ LQIP Minimum Dimensions: 150x150
✅ Generate LQIP In Background: ON
✅ Lazy Load Iframes: ON (cho Google Maps, YouTube embed)
✅ Add Missing Sizes: ON
✅ VPI (Viewport Images): ON (preload ảnh trong viewport đầu)
✅ VPI Cron: ON

Localization:
✅ Gravatar Cache: ON
✅ Localize Resources: ON
- Localize Files:
  https://www.googletagmanager.com/gtag/js
  https://www.google-analytics.com/analytics.js
  (giảm request bên thứ 3, host local)
```

#### 14.4.5 Database tab

```
Database Optimizer (chạy thủ công qua nút):
- Clean Revisions (giữ tối đa 3 revisions/post)
- Clean Auto Drafts
- Clean Trashed Posts
- Clean Spam Comments
- Clean Trashed Comments
- Clean Trackbacks/Pingbacks
- Clean Expired Transients
- Clean All Transients
- Optimize All Tables

Cron schedule:
✅ Auto-clean revisions: weekly
✅ Auto-clean transients: daily
✅ Auto-optimize tables: weekly
```

### 14.5 Nginx FastCGI cache (server-level)

**Mục đích:** Cache HTML đã render ở mức Nginx — nhanh hơn WP Rocket vì không qua PHP. Áp dụng cho khách chưa login.

**File: `/etc/nginx/conf.d/fastcgi-cache.conf`**

```nginx
fastcgi_cache_path /var/cache/nginx/pidentist 
    levels=1:2 
    keys_zone=PIDENTIST_CACHE:100m 
    max_size=1g 
    inactive=60m 
    use_temp_path=off;

fastcgi_cache_key "$scheme$request_method$host$request_uri";
fastcgi_cache_use_stale error timeout invalid_header updating http_500 http_503;
fastcgi_cache_lock on;
fastcgi_cache_valid 200 301 302 60m;
fastcgi_cache_valid 404 1m;
```

**File: `/etc/nginx/sites-available/pidentist.vn`** (trích đoạn)

```nginx
server {
    listen 443 ssl http2;
    server_name pidentist.vn www.pidentist.vn;
    root /var/www/pidentist.vn/public;
    index index.php;

    # SSL configs ...
    
    # Skip cache rules
    set $skip_cache 0;
    
    # Skip cache cho POST requests
    if ($request_method = POST) { set $skip_cache 1; }
    
    # Skip cache cho query string
    if ($query_string != "") { set $skip_cache 1; }
    
    # Skip cache cho user logged in / WP admin
    if ($http_cookie ~* "comment_author|wordpress_[a-f0-9]+|wp-postpass|wordpress_logged_in") {
        set $skip_cache 1;
    }
    
    # Skip cache cho admin URLs
    if ($request_uri ~* "/wp-admin/|/xmlrpc.php|wp-.*.php|/feed/|index.php|sitemap(_index)?.xml") {
        set $skip_cache 1;
    }
    
    # Skip cache cho /dat-lich/
    if ($request_uri ~* "^/(dat-lich)") {
        set $skip_cache 1;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        
        # FastCGI cache
        fastcgi_cache_bypass $skip_cache;
        fastcgi_no_cache $skip_cache;
        fastcgi_cache PIDENTIST_CACHE;
        fastcgi_cache_valid 60m;
        
        add_header X-FastCGI-Cache $upstream_cache_status;
    }
    
    # Purge endpoint (gọi từ WP via Nginx Helper plugin)
    location ~ /purge(/.*) {
        fastcgi_cache_purge PIDENTIST_CACHE "$scheme$request_method$host$1";
        access_log off;
    }
}
```

**Plugin bổ trợ:** [Nginx Helper](https://wordpress.org/plugins/nginx-helper/) — auto purge Nginx cache khi update post/page.

```
Nginx Helper Settings:
✅ Caching Method: nginx fastcgi cache
✅ Purge Method: Delete local server cache files
- Cache Path: /var/cache/nginx/pidentist
✅ Purge Conditions:
  Purge homepage on edit/comment
  Purge post/page on edit/comment
  Purge archives on edit/comment
```

### 14.6 PHP OPcache config

**File: `/etc/php/8.2/fpm/conf.d/10-opcache.ini`**

```ini
[opcache]
opcache.enable=1
opcache.enable_cli=0
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
opcache.validate_timestamps=1
opcache.save_comments=1
opcache.jit=1255
opcache.jit_buffer_size=128M
```

> **JIT (Just-In-Time):** Bật từ PHP 8.0+. Tăng tốc 5-15% cho code-heavy operations. Đảm bảo PHP 8.2 trên VPS.

### 14.7 Redis Object Cache

**File: `/etc/redis/redis.conf`** (highlights)

```
maxmemory 256mb
maxmemory-policy allkeys-lru
appendonly no
save ""
tcp-keepalive 60
timeout 300
```

**Plugin:** [Redis Object Cache](https://wordpress.org/plugins/redis-cache/) — UI dễ hơn LiteSpeed Cache built-in.

```
WP Admin → Settings → Redis:
✅ Status: Connected
✅ Drop-in: Installed (object-cache.php)
- Hostname: 127.0.0.1
- Port: 6379
- Database: 0
- Cache Key Salt: pidentist_ (tránh xung đột nếu nhiều site dùng chung Redis)
```

> **[DECISION]** Dùng Redis Object Cache plugin thay vì built-in của LiteSpeed → UI rõ ràng, drop-in chuẩn, dễ debug.

### 14.8 Cloudflare config

#### 14.8.1 DNS

```
Type    Name        Content                 Proxy   TTL
A       @           <VPS_IP>                Yes     Auto
A       www         <VPS_IP>                Yes     Auto
CNAME   cdn         pidentist.vn            Yes     Auto (v1.5)
TXT     @           "v=spf1 include:..."    DNS only Auto (email)
```

#### 14.8.2 SSL/TLS

```
SSL/TLS Mode: Full (strict)
- Edge Certificates: Always Use HTTPS ON
- HSTS: Enable (max-age=31536000, includeSubDomains, preload sau 1 tháng)
- Minimum TLS Version: 1.2
- TLS 1.3: Enable
- Automatic HTTPS Rewrites: ON
```

#### 14.8.3 Speed

```
Auto Minify: 
  ❌ JS (LiteSpeed đã làm)
  ❌ CSS (LiteSpeed đã làm)
  ✅ HTML (cho phép Cloudflare làm)
Brotli: ON
Rocket Loader: OFF (xung đột với LiteSpeed JS combine)
Early Hints: ON
```

#### 14.8.4 Caching

```
Caching Level: Standard
Browser Cache TTL: 1 year
Always Online: ON
Development Mode: OFF (chỉ bật khi debug)
```

#### 14.8.5 Page Rules (free plan có 3 rule)

```
Rule 1: pidentist.vn/wp-admin/*
  - Cache Level: Bypass
  - Disable Performance
  - Security Level: High

Rule 2: pidentist.vn/wp-login.php
  - Cache Level: Bypass
  - Security Level: I'm Under Attack (chống brute force)

Rule 3: pidentist.vn/*
  - Cache Level: Cache Everything
  - Edge Cache TTL: 1 month
  - Browser Cache TTL: 4 hours
```

> **Lưu ý "Cache Everything":** Cloudflare sẽ cache cả HTML. Nguy cơ cache nhầm session user. Cần combine với Bypass Cache on Cookie:
> - Worker hoặc Cache Rules: Bypass nếu cookie chứa `wordpress_logged_in_*` hoặc `wp-postpass`

#### 14.8.6 Firewall Rules (free plan có 5 rule)

```
Rule 1: Block bad bots
  Expression: (cf.client.bot) and not (http.user_agent contains "Googlebot" or http.user_agent contains "Bingbot")
  Action: Block

Rule 2: Challenge wp-login.php
  Expression: (http.request.uri.path eq "/wp-login.php")
  Action: Managed Challenge

Rule 3: Block xmlrpc.php
  Expression: (http.request.uri.path contains "/xmlrpc.php")
  Action: Block

Rule 4: Rate limit /wp-admin
  Expression: (http.request.uri.path contains "/wp-admin")
  Action: Managed Challenge nếu > 30 req/min

Rule 5: Block country (nếu cần)
  Expression: (ip.geoip.country in {"CN" "RU" "KP"})
  Action: Block (cẩn thận, có thể block khách thật)
```

### 14.9 Asset optimization checklist

```
✅ Images:
  - WebP cho mọi ảnh (LiteSpeed tự convert)
  - Lazy load images dưới fold (LiteSpeed)
  - Preload hero image (manual: <link rel="preload" as="image" ...>)
  - Responsive srcset (WP tự sinh, đảm bảo theme.json có sizes đúng)
  - Compress < 200KB cho ảnh thường, < 500KB cho hero

✅ Fonts:
  - Self-host Playfair Display + Inter (download từ Google Fonts)
  - font-display: swap (fallback Times/Arial trong khi load)
  - Preload font chính: <link rel="preload" as="font" type="font/woff2" crossorigin>
  - Subset: chỉ load weights dùng (400, 600, 700) không load full

✅ CSS:
  - Critical CSS inline trong <head> (LiteSpeed UCSS)
  - CSS combine + minify (LiteSpeed)
  - Async load non-critical CSS

✅ JS:
  - Defer non-critical JS (LiteSpeed)
  - Combine JS có chọn lọc
  - Tránh inline script lớn
  - Async cho GA4, FB Pixel

✅ HTML:
  - Minify HTML (LiteSpeed/Cloudflare)
  - Loại emoji scripts (LiteSpeed)
  - Loại oEmbed nếu không dùng
  - Loại RSS feed nếu không cần (header > rsd_link, wlwmanifest_link)
```

### 14.10 Self-host Google Fonts

**[DECISION]** Self-host fonts thay vì gọi qua `fonts.googleapis.com`:

1. **GDPR-friendly:** Không gửi IP user sang Google.
2. **Tránh extra DNS lookup:** Giảm 50-100ms TTFB cho font.
3. **Kiểm soát caching:** Đặt `max-age=31536000` cho woff2.

**Quy trình:**

```bash
# 1. Tải Playfair Display + Inter từ Google Webfonts Helper
# https://gwfh.mranftl.com/fonts

# 2. Copy vào child theme
wp-content/themes/pidentist/assets/fonts/
├── playfair-display-v37-latin-vietnamese-regular.woff2
├── playfair-display-v37-latin-vietnamese-700.woff2
├── inter-v18-latin-vietnamese-regular.woff2
├── inter-v18-latin-vietnamese-500.woff2
├── inter-v18-latin-vietnamese-600.woff2
└── inter-v18-latin-vietnamese-700.woff2
```

**Trong `assets/css/main.css`:**

```css
/* Inter — sans-serif */
@font-face {
  font-family: 'Inter';
  font-style: normal;
  font-weight: 400 700;  /* variable range */
  font-display: swap;
  src: url('../fonts/inter-v18-latin-vietnamese-regular.woff2') format('woff2');
  unicode-range: U+0000-024F, U+0259, U+1E00-1EFF, U+2000-206F, U+2074, U+20AB, U+20AD, U+20B0, U+20B1-20BB;
}

/* Playfair Display — serif */
@font-face {
  font-family: 'Playfair Display';
  font-style: normal;
  font-weight: 400 700;
  font-display: swap;
  src: url('../fonts/playfair-display-v37-latin-vietnamese-regular.woff2') format('woff2');
  unicode-range: U+0000-024F, U+0259, U+1E00-1EFF, U+2000-206F, U+2074, U+20AB, U+20AD, U+20B0, U+20B1-20BB;
}
```

**Preload trong `inc/enqueue.php` (header):**

```php
add_action( 'wp_head', 'pi_preload_fonts', 1 );
function pi_preload_fonts() {
    $fonts = [
        '/assets/fonts/inter-v18-latin-vietnamese-regular.woff2',
        '/assets/fonts/playfair-display-v37-latin-vietnamese-700.woff2',
    ];
    foreach ( $fonts as $font ) {
        printf(
            '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
            esc_url( get_stylesheet_directory_uri() . $font )
        );
    }
}
```

### 14.11 Audit tools

| Tool | Mục đích | Tần suất |
|------|----------|----------|
| [PageSpeed Insights](https://pagespeed.web.dev/) | Đo Core Web Vitals + suggestions | Trước/sau mỗi release |
| [GTmetrix](https://gtmetrix.com/) | Waterfall chi tiết | Hàng tuần |
| [WebPageTest](https://webpagetest.org/) | Test multi-location, 3G/4G simulation | Hàng tháng |
| [WP Hive](https://wphive.com/checker/) | Test plugin có ảnh hưởng performance | Trước cài plugin mới |
| Chrome DevTools → Lighthouse | Audit local | Mỗi lần edit template |
| LiteSpeed Cache → Page Optimization → Image Optimization summary | Status WebP convert | Hàng tuần |

**Acceptance criteria trước go-live:**

```
Mobile (PageSpeed Insights):
- Performance: ≥ 85
- LCP: < 2.5s
- INP: < 200ms
- CLS: < 0.1

Desktop:
- Performance: ≥ 95
- LCP: < 1.5s
```

---

## 15. SECURITY VỚI WORDFENCE

### 15.1 Mối nguy thực tế cho WordPress

WordPress chiếm ~43% website toàn cầu → là target lớn nhất. Các vector tấn công phổ biến:

| Vector | Mô tả | Phòng |
|--------|-------|-------|
| Brute force login | Bot thử password `/wp-login.php` | Rate limit + 2FA + rename URL |
| SQL injection | Lợi dụng plugin/theme cũ | Update + WAF |
| XSS (Cross-Site Scripting) | Inject JS qua form/comment | Sanitize input + Content Security Policy |
| File upload exploit | Upload PHP qua Media | Disable PHP in uploads + scan |
| XML-RPC abuse | Pingback amplification | Disable xmlrpc.php |
| Plugin vulnerability | Plugin lỗi thời | Auto-update + WPScan vulnerability check |
| Stolen credentials | Password leak | 2FA + strong password policy |
| Malicious admin | Insider threat | Activity log + role audit |
| DDoS | Flood requests | Cloudflare + rate limit |
| Malware injection | Injected vào core/theme | File integrity scan |

### 15.2 Wordfence Free — feature scope

```
✅ Endpoint Firewall (WAF) — nhưng dạng "extended" cần Premium
   Free vẫn block các signature cơ bản
✅ Malware Scanner (signature-based)
✅ Login Security (2FA + reCAPTCHA)
✅ Live Traffic Monitor
✅ Country Blocking (chỉ Premium)
❌ Real-time IP blacklist (Premium only — delay 30 ngày với Free)
❌ Real-time firewall rules (Premium only — delay 30 ngày)
```

> **[DECISION]** V1.0 dùng Wordfence Free + Cloudflare WAF rules + tự build login hardening qua code. V1.5 cân nhắc Wordfence Premium ($119/năm) nếu bị tấn công nhiều.

### 15.3 Wordfence config

#### 15.3.1 Firewall

```
WP Admin → Wordfence → Firewall → Manage Firewall:

Web Application Firewall Status: ENABLED AND PROTECTING
Protection Level: Optimized (cao hơn Basic, chạy trước WP load)

Rules:
✅ Block IPs that send POST requests with blank User-Agent and Referer
✅ Block known malicious IP addresses
✅ Block IPs that fail to use a modern web browser
✅ Increase severity for known scanners

Rate Limiting:
- If anyone's requests exceed: 240 per minute → throttle
- If a crawler's pages not found (404s) exceed: 30 per minute → block for 1 hour
- If a crawler's page views exceed: 120 per minute → throttle
- If a human's pages not found (404s) exceed: 30 per minute → throttle
- If a human's page views exceed: 240 per minute → throttle
- How long is an IP address blocked when it breaks a rule: 1 hour

Brute Force Protection:
✅ Enable brute force protection
- Lock out after how many login failures: 5
- Lock out after how many forgot password attempts: 3
- Count failures over what time period: 4 hours
- Amount of time a user is locked out: 4 hours
- Immediately lock out invalid usernames: ON
- Forgotten Password Throttling: ON
- Don't let WP reveal valid users in login errors: ON
- Prevent users registering 'admin' username: ON
- Prevent discovery of usernames through '/?author=N' scans: ON
✅ Block IPs who send POST requests with blank User-Agent and Referer
✅ Check password strength on profile update

Whitelisted Services:
✅ Cloudflare IP ranges
✅ Google
✅ Bing
✅ Pingdom (uptime monitor)
```

#### 15.3.2 Malware Scan

```
WP Admin → Wordfence → Scan → Scan Options and Scheduling:

Scheduled Scans: ✅ ON
- Scan Type: Standard Scan
- Schedule: Daily at 03:00 (server time, off-peak)

Scan Options:
✅ Scan core files against repository versions
✅ Scan theme files against repository versions
✅ Scan plugin files against repository versions
✅ Scan for signatures of known malicious files
✅ Scan file contents for backdoors, trojans, suspicious code
✅ Scan file contents for malicious URLs
✅ Scan posts for known dangerous URLs
✅ Scan comments for known dangerous URLs
✅ Scan for out of date, abandoned, vulnerable plugins/themes
✅ Check the strength of passwords
✅ Monitor disk space
✅ Monitor SSL certificate expiration
✅ Scan for publicly accessible config files
✅ Scan files outside your WordPress installation (set scan path)

Performance Options:
- Limit the number of issues sent in scan results: 1000
- Time limit for scan: 0 (disabled — let it finish)
- How much memory should Wordfence request: 256
- Maximum execution time: 0
```

#### 15.3.3 Login Security (2FA)

```
WP Admin → Login Security → Settings:

Two-Factor Authentication:
✅ Require 2FA for: Administrator, Editor
- Allow remembering device for: 30 days
- Allow grace period for non-required users: 10 days

reCAPTCHA:
✅ Enable reCAPTCHA on the login and registration pages
- Site key, Secret key (from Google reCAPTCHA v3)
- Required reCAPTCHA score: 0.5

Login Page Settings:
✅ Disable XML-RPC authentication
✅ Hide login error messages
✅ Allow IP address logging
```

#### 15.3.4 All Options

```
General Options:
✅ Enable Live Traffic
- Maximum number of live traffic items: 1000

Email Alert Preferences:
✅ Email when an admin logs in from a new device or location
✅ Email when a non-admin user logs in from a new device or location
✅ Email when WordPress, plugins, themes need an update
✅ Email when scan finds vulnerabilities
✅ Email when files modified outside their original directories
✅ Email when admin password changed
✅ Email when admin user added

Activity Report:
✅ Send weekly summary email to admin

Wordfence Central:
✅ Connect to Wordfence Central (free) — quản lý nhiều site (nếu mở thêm Pi Dentist chi nhánh)
```

### 15.4 Hardening bổ sung qua code

**File: `inc/security.php`** (require trong functions.php)

```php
<?php
/**
 * Pi Dentist Security Hardening
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 15.4.1 Disable XML-RPC entirely
 * XML-RPC bị lạm dụng cho brute force amplification
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

// Block xmlrpc.php tại Nginx tốt hơn (xem section Deploy)

/**
 * 15.4.2 Remove WordPress version từ header và scripts
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

add_filter( 'style_loader_src', 'pi_remove_version_query', 9999 );
add_filter( 'script_loader_src', 'pi_remove_version_query', 9999 );
function pi_remove_version_query( $src ) {
    if ( strpos( $src, 'ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}

/**
 * 15.4.3 Disable file editing trong Admin (Plugins/Themes editor)
 * Đặt trong wp-config.php sẽ chắc hơn:
 * define( 'DISALLOW_FILE_EDIT', true );
 * define( 'DISALLOW_FILE_MODS', true );
 */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * 15.4.4 Disable user enumeration via /?author=N
 */
add_action( 'init', 'pi_block_author_enumeration' );
function pi_block_author_enumeration() {
    if ( ! is_admin() && isset( $_GET['author'] ) ) {
        wp_die( 'Forbidden', 'Forbidden', [ 'response' => 403 ] );
    }
}

/**
 * 15.4.5 Hide login errors
 */
add_filter( 'login_errors', function() {
    return 'Thông tin đăng nhập không hợp lệ.';
} );

/**
 * 15.4.6 Remove REST API user enumeration endpoint
 */
add_filter( 'rest_endpoints', 'pi_disable_rest_users' );
function pi_disable_rest_users( $endpoints ) {
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
}

/**
 * 15.4.7 Disable REST API cho user chưa login
 */
add_filter( 'rest_authentication_errors', function( $result ) {
    if ( ! empty( $result ) ) {
        return $result;
    }
    if ( ! is_user_logged_in() ) {
        // Cho phép các route public cần thiết
        $public_routes = [
            '/wp/v2/posts',           // blog feed
            '/wp/v2/pi_service',      // service feed
            '/wp/v2/pi_doctor',       // doctor feed
            '/wp/v2/pi_case',         // case feed
            '/contact-form-7',        // không dùng
            '/fluent-form/',          // form submit
        ];
        $current = $_SERVER['REQUEST_URI'] ?? '';
        foreach ( $public_routes as $route ) {
            if ( strpos( $current, $route ) !== false ) {
                return $result;
            }
        }
        return new WP_Error(
            'rest_not_logged_in',
            'You are not currently logged in.',
            [ 'status' => 401 ]
        );
    }
    return $result;
} );

/**
 * 15.4.8 Add security headers (bổ sung cho Cloudflare/Nginx)
 */
add_action( 'send_headers', 'pi_security_headers' );
function pi_security_headers() {
    if ( is_admin() ) return;
    
    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(self)' );
    
    // CSP — adjust theo embed thực tế
    $csp = "default-src 'self'; ";
    $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com https://connect.facebook.net https://www.google.com https://www.gstatic.com; ";
    $csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; ";
    $csp .= "font-src 'self' data: https://fonts.gstatic.com; ";
    $csp .= "img-src 'self' data: https: blob:; ";
    $csp .= "frame-src 'self' https://www.google.com https://www.youtube.com https://www.facebook.com; ";
    $csp .= "connect-src 'self' https://www.google-analytics.com;";
    
    header( "Content-Security-Policy: {$csp}" );
}

/**
 * 15.4.9 Disable "Application Passwords" nếu không dùng
 */
add_filter( 'wp_is_application_passwords_available', '__return_false' );

/**
 * 15.4.10 Limit login form to specific IPs (optional, cho admin internal)
 */
// add_action( 'login_init', function() {
//     $allowed_ips = [ '203.0.113.42' ]; // IP văn phòng Up Dental
//     if ( ! in_array( $_SERVER['REMOTE_ADDR'], $allowed_ips ) ) {
//         wp_die( 'Access denied', 403 );
//     }
// });
```

### 15.5 wp-config.php hardening

```php
// =============================
// SECURITY CONSTANTS
// =============================

// Force SSL trong admin
define( 'FORCE_SSL_ADMIN', true );

// Disable file editing trong WP Admin
define( 'DISALLOW_FILE_EDIT', true );

// Disable plugin/theme installation through admin (chỉ deploy qua git/SSH)
// → BẬT sau khi setup xong
// define( 'DISALLOW_FILE_MODS', true );

// Limit post revisions (tránh phình DB)
define( 'WP_POST_REVISIONS', 5 );

// Empty trash sau 30 ngày
define( 'EMPTY_TRASH_DAYS', 30 );

// Disable WP cron qua HTTP, dùng system cron
define( 'DISABLE_WP_CRON', true );
// → Sau đó setup crontab: */5 * * * * curl -s https://pidentist.vn/wp-cron.php?doing_wp_cron > /dev/null

// Database table prefix — đổi từ 'wp_' để khó SQL injection
$table_prefix = 'pi_'; // ← thay đổi khi cài WP

// Auto-update minor only (security patches)
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

// =============================
// AUTHENTICATION KEYS
// =============================
// Generate từ https://api.wordpress.org/secret-key/1.1/salt/
// Đổi lại key này sẽ logout tất cả session — hữu ích khi nghi ngờ leak

define('AUTH_KEY',         '<random>');
define('SECURE_AUTH_KEY',  '<random>');
define('LOGGED_IN_KEY',    '<random>');
define('NONCE_KEY',        '<random>');
define('AUTH_SALT',        '<random>');
define('SECURE_AUTH_SALT', '<random>');
define('LOGGED_IN_SALT',   '<random>');
define('NONCE_SALT',       '<random>');
```

### 15.6 File permissions

```bash
# SSH vào VPS
cd /var/www/pidentist.vn/public

# Set ownership
sudo chown -R www-data:www-data .

# Folders: 755
find . -type d -exec chmod 755 {} \;

# Files: 644
find . -type f -exec chmod 644 {} \;

# wp-config.php: 600 (chỉ owner đọc/ghi)
chmod 600 wp-config.php

# wp-content/uploads cần ghi được nhưng không exec
chmod -R 755 wp-content/uploads

# Tắt PHP execution trong uploads
cat > wp-content/uploads/.htaccess << 'EOF'
<Files *.php>
deny from all
</Files>
EOF

# Trong Nginx (server block):
# location ~* /wp-content/uploads/.*\.php$ { deny all; }
```

### 15.7 Login URL rename

**Plugin:** [WPS Hide Login](https://wordpress.org/plugins/wps-hide-login/) (free, lightweight)

```
WP Admin → Settings → WPS Hide Login:
- Login URL: https://pidentist.vn/dang-nhap-pi/
- Redirection URL: https://pidentist.vn/404 (hoặc trang giả)
```

**Lưu ý:** Bookmark URL mới ngay khi đổi! Quên URL = mất quyền truy cập (phải SSH disable plugin).

### 15.8 Database security

```sql
-- 1. Tạo user riêng cho WP, không dùng root
CREATE USER 'pidentist_wp'@'localhost' IDENTIFIED BY '<strong_random_password>';

-- 2. Grant chỉ quyền cần thiết
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, INDEX, REFERENCES 
ON pidentist_db.* TO 'pidentist_wp'@'localhost';

-- 3. KHÔNG grant FILE, PROCESS, SUPER

FLUSH PRIVILEGES;
```

```bash
# Backup user (read-only)
CREATE USER 'pidentist_backup'@'localhost' IDENTIFIED BY '<password>';
GRANT SELECT, LOCK TABLES, SHOW VIEW, EVENT, TRIGGER 
ON pidentist_db.* TO 'pidentist_backup'@'localhost';
FLUSH PRIVILEGES;

# UpdraftPlus dùng pidentist_wp; mysqldump CLI dùng pidentist_backup
```

### 15.9 Activity log

**Plugin:** [WP Activity Log](https://wordpress.org/plugins/wp-security-audit-log/) (free tier)

```
Track:
✅ User logins (success + fail)
✅ User created/deleted/role changed
✅ Posts published/edited/deleted
✅ Plugins/themes activated/deactivated/updated
✅ Settings changed
✅ Files modified
✅ Failed login attempts

Retention: 90 days
Export: CSV monthly để compliance
```

### 15.10 Security checklist trước go-live

```
✅ Wordfence Free installed + cấu hình firewall + 2FA
✅ Login URL renamed (WPS Hide Login)
✅ XML-RPC disabled (code + Nginx)
✅ wp-config.php có DISALLOW_FILE_EDIT, FORCE_SSL_ADMIN
✅ Database prefix đổi từ wp_ → pi_
✅ DB user có quyền tối thiểu (không root)
✅ File permissions 755/644, wp-config.php 600
✅ PHP exec bị block trong /wp-content/uploads/
✅ Security headers (CSP, X-Frame-Options, HSTS)
✅ User enumeration disabled
✅ REST API users endpoint disabled
✅ Application Passwords disabled
✅ Auth keys/salts đã regenerate
✅ Cloudflare WAF + Firewall Rules active
✅ HTTPS enforced (Cloudflare Full Strict)
✅ Tất cả admin user có 2FA
✅ Strong password policy (min 12 chars, mixed)
✅ Backup tested restore
✅ Plugin/theme đều update mới nhất
✅ Không có user với username "admin"
✅ Không có demo content/sample plugins thừa
```

---

## 16. BACKUP STRATEGY VỚI UPDRAFTPLUS

### 16.1 Triết lý backup

**Quy tắc 3-2-1:**
- **3** bản sao dữ liệu (1 bản gốc + 2 backup)
- **2** loại lưu trữ khác nhau (local server + cloud)
- **1** bản offsite (Google Drive, không cùng datacenter với VPS)

**Hai thành phần cần backup:**
1. **Database** (tất cả nội dung, user, settings) — backup hàng ngày
2. **Files** (uploads, theme, plugins) — backup hàng tuần

**RTO/RPO mục tiêu:**
- RTO (Recovery Time Objective): < 4 giờ — khôi phục site trong 4h kể từ lúc phát hiện sự cố
- RPO (Recovery Point Objective): < 24 giờ — chấp nhận mất tối đa 24h dữ liệu

### 16.2 UpdraftPlus Free — feature scope

```
✅ Manual backup
✅ Scheduled backup (daily/weekly/monthly)
✅ Backup to: Google Drive, Dropbox, OneDrive (free), Amazon S3, FTP
✅ Restore from backup
✅ Migrate to new domain (chỉ Premium)
✅ Multiple destinations (chỉ Premium)
✅ Encrypt database backup (chỉ Premium)
✅ Incremental backups (chỉ Premium)
```

> **[DECISION]** V1.0 dùng UpdraftPlus Free + Google Drive. Nếu cần encrypt DB hoặc multi-destination → upgrade Premium ($70/năm) hoặc dùng `mysqldump + cron + rsync` thủ công.

### 16.3 UpdraftPlus config

#### 16.3.1 Settings tab

```
WP Admin → Settings → UpdraftPlus Backups → Settings:

Files backup schedule: Weekly, Retain: 4
Database backup schedule: Daily, Retain: 14

Choose your remote storage: Google Drive
- Authenticate with Google: (click → đăng nhập tài khoản Google của Pi Dentist)
- Folder: UpdraftPlus / pidentist.vn / (auto-created)

Include in files backup:
✅ Plugins
✅ Themes  
✅ Uploads
✅ Any other directories found inside wp-content
   - cache (exclude — không cần)
   - upgrade (exclude)

Email: tranquocdat147@gmail.com (admin email cho status report)

Expert settings:
- Debug mode: OFF (chỉ bật khi troubleshoot)
- Split archives every: 400 MB
- Use the server's SSL certificates: ON
- Disable SSL: OFF
- Do not verify SSL certificates: OFF
- Only allow this WordPress installation to back up to this remote storage: ON
```

#### 16.3.2 Advanced Tools

```
✅ Lock UpdraftPlus settings (yêu cầu mật khẩu admin để thay đổi):
   → Tránh attacker đổi destination
   
✅ Site / database migrator (chỉ Premium)
✅ Search/replace database (free) — dùng khi đổi domain
```

### 16.4 Google Drive setup chi tiết

**Bước 1:** Tạo Google account riêng cho backup (không dùng tài khoản cá nhân Đạt):
- Email: `backup.pidentist@gmail.com`
- Mật khẩu mạnh + 2FA
- Storage: Free 15GB (đủ cho ~50 bản backup), upgrade Google One 100GB nếu cần ($1.99/tháng)

**Bước 2:** Trong UpdraftPlus → Settings → click "Authenticate with Google":
1. Trình duyệt mở popup → đăng nhập `backup.pidentist@gmail.com`
2. Cấp quyền "View and manage files in your Google Drive"
3. Quay lại WP Admin → click "Complete setup"

**Bước 3:** Kiểm tra kết nối:
- WP Admin → UpdraftPlus → Backup / Restore → click "Backup Now"
- Tick "Include the database in the backup"
- Tick "Include any files in the backup"
- Tick "Send this backup to remote storage"
- Đợi ~5-10 phút (tùy site size)
- Mở Google Drive → kiểm tra folder `UpdraftPlus / pidentist.vn /` có file `.zip` và `.gz`

### 16.5 Backup naming convention

UpdraftPlus tự đặt tên:
```
backup_2025-12-15-0300_PiDentist_<site-id>-db.gz
backup_2025-12-15-0300_PiDentist_<site-id>-plugins.zip
backup_2025-12-15-0300_PiDentist_<site-id>-themes.zip
backup_2025-12-15-0300_PiDentist_<site-id>-uploads.zip
backup_2025-12-15-0300_PiDentist_<site-id>-others.zip
```

Format: `backup_<date>-<time>_<sitename>_<site-id>-<type>.<ext>`

### 16.6 Test restore quy trình (CRỐNG MỖI THÁNG)

**Quan trọng:** Backup chưa test = không có backup!

**Quy trình test trên staging:**

```bash
# 1. Tạo subdomain staging.pidentist.vn (cùng VPS, vhost riêng)
# 2. Cài WP fresh ở staging
# 3. Cài UpdraftPlus, kết nối Google Drive (READ-ONLY user)
# 4. UpdraftPlus → Existing Backups → Rescan remote storage
# 5. Chọn backup mới nhất → Restore
# 6. Tick: Database, Plugins, Themes, Uploads, Others
# 7. Confirm → đợi restore (10-30 phút)
# 8. Check staging.pidentist.vn:
#    - Trang chủ render đúng
#    - Login admin được
#    - Posts/CPT đầy đủ
#    - Hình ảnh load đúng
# 9. Document kết quả: file BACKUP_RESTORE_LOG.md (date, restore time, issues)
```

**Schedule test:**
- Đầu mỗi tháng (ngày 1)
- Sau mỗi major update (WP core, theme, plugin lớn)
- Sau mỗi migration

### 16.7 Backup strategy bổ sung — server-level

UpdraftPlus là backup application-level. Bổ sung thêm backup server-level qua VPS provider:

#### 16.7.1 DigitalOcean / Vultr Snapshots

```
Provider Dashboard → Backups (auto-snapshot):
- Frequency: Weekly
- Retention: 4 weeks
- Cost: ~20% giá VPS (~$1-2/tháng cho VPS $5)

→ Khi VPS chết hoàn toàn (ổ cứng hỏng, hacker xóa), restore snapshot trong 5 phút.
```

#### 16.7.2 mysqldump cron (off-site sang VPS thứ 2)

**File: `/usr/local/bin/pi-db-backup.sh`**

```bash
#!/bin/bash
# Pi Dentist Database Backup
# Run via cron: 0 4 * * * /usr/local/bin/pi-db-backup.sh

set -e

DATE=$(date +%Y%m%d-%H%M%S)
BACKUP_DIR="/var/backups/pidentist/db"
DB_NAME="pidentist_db"
DB_USER="pidentist_backup"
DB_PASS="$(cat /root/.db-backup-pass)"  # file 0400 owned by root
RETENTION_DAYS=14

# Tạo folder nếu chưa có
mkdir -p "$BACKUP_DIR"

# Dump DB (chỉ DDL + data, không có user info)
mysqldump \
  --user="$DB_USER" \
  --password="$DB_PASS" \
  --single-transaction \
  --quick \
  --lock-tables=false \
  --add-drop-table \
  --routines \
  --triggers \
  "$DB_NAME" | gzip > "$BACKUP_DIR/db-$DATE.sql.gz"

# Xóa backup > retention days
find "$BACKUP_DIR" -name "db-*.sql.gz" -mtime +$RETENTION_DAYS -delete

# Sync lên VPS thứ 2 (rsync over SSH key)
rsync -avz --delete \
  -e "ssh -i /root/.ssh/backup_key" \
  "$BACKUP_DIR/" \
  backup@<BACKUP_VPS_IP>:/var/backups/pidentist/db/

echo "[$(date)] Backup completed: db-$DATE.sql.gz"
```

```bash
# Setup
chmod 700 /usr/local/bin/pi-db-backup.sh
chown root:root /usr/local/bin/pi-db-backup.sh

# Crontab
crontab -e
# Thêm:
0 4 * * * /usr/local/bin/pi-db-backup.sh >> /var/log/pi-backup.log 2>&1
```

#### 16.7.3 rclone sync uploads sang Backblaze B2

```bash
# Backblaze B2: $0.005/GB/tháng (rẻ hơn S3)
# Cài rclone: curl https://rclone.org/install.sh | sudo bash

# Config:
rclone config
# - New remote: pi-b2
# - Storage: Backblaze B2
# - Account ID, Application Key (từ B2 dashboard)

# Sync hàng tuần:
# /usr/local/bin/pi-uploads-backup.sh
rclone sync /var/www/pidentist.vn/public/wp-content/uploads/ \
  pi-b2:pidentist-uploads/ \
  --progress \
  --transfers 4
```

```cron
# Crontab: 0 5 * * 0 /usr/local/bin/pi-uploads-backup.sh
```

### 16.8 Disaster recovery plan

**Scenario 1: Site bị hack, defaced**
1. Cô lập: Cloudflare → bật Under Attack Mode
2. SSH vào VPS, đặt site offline (`.maintenance` file)
3. Phân tích: chạy Wordfence scan, kiểm tra Activity Log
4. Nếu confirm bị hack: restore từ backup gần nhất CHƯA bị nhiễm
5. Đổi tất cả mật khẩu (DB, FTP, Admin, salts trong wp-config)
6. Update WP core, plugins, themes lên version mới
7. Audit user accounts, xóa user lạ
8. Bật lại site

**Scenario 2: VPS chết hoàn toàn**
1. Tạo VPS mới cùng region (DigitalOcean → 5 phút)
2. Restore từ snapshot weekly (nếu có) HOẶC build lại từ deploy script
3. Pull child theme từ git: `git clone https://github.com/updental/pidentist`
4. Restore DB từ UpdraftPlus → Google Drive
5. Restore uploads từ B2 hoặc UpdraftPlus
6. Update DNS Cloudflare → IP mới (proxy ON, không cần đợi propagation)
7. Test → bật lại traffic

**Scenario 3: Mất database (corrupt)**
1. Stop Nginx (`systemctl stop nginx`)
2. Backup DB hiện tại (corrupt) để analyze sau: `mysqldump > corrupt.sql`
3. DROP DATABASE pidentist_db
4. CREATE DATABASE pidentist_db
5. Import từ backup gần nhất: `gunzip < db-latest.sql.gz | mysql pidentist_db`
6. Verify count posts, users
7. Start Nginx, test

**Scenario 4: Xóa nhầm post quan trọng**
1. UpdraftPlus → Existing Backups → chọn backup hôm trước
2. Restore → tick CHỈ "Database" → tick "Restore only specific tables"
3. Chọn `pi_posts`, `pi_postmeta` → Restore
4. Verify post quay lại

### 16.9 Backup checklist hàng tháng

```
□ UpdraftPlus → kiểm tra log: tất cả backup daily đã chạy thành công?
□ Google Drive → kiểm tra dung lượng còn trống (< 80% sử dụng)?
□ Server snapshot weekly → còn 4 bản gần nhất?
□ Test restore trên staging — restore time < 30 phút?
□ Restore log → có issue gì không?
□ DB dump cron → /var/log/pi-backup.log không có error?
□ B2 sync → uploads đã sync mới nhất?
□ Email backup status có đến đúng người (Đạt + bộ phận IT)?
□ DOWNLOAD 1 BẢN BACKUP VỀ MÁY CÁ NHÂN (ngừa Google account bị khoá)
```

---

## 17. LOCAL DEVELOPMENT ENVIRONMENT

### 17.1 Mục tiêu

- Một môi trường local giống production để vibe code mà không động vào site live.
- Sync data từ production xuống local để test với dữ liệu thực.
- Version control child theme + custom plugins qua Git.
- Có thể demo cho team nội bộ trước khi deploy.

### 17.2 Chọn local stack: LocalWP vs Laragon

| Tiêu chí | LocalWP | Laragon |
|----------|---------|---------|
| Cài đặt | One-click installer | Manual setup hơn |
| OS | Mac, Windows, Linux | Chỉ Windows |
| Tốc độ | Nhanh (Docker dưới mui) | Rất nhanh (native) |
| Multi-site | Mỗi site 1 container | Tất cả share 1 stack |
| Mail catcher | Mailhog built-in | Cài thêm |
| Live link | Built-in (free) | Cần ngrok |
| Học phí | Miễn phí (Local Free) | Miễn phí |
| Đổi PHP version | UI dropdown | Manual |

**[DECISION]** Đạt dùng Windows → đề xuất **LocalWP (Local Free by WP Engine)** vì:
1. Setup 1-click, không cần config Nginx/PHP/MySQL.
2. UI thân thiện cho người không phải dev.
3. Live Link share được URL tạm cho team xem.
4. Mail catcher giúp test email mà không spam.
5. WP Engine maintain → ổn định.

### 17.3 LocalWP setup

**Bước 1:** Download Local từ https://localwp.com (miễn phí)

**Bước 2:** Tạo site mới:
```
+ Create a new site
- Site name: pidentist
- Domain: pidentist.local
- PHP version: 8.2
- Web server: Nginx
- Database: MySQL 8.0
- WordPress: latest stable
- Multisite: No

WordPress credentials (local only):
- Username: piadmin
- Password: pi-local-2025 (chỉ dùng local!)
- Admin email: dev@pidentist.vn
```

**Bước 3:** Sau khi Local tạo xong → mở site:
- Site URL: http://pidentist.local
- WP Admin: http://pidentist.local/wp-admin

**Bước 4:** Bật **Live Link** (chia sẻ URL tạm với team):
- Click "Live Link" trong Local UI
- Local sẽ generate URL dạng `https://abc123.tunnel.localwp.com`
- URL này live ~12 giờ, cho team review trước khi deploy

### 17.4 Sync production → local

**Phương pháp 1 — UpdraftPlus Migrator (cần Premium nếu đổi domain):**
- Production → UpdraftPlus → Backup Now (có Database)
- Local → cài UpdraftPlus → upload backup
- Restore + Search/Replace domain `pidentist.vn` → `pidentist.local`

**Phương pháp 2 — WP Migrate Lite (free, có search/replace):**

```
Production → WP Migrate → Export
- Find: //pidentist.vn  → Replace: //pidentist.local
- Find: /var/www/pidentist.vn/public → Replace: /Users/dat/Local Sites/pidentist/app/public
- Output: SQL file

Local → WP Migrate → Import → upload SQL
```

**Phương pháp 3 — CLI thủ công (Recommended):**

```bash
# Production VPS
cd /var/www/pidentist.vn/public
wp db export prod-$(date +%Y%m%d).sql

# Download về máy
scp user@vps:/var/www/pidentist.vn/public/prod-*.sql ~/Downloads/

# Local — import qua Local "Open Site Shell"
wp db import ~/Downloads/prod-20251215.sql

# Search/replace domain (an toàn với serialized data)
wp search-replace 'https://pidentist.vn' 'http://pidentist.local' --all-tables --skip-columns=guid

# Search/replace path (nếu có path absolute)
wp search-replace '/var/www/pidentist.vn/public' '/Users/dat/Local Sites/pidentist/app/public' --all-tables

# Flush cache
wp cache flush
wp rewrite flush
```

**Sync uploads:**

```bash
# rsync uploads từ production
rsync -avz --progress \
  user@vps:/var/www/pidentist.vn/public/wp-content/uploads/ \
  '/Users/dat/Local Sites/pidentist/app/public/wp-content/uploads/'
```

### 17.5 Git workflow cho child theme

**Repository structure:**

```
github.com/updental/pidentist (private repo)
├── .gitignore
├── README.md
├── child-theme/
│   └── (toàn bộ wp-content/themes/pidentist/)
├── mu-plugins/
│   └── (must-use plugins custom)
└── docs/
    ├── PROJECT_SPEC_WP.md
    └── PROMPTS_WP.md
```

**File: `.gitignore`**

```
# Local environment
.local
*.log
.DS_Store
Thumbs.db

# IDE
.idea/
.vscode/settings.json
*.sublime-*

# Build artifacts
node_modules/
*.cache
.cache/

# WordPress (KHÔNG commit core)
wp-admin/
wp-includes/
wp-*.php
xmlrpc.php
license.txt
readme.html
wp-config.php
wp-config-sample.php

# Plugins (cài qua admin, không commit)
wp-content/plugins/

# Themes ngoại trừ child theme
wp-content/themes/!(pidentist)
wp-content/themes/twentytwenty*

# Uploads (lớn, không commit)
wp-content/uploads/

# Cache
wp-content/cache/
wp-content/uploads/litespeed/
wp-content/litespeed/
wp-content/wflogs/
wp-content/object-cache.php
wp-content/advanced-cache.php
wp-content/db.php

# Backup files
backup/
*.sql
*.sql.gz
*.zip

# Sensitive
.env
.env.local
*.pem
*.key
```

**Workflow:**

```bash
# Lần đầu setup
cd '/Users/dat/Local Sites/pidentist/app/public/wp-content/themes/'
git clone git@github.com:updental/pidentist.git pidentist-repo

# Symlink child theme từ repo vào themes folder
ln -s pidentist-repo/child-theme pidentist

# Daily workflow
cd pidentist-repo
git pull origin main

# Sửa code trong VS Code → save → refresh browser
# Khi xong feature
git add .
git commit -m "feat: add hero banner block pattern"
git push origin main

# Production VPS deploy
ssh user@vps
cd /var/www/pidentist.vn/public/wp-content/themes/pidentist
git pull origin main
wp cache flush
wp rocket clean --confirm  # nếu dùng WP Rocket
# (LiteSpeed: vào admin → Toolbox → Purge All)
```

### 17.6 Branching strategy

```
main         ← production (luôn deployable)
├── develop  ← integration (test trước khi merge main)
│   ├── feature/hero-pattern
│   ├── feature/cpt-service
│   ├── feature/booking-form
│   └── fix/typography-mobile
└── hotfix/critical-security-patch  ← khẩn cấp, merge trực tiếp main
```

**Quy tắc:**
- Mọi feature mới: branch từ `develop`
- Merge feature → develop qua Pull Request (self-review nếu solo)
- Khi `develop` ổn định → merge `develop` → `main`
- `main` mỗi lần merge = trigger deploy production
- Hotfix critical: branch từ `main`, merge ngược cả `main` và `develop`

### 17.7 Composer cho dependency PHP (optional)

Nếu child theme cần thư viện PHP (vd: Twig, Carbon date), dùng Composer:

**File: `composer.json`** (trong child theme)

```json
{
  "name": "updental/pidentist",
  "description": "Pi Dentist child theme",
  "type": "wordpress-theme",
  "license": "proprietary",
  "require": {
    "php": ">=8.2",
    "nesbot/carbon": "^3.0"
  },
  "autoload": {
    "psr-4": {
      "Pi\\Dentist\\": "src/"
    }
  }
}
```

```bash
cd wp-content/themes/pidentist
composer install
# → tạo /vendor/ folder

# .gitignore: thêm /vendor/
# Production: chạy composer install --no-dev sau git pull
```

> **[DECISION]** V1.0 KHÔNG dùng Composer — child theme đủ đơn giản, dùng PHP native. V1.5 nếu code phình to mới cân nhắc.

### 17.8 NPM cho asset compilation (optional)

Nếu muốn dùng SCSS, ES6 modules, Tailwind:

**File: `package.json`**

```json
{
  "name": "pidentist",
  "version": "1.0.0",
  "private": true,
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "watch": "vite build --watch"
  },
  "devDependencies": {
    "vite": "^5.0.0",
    "sass": "^1.70.0",
    "autoprefixer": "^10.4.0",
    "postcss": "^8.4.0"
  }
}
```

> **[DECISION]** V1.0 KHÔNG dùng NPM — viết CSS/JS thuần trong `assets/css/` và `assets/js/`, đơn giản hơn cho vibe code. Khi cần build pipeline → bổ sung Vite.

### 17.9 Testing local checklist

Trước khi commit code mới:

```
□ Site hiển thị đúng ở pidentist.local (không lỗi PHP)
□ WP Admin login được, không có notice mới
□ Console browser không có error JS
□ Block Editor render Block Pattern không lỗi
□ Test 3 trang chính: home, /dich-vu/, /bac-si/
□ Test responsive: 375px, 768px, 1280px
□ Lighthouse local: Performance > 80, không có lỗi a11y
□ wp_debug.log trống (kiểm tra wp-content/debug.log)
□ git status — chỉ có file dự định commit
```

**Bật WP Debug local:**

**File: `wp-config.php`** (chỉ trên local)

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );    // log vào wp-content/debug.log
define( 'WP_DEBUG_DISPLAY', false ); // không hiện trên màn hình
@ini_set( 'display_errors', 0 );
define( 'SCRIPT_DEBUG', true );    // load CSS/JS không minify
define( 'SAVEQUERIES', true );     // log SQL queries (chỉ profiling)
```

**Plugin hữu ích trên local (KHÔNG cài production):**

| Plugin | Mục đích |
|--------|----------|
| Query Monitor | Debug SQL, hooks, errors |
| Debug Bar | Toolbar debug |
| User Switching | Test với role khác mà không logout |
| WP Reset | Reset DB nhanh khi test xong |
| Theme Check | Audit theme code chuẩn WP |

### 17.10 IDE setup — VS Code

**Extensions khuyến nghị:**

```
- PHP Intelephense (jump to definition, autocomplete)
- WordPress Snippets (snippets WP function)
- WordPress Hooks IntelliSense
- Better PHP Syntax
- PHP DocBlocker
- ESLint (for JS)
- Stylelint (for CSS)
- GitLens
- Prettier
- Code Spell Checker (kiểm typo)
```

**Settings: `.vscode/settings.json`** (commit vào repo)

```json
{
  "editor.tabSize": 4,
  "editor.insertSpaces": false,
  "editor.detectIndentation": false,
  "editor.formatOnSave": true,
  "editor.rulers": [80, 120],
  "files.eol": "\n",
  "files.trimTrailingWhitespace": true,
  "files.insertFinalNewline": true,
  "[php]": {
    "editor.defaultFormatter": "bmewburn.vscode-intelephense-client",
    "editor.tabSize": 4,
    "editor.insertSpaces": false
  },
  "[javascript]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode",
    "editor.tabSize": 2,
    "editor.insertSpaces": true
  },
  "[css]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode",
    "editor.tabSize": 2
  },
  "intelephense.environment.phpVersion": "8.2.0",
  "intelephense.stubs": [
    "wordpress",
    "wordpress-globals",
    "wp-cli",
    "Core",
    "date",
    "json",
    "mbstring"
  ],
  "intelephense.format.braces": "k&r",
  "phpfmt.psr2": true
}
```

**File: `.editorconfig`** (chuẩn cross-IDE)

```ini
root = true

[*]
charset = utf-8
end_of_line = lf
indent_style = tab
indent_size = 4
trim_trailing_whitespace = true
insert_final_newline = true

[*.{js,jsx,ts,tsx,css,scss,json,yml,yaml,md}]
indent_style = space
indent_size = 2

[*.md]
trim_trailing_whitespace = false
```

### 17.11 Troubleshooting common local issues

| Issue | Nguyên nhân | Fix |
|-------|-------------|-----|
| Site Health: HTTPS warning | LocalWP HTTP only | Cài "SSL/HTTPS" plugin local hoặc bỏ qua |
| Email không gửi | Localhost không có SMTP | Dùng WP Mail Logging plugin để debug |
| Permalink 404 | mod_rewrite Nginx chưa apply | Settings → Permalinks → Save lại |
| Block Editor lỗi | Cache browser | Hard reload Ctrl+Shift+R |
| White screen | PHP fatal error | Check wp-content/debug.log |
| DB connection error | Local không start | Restart Local app |
| Slow loading | OPcache disabled local | Tăng memory_limit trong php.ini Local |

---

## 18. DEPLOY PLAN VPS

### 18.1 Chọn VPS provider

| Provider | Giá khởi điểm | Pro | Con | Đánh giá cho Pi Dentist |
|----------|---------------|-----|-----|------------------------|
| DigitalOcean | $6/tháng (1GB RAM, 25GB SSD) | UI dễ, snapshot, Cloud Firewall | Datacenter gần nhất là Singapore | ★★★★ Recommended |
| Vultr | $6/tháng (1GB RAM, 25GB SSD) | Có DC Tokyo + Seoul gần VN hơn | UI bớt friendly hơn DO | ★★★★ Tốt cho latency |
| Hetzner | €4.5/tháng (4GB RAM, 40GB SSD) | Giá/cấu hình tốt nhất EU | Latency từ VN cao (~280ms) | ★★ Không phù hợp |
| AWS Lightsail | $5/tháng (1GB RAM, 40GB SSD) | Tích hợp AWS ecosystem | Quản lý phức tạp hơn | ★★★ Nếu đã quen AWS |
| TinoHost / Vinahost | 200K-500K/tháng VN | Datacenter VN, thanh toán VND, support TV | Tài nguyên kém hơn | ★★★ Nếu cần latency thấp tuyệt đối |

**[DECISION]** V1.0 dùng **Vultr High Frequency Tokyo** $12/tháng (1 vCPU, 2GB RAM, 64GB NVMe):
- Latency từ VN ~80-100ms (so với Singapore ~50-80ms, EU ~280ms)
- NVMe SSD nhanh hơn SSD thường ~3x
- Snapshot $0.05/GB/tháng
- Bandwidth 2TB/tháng (đủ cho < 100K visitors/tháng)
- Có thể scale lên 4GB RAM nếu cần

### 18.2 Yêu cầu hệ thống

```
OS: Ubuntu 22.04 LTS (server, không GUI)
RAM tối thiểu: 2 GB (recommend 4 GB nếu nhiều plugin)
CPU: 1 vCPU (đủ cho < 50 concurrent)
Disk: 40 GB SSD (50% headroom cho logs, backups)
Network: 1 Gbps, IPv4 dedicated, IPv6 enabled

Stack:
- Nginx 1.24+
- PHP 8.2 (FPM)
- MariaDB 10.11 (LTS) hoặc MySQL 8.0
- Redis 7.0+
- Certbot (Let's Encrypt)
- UFW (firewall)
- Fail2ban
```

### 18.3 Provisioning script (Ubuntu 22.04)

**File: `deploy/01-provision.sh`** (chạy trên VPS sau khi tạo)

```bash
#!/bin/bash
# Pi Dentist VPS Provisioning Script
# Run as root after fresh Ubuntu 22.04 install

set -e

echo "=== 1. System update ==="
apt update && apt upgrade -y
apt install -y curl wget git unzip software-properties-common ca-certificates lsb-release apt-transport-https

echo "=== 2. Set timezone & locale ==="
timedatectl set-timezone Asia/Ho_Chi_Minh
locale-gen vi_VN.UTF-8

echo "=== 3. Create deploy user ==="
useradd -m -s /bin/bash -G sudo deploy
mkdir -p /home/deploy/.ssh
# Manually copy SSH public key:
# echo "ssh-ed25519 AAAA... admin@updental" > /home/deploy/.ssh/authorized_keys
chmod 700 /home/deploy/.ssh
chmod 600 /home/deploy/.ssh/authorized_keys 2>/dev/null || true
chown -R deploy:deploy /home/deploy/.ssh

echo "=== 4. Disable root SSH login ==="
sed -i 's/#\?PermitRootLogin.*/PermitRootLogin no/' /etc/ssh/sshd_config
sed -i 's/#\?PasswordAuthentication.*/PasswordAuthentication no/' /etc/ssh/sshd_config
sed -i 's/#\?PubkeyAuthentication.*/PubkeyAuthentication yes/' /etc/ssh/sshd_config
systemctl restart sshd

echo "=== 5. Firewall (UFW) ==="
ufw default deny incoming
ufw default allow outgoing
ufw allow 22/tcp comment 'SSH'
ufw allow 80/tcp comment 'HTTP'
ufw allow 443/tcp comment 'HTTPS'
ufw --force enable

echo "=== 6. Install Nginx ==="
apt install -y nginx
systemctl enable nginx

echo "=== 7. Install PHP 8.2 + extensions ==="
add-apt-repository -y ppa:ondrej/php
apt update
apt install -y php8.2-fpm php8.2-cli php8.2-mysql \
    php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml \
    php8.2-zip php8.2-intl php8.2-bcmath php8.2-imagick \
    php8.2-redis php8.2-opcache

echo "=== 8. Install MariaDB ==="
apt install -y mariadb-server
mysql_secure_installation  # interactive — đặt root password mạnh

echo "=== 9. Install Redis ==="
apt install -y redis-server
sed -i 's/^supervised no/supervised systemd/' /etc/redis/redis.conf
sed -i 's/^# maxmemory <bytes>/maxmemory 256mb/' /etc/redis/redis.conf
sed -i 's/^# maxmemory-policy noeviction/maxmemory-policy allkeys-lru/' /etc/redis/redis.conf
systemctl restart redis-server
systemctl enable redis-server

echo "=== 10. Install Certbot ==="
apt install -y certbot python3-certbot-nginx

echo "=== 11. Install Fail2ban ==="
apt install -y fail2ban

cat > /etc/fail2ban/jail.local << 'EOF'
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 5
ignoreip = 127.0.0.1/8 ::1

[sshd]
enabled = true

[wordpress]
enabled = true
filter = wordpress
logpath = /var/log/nginx/access.log
maxretry = 3
bantime = 7200
EOF

cat > /etc/fail2ban/filter.d/wordpress.conf << 'EOF'
[Definition]
failregex = ^<HOST> .* "POST /wp-login\.php
            ^<HOST> .* "POST /xmlrpc\.php
ignoreregex =
EOF

systemctl restart fail2ban
systemctl enable fail2ban

echo "=== 12. Install WP-CLI ==="
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

echo "=== 13. Create WordPress directory ==="
mkdir -p /var/www/pidentist.vn/public
mkdir -p /var/www/pidentist.vn/logs
chown -R www-data:www-data /var/www/pidentist.vn

echo "=== 14. Create FastCGI cache dir ==="
mkdir -p /var/cache/nginx/pidentist
chown www-data:www-data /var/cache/nginx/pidentist

echo "=== Provisioning complete! ==="
echo "Next steps:"
echo "1. Copy SSH public key to /home/deploy/.ssh/authorized_keys"
echo "2. Configure PHP-FPM (see 02-php-config.sh)"
echo "3. Configure Nginx (see 03-nginx-config.sh)"
echo "4. Create database (see 04-database.sh)"
echo "5. Install WordPress (see 05-wordpress-install.sh)"
```

### 18.4 PHP-FPM tuning

**File: `/etc/php/8.2/fpm/pool.d/www.conf`** (highlights)

```ini
[www]
user = www-data
group = www-data
listen = /run/php/php8.2-fpm.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

; Process management — tuning theo RAM
pm = dynamic
pm.max_children = 30          ; max processes (tuỳ RAM, mỗi process ~30MB)
pm.start_servers = 5
pm.min_spare_servers = 3
pm.max_spare_servers = 10
pm.max_requests = 500         ; restart sau N requests (tránh memory leak)

; Performance
request_terminate_timeout = 60s
rlimit_files = 65535

; Logging
slowlog = /var/log/php8.2-slow.log
request_slowlog_timeout = 5s

; Status page (cho monitoring)
pm.status_path = /php-status
ping.path = /php-ping
```

**File: `/etc/php/8.2/fpm/php.ini`** (override)

```ini
memory_limit = 256M
upload_max_filesize = 32M
post_max_size = 32M
max_execution_time = 60
max_input_vars = 5000
date.timezone = Asia/Ho_Chi_Minh

; Hide PHP version
expose_php = Off

; Session
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = "Lax"
session.use_strict_mode = 1

; Disable dangerous functions
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,curl_multi_exec,parse_ini_file,show_source

; OPcache (xem section 14.6)
opcache.enable = 1
opcache.memory_consumption = 256
opcache.max_accelerated_files = 20000
opcache.validate_timestamps = 1
opcache.revalidate_freq = 2
opcache.jit = 1255
opcache.jit_buffer_size = 128M
```

```bash
systemctl restart php8.2-fpm
```

### 18.5 Nginx config

**File: `/etc/nginx/nginx.conf`** (highlights)

```nginx
user www-data;
worker_processes auto;
worker_rlimit_nofile 65535;

events {
    worker_connections 4096;
    multi_accept on;
    use epoll;
}

http {
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;
    server_tokens off;          # hide Nginx version
    client_max_body_size 32M;
    
    include /etc/nginx/mime.types;
    default_type application/octet-stream;
    
    # SSL
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:50m;
    ssl_session_timeout 1d;
    ssl_session_tickets off;
    ssl_stapling on;
    ssl_stapling_verify on;
    
    # Gzip
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types
        text/plain
        text/css
        text/xml
        text/javascript
        application/json
        application/javascript
        application/xml+rss
        application/atom+xml
        image/svg+xml;
    
    # Brotli (nếu compile module brotli)
    # brotli on;
    # brotli_comp_level 6;
    # brotli_types ...;
    
    # Logs
    log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                    '$status $body_bytes_sent "$http_referer" '
                    '"$http_user_agent" "$http_x_forwarded_for" '
                    'cache=$upstream_cache_status';
    access_log /var/log/nginx/access.log main;
    error_log /var/log/nginx/error.log warn;
    
    # Rate limiting zones
    limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
    limit_req_zone $binary_remote_addr zone=api:10m rate=30r/m;
    
    # FastCGI cache
    fastcgi_cache_path /var/cache/nginx/pidentist 
        levels=1:2 keys_zone=PIDENTIST:100m max_size=1g 
        inactive=60m use_temp_path=off;
    fastcgi_cache_key "$scheme$request_method$host$request_uri";
    fastcgi_cache_use_stale error timeout invalid_header updating http_500 http_503;
    fastcgi_cache_lock on;
    
    include /etc/nginx/conf.d/*.conf;
    include /etc/nginx/sites-enabled/*;
}
```

**File: `/etc/nginx/sites-available/pidentist.vn`**

```nginx
# HTTP → HTTPS redirect
server {
    listen 80;
    listen [::]:80;
    server_name pidentist.vn www.pidentist.vn;
    return 301 https://pidentist.vn$request_uri;
}

# WWW → non-WWW redirect
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name www.pidentist.vn;
    
    ssl_certificate /etc/letsencrypt/live/pidentist.vn/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/pidentist.vn/privkey.pem;
    
    return 301 https://pidentist.vn$request_uri;
}

# Main server
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name pidentist.vn;
    
    root /var/www/pidentist.vn/public;
    index index.php index.html;
    
    # SSL
    ssl_certificate /etc/letsencrypt/live/pidentist.vn/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/pidentist.vn/privkey.pem;
    ssl_trusted_certificate /etc/letsencrypt/live/pidentist.vn/chain.pem;
    
    # Security headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Permissions-Policy "camera=(), microphone=(), geolocation=(self)" always;
    
    # Logs
    access_log /var/www/pidentist.vn/logs/access.log main;
    error_log /var/www/pidentist.vn/logs/error.log warn;
    
    # ===== SECURITY BLOCKS =====
    
    # Block common attack paths
    location ~ /\.(?!well-known) { deny all; }
    location ~* /(?:wp-config\.php|wp-config-sample\.php|readme\.html|license\.txt|wp-trackback\.php) { deny all; }
    location ~* /\.git { deny all; }
    location ~* /\.env { deny all; }
    
    # Block xmlrpc.php
    location = /xmlrpc.php { deny all; }
    
    # Block PHP execution trong uploads
    location ~* /wp-content/uploads/.*\.php$ { deny all; }
    
    # Block PHP trong wp-content/themes/.../assets
    location ~* /wp-content/themes/.+\.(html|htm|txt|md)$ { deny all; }
    
    # Block author enumeration
    if ($args ~* "author=\d") { return 403; }
    
    # Rate limit login
    location = /wp-login.php {
        limit_req zone=login burst=2 nodelay;
        include /etc/nginx/snippets/php-handler.conf;
    }
    
    # Rate limit REST API
    location ~ ^/wp-json/ {
        limit_req zone=api burst=10 nodelay;
        try_files $uri $uri/ /index.php?$args;
    }
    
    # ===== STATIC ASSETS =====
    
    # Long cache for static files
    location ~* \.(jpg|jpeg|png|gif|ico|svg|webp|avif|woff|woff2|ttf|otf|eot|css|js|mp4|webm)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
        try_files $uri =404;
    }
    
    # ===== CACHE BYPASS RULES =====
    
    set $skip_cache 0;
    
    if ($request_method = POST) { set $skip_cache 1; }
    if ($query_string != "") { set $skip_cache 1; }
    if ($http_cookie ~* "comment_author|wordpress_[a-f0-9]+|wp-postpass|wordpress_logged_in") { set $skip_cache 1; }
    if ($request_uri ~* "/wp-admin/|/xmlrpc.php|wp-.*.php|/feed/|index.php|sitemap(_index)?.xml") { set $skip_cache 1; }
    if ($request_uri ~* "^/(dat-lich)") { set $skip_cache 1; }
    
    # ===== WORDPRESS PERMALINKS =====
    
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    
    # ===== PHP HANDLER =====
    
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 256 16k;
        fastcgi_busy_buffers_size 256k;
        fastcgi_temp_file_write_size 256k;
        fastcgi_read_timeout 60s;
        
        # FastCGI cache
        fastcgi_cache_bypass $skip_cache;
        fastcgi_no_cache $skip_cache;
        fastcgi_cache PIDENTIST;
        fastcgi_cache_valid 200 301 302 60m;
        fastcgi_cache_valid 404 1m;
        
        add_header X-Cache $upstream_cache_status;
    }
    
    # PHP status (chỉ allow internal)
    location ~ ^/(php-status|php-ping)$ {
        access_log off;
        allow 127.0.0.1;
        deny all;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        include fastcgi_params;
    }
    
    # Cache purge endpoint (cho Nginx Helper)
    location ~ /purge(/.*) {
        fastcgi_cache_purge PIDENTIST "$scheme$request_method$host$1";
        access_log off;
        allow 127.0.0.1;
        deny all;
    }
    
    # ===== ROBOTS & SITEMAP =====
    
    location = /robots.txt {
        log_not_found off;
        access_log off;
        try_files $uri /index.php?$args;
    }
    
    location ~ ^/sitemap.*\.xml$ {
        try_files $uri /index.php?$args;
    }
}
```

**Enable site:**
```bash
ln -s /etc/nginx/sites-available/pidentist.vn /etc/nginx/sites-enabled/
nginx -t  # test config
systemctl reload nginx
```

### 18.6 SSL với Let's Encrypt

```bash
# 1. Tạo cert (chỉ chạy lần đầu, sau khi DNS đã trỏ về VPS)
certbot --nginx -d pidentist.vn -d www.pidentist.vn \
  --email tranquocdat147@gmail.com \
  --agree-tos \
  --redirect \
  --hsts \
  --staple-ocsp

# 2. Auto-renewal (Certbot tự setup cron)
systemctl status certbot.timer

# 3. Test renewal (dry-run)
certbot renew --dry-run

# Kết quả: cert lưu ở /etc/letsencrypt/live/pidentist.vn/
# Auto-renew 60 ngày trước expire
```

### 18.7 MariaDB setup

```bash
mysql -u root -p

# Trong MariaDB shell:
CREATE DATABASE pidentist_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'pidentist_wp'@'localhost' IDENTIFIED BY '<strong_random_password>';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, INDEX, REFERENCES 
  ON pidentist_db.* TO 'pidentist_wp'@'localhost';

CREATE USER 'pidentist_backup'@'localhost' IDENTIFIED BY '<another_password>';
GRANT SELECT, LOCK TABLES, SHOW VIEW, EVENT, TRIGGER 
  ON pidentist_db.* TO 'pidentist_backup'@'localhost';

FLUSH PRIVILEGES;
EXIT;
```

**File: `/etc/mysql/mariadb.conf.d/60-pi.cnf`** (tuning)

```ini
[mysqld]
# Buffer pool — 50% RAM cho DB-heavy site
innodb_buffer_pool_size = 512M
innodb_log_file_size = 64M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT

# Connections
max_connections = 100
thread_cache_size = 8

# Query cache (MariaDB only — MySQL 8.0 đã bỏ)
query_cache_type = 1
query_cache_size = 32M
query_cache_limit = 2M

# Tmp tables
tmp_table_size = 64M
max_heap_table_size = 64M

# Slow query log
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2

# Charset
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
```

```bash
systemctl restart mariadb
```

### 18.8 WordPress installation

```bash
# 1. SSH với user deploy
ssh deploy@<VPS_IP>
sudo -u www-data bash

# 2. Download WP core
cd /var/www/pidentist.vn/public
wp core download --locale=vi

# 3. Tạo wp-config.php
wp config create \
  --dbname=pidentist_db \
  --dbuser=pidentist_wp \
  --dbpass='<password>' \
  --dbhost=localhost \
  --dbprefix=pi_ \
  --locale=vi \
  --extra-php <<PHP
define( 'WP_DEBUG', false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'FORCE_SSL_ADMIN', true );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 30 );
define( 'DISABLE_WP_CRON', true );
define( 'WP_REDIS_HOST', '127.0.0.1' );
define( 'WP_REDIS_PORT', 6379 );
define( 'WP_CACHE_KEY_SALT', 'pidentist_' );
PHP

# 4. Generate fresh salts
wp config shuffle-salts

# 5. Install WP
wp core install \
  --url='https://pidentist.vn' \
  --title='Pi Dentist — Phòng khám Chỉnh nha Cao cấp' \
  --admin_user='piadmin' \
  --admin_password='<strong_password>' \
  --admin_email='tranquocdat147@gmail.com' \
  --skip-email

# 6. Cài GeneratePress + child theme
wp theme install generatepress --activate

# Clone child theme từ git
cd wp-content/themes
git clone https://github.com/updental/pidentist.git
wp theme activate pidentist

# 7. Cài plugins
wp plugin install \
  custom-post-type-ui \
  seo-by-rank-math \
  fluentform \
  litespeed-cache \
  redis-cache \
  nginx-helper \
  wordfence \
  updraftplus \
  wps-hide-login \
  --activate

# 8. Configure Redis Object Cache
wp redis enable

# 9. Set permalinks
wp rewrite structure '/%postname%/'
wp rewrite flush

# 10. Create essential pages
wp post create --post_type=page --post_title='Trang chủ' --post_status=publish
wp post create --post_type=page --post_title='Về Pi Dentist' --post_status=publish --post_name='ve-pi'
wp post create --post_type=page --post_title='Đặt lịch tư vấn' --post_status=publish --post_name='dat-lich'
wp post create --post_type=page --post_title='Liên hệ' --post_status=publish --post_name='lien-he'
wp post create --post_type=page --post_title='Giá niềng răng' --post_status=publish --post_name='gia-nieng-rang'
wp post create --post_type=page --post_title='Khoảnh khắc Pi' --post_status=publish --post_name='khoanh-khac-pi'

# Set front page
wp option update show_on_front 'page'
wp option update page_on_front $(wp post list --post_type=page --name='trang-chu' --field=ID)

# 11. Setup system cron cho WP
crontab -e -u www-data
# Thêm:
*/5 * * * * /usr/bin/curl -s https://pidentist.vn/wp-cron.php?doing_wp_cron > /dev/null 2>&1
```

### 18.9 Deploy script (subsequent updates)

**File: `deploy/deploy.sh`** (chạy local hoặc CI/CD)

```bash
#!/bin/bash
# Pi Dentist — Deploy script
# Usage: ./deploy/deploy.sh production

set -e

ENV=${1:-production}
SSH_HOST="deploy@pidentist.vn"
REMOTE_THEME_PATH="/var/www/pidentist.vn/public/wp-content/themes/pidentist"
REMOTE_WP_PATH="/var/www/pidentist.vn/public"

echo "=== Deploy to $ENV ==="

# 1. Run tests local trước
echo "→ Running PHP syntax check..."
find child-theme -name "*.php" -exec php -l {} \;

# 2. Confirm
read -p "Deploy to $ENV? (y/N) " confirm
[[ $confirm != "y" ]] && exit 0

# 3. Push to git
echo "→ Pushing to git..."
git push origin main

# 4. SSH and pull on server
echo "→ SSH deploy..."
ssh $SSH_HOST << ENDSSH
  set -e
  cd $REMOTE_THEME_PATH
  
  # Backup current state
  git tag deploy-\$(date +%Y%m%d-%H%M%S)
  
  # Pull latest
  git fetch origin
  git reset --hard origin/main
  
  # Clear caches
  cd $REMOTE_WP_PATH
  wp cache flush
  wp transient delete --all
  
  # Clear LiteSpeed cache
  wp litespeed-purge all
  
  # Clear Nginx FastCGI cache
  rm -rf /var/cache/nginx/pidentist/*
  
  # Reload services
  sudo systemctl reload php8.2-fpm
  sudo systemctl reload nginx
  
  echo "✓ Deploy complete"
ENDSSH

# 5. Smoke test
echo "→ Smoke test..."
curl -sI https://pidentist.vn | head -1
curl -s https://pidentist.vn/wp-json/ | head -100

echo "=== Deploy success ==="
```

### 18.10 Cloudflare DNS cutover

**Lần đầu go-live:**

```
1. Đăng ký Cloudflare account (free plan)
2. Add site: pidentist.vn
3. Cloudflare scan DNS records hiện tại
4. Tại registrar (Namecheap/GoDaddy/PA Vietnam):
   Đổi nameservers sang:
   - lia.ns.cloudflare.com
   - rick.ns.cloudflare.com
   (giá trị cụ thể Cloudflare cung cấp)
5. Đợi 1-24h propagate
6. Trong Cloudflare → DNS:
   A    @    <VPS_IP>    Proxied (orange cloud)
   A    www  <VPS_IP>    Proxied
7. Configure SSL/TLS, Cache, Page Rules (xem section 14.8)
```

**Migration từ site cũ (nếu có):**

```
1. Build Pi Dentist trên domain staging.pidentist.vn
2. Test kỹ trên staging
3. Trong Cloudflare → tạm bật "Development Mode" 3h (bypass cache)
4. Đổi A record main domain
5. Test trên main domain
6. Tắt Development Mode
7. Submit sitemap mới lên Google Search Console
8. 301 redirect URL cũ → URL mới (tại Nginx)
```

### 18.11 Monitoring

| Tool | Mục đích | Free tier |
|------|----------|-----------|
| UptimeRobot | Uptime check 5 phút/lần | 50 monitors free |
| Cloudflare Analytics | Traffic, bot, CDN cache hit ratio | Free |
| Google Search Console | SEO traffic, indexing | Free |
| Google Analytics 4 | User behavior | Free |
| Sentry / Bugsnag | PHP error tracking | Free 5K errors/month |
| Better Stack (Logtail) | Log aggregation | Free 1GB/month |
| Grafana + Netdata (self-hosted) | Server metrics | Free, cài trên VPS |

**Setup UptimeRobot:**
- Monitor 1: `https://pidentist.vn/` (HTTP keyword check "Pi Dentist")
- Monitor 2: `https://pidentist.vn/wp-admin/admin-ajax.php?action=heartbeat` (WP cron alive)
- Alert: Email + Telegram (free integration)

### 18.12 Pre-launch checklist

```
SERVER:
✅ Ubuntu 22.04 LTS, latest patches
✅ Firewall (UFW) chỉ mở 22, 80, 443
✅ SSH chỉ public key, root login disabled
✅ Fail2ban active
✅ Timezone Asia/Ho_Chi_Minh
✅ NTP sync

WEB:
✅ Nginx 1.24+, PHP 8.2, MariaDB 10.11, Redis 7
✅ HTTPS Let's Encrypt cert active, auto-renew working
✅ HTTP → HTTPS redirect
✅ WWW → non-WWW redirect (hoặc ngược lại — nhất quán)
✅ HSTS enabled (sau 1 tháng test thì bật preload)
✅ HTTP/2 enabled

WORDPRESS:
✅ Latest stable version
✅ Vietnamese locale
✅ DB prefix đổi từ wp_ → pi_
✅ Auth keys/salts unique
✅ DISALLOW_FILE_EDIT, FORCE_SSL_ADMIN
✅ DISABLE_WP_CRON + system cron
✅ Permalinks /%postname%/
✅ Admin user KHÔNG dùng "admin"
✅ Strong password admin (min 16 chars)
✅ 2FA bắt buộc (Wordfence)

PERFORMANCE:
✅ LiteSpeed Cache configured
✅ Redis Object Cache active
✅ Nginx FastCGI cache active
✅ OPcache + JIT enabled
✅ Cloudflare proxy ON, SSL Full Strict
✅ PageSpeed Insights mobile ≥ 85
✅ LCP < 2.5s, CLS < 0.1

SECURITY:
✅ Wordfence Free + 2FA
✅ Login URL renamed
✅ XML-RPC disabled
✅ User enumeration blocked
✅ REST API users endpoint disabled
✅ Security headers all set
✅ File permissions 755/644, wp-config 600
✅ DB user least privilege

BACKUP:
✅ UpdraftPlus → Google Drive (daily DB, weekly files)
✅ VPS snapshot weekly
✅ Test restore thành công
✅ DB dump cron sang VPS thứ 2

CONTENT:
✅ Tất cả 12 trang chính có content
✅ ≥ 5 service entries
✅ ≥ 3 doctor entries  
✅ ≥ 5 case studies
✅ ≥ 10 blog posts
✅ Footer info đúng (số ĐT, địa chỉ, MXH)
✅ Privacy Policy, Terms pages có nội dung
✅ Favicon + logo set qua Customizer

SEO:
✅ Rank Math setup wizard hoàn tất
✅ XML sitemap accessible: /sitemap_index.xml
✅ robots.txt đúng
✅ Schema LocalBusiness validated
✅ Google Search Console verified + sitemap submitted
✅ Google Analytics 4 tracking
✅ Open Graph + Twitter Cards test

FORM:
✅ Form đặt lịch test gửi → email đến đúng
✅ Auto-reply khách hoạt động
✅ reCAPTCHA active
✅ Honeypot active

LEGAL:
✅ Privacy Policy có sẵn
✅ Cookie consent banner (nếu target EU traffic)
✅ Đăng ký Bộ Công Thương (nếu là doanh nghiệp VN)
✅ Disclaimer y khoa: "Kết quả điều trị có thể khác nhau"

MONITORING:
✅ UptimeRobot active 2 monitors
✅ Cloudflare Analytics linked
✅ Google Search Console + GA4 tracking
✅ Email alert chuyển đến Đạt + admin
```

---

## 19. WORKFLOW QUẢN TRỊ NỘI DUNG

> **Mục tiêu:** Đạt và team marketing có thể tự cập nhật website hằng ngày mà không cần hỏi developer. Section này là "user manual" cho admin.

### 19.1 Sơ đồ tổng thể quy trình

```
┌────────────────────────────────────────────────────────────────┐
│                      AI / MARKETING TEAM                        │
│  Tạo nội dung (text, ảnh, idea) → Đẩy cho admin web nhập liệu  │
└──────────────────────────┬─────────────────────────────────────┘
                           │
                           ▼
┌────────────────────────────────────────────────────────────────┐
│                    ADMIN WEBSITE (cấp Editor+)                  │
│  Login WP Admin → tạo CPT entry / page / post                  │
│  → Block Editor → soạn nội dung qua Block Pattern              │
│  → Preview → Publish                                           │
└──────────────────────────┬─────────────────────────────────────┘
                           │
                           ▼
┌────────────────────────────────────────────────────────────────┐
│                  AUTO PUBLISH + CACHE PURGE                     │
│  WP fire hooks → Rank Math sinh meta → LiteSpeed purge cache   │
│  → Cloudflare purge → Site live trong 1-2 phút                 │
└────────────────────────────────────────────────────────────────┘
```

### 19.2 User roles & permissions

| Role | Có thể làm gì | Không làm được |
|------|--------------|----------------|
| Administrator | Tất cả: code, plugin, theme, user | (không hạn chế) |
| Editor | Quản lý mọi post/page/CPT, comment | Cài plugin, đổi theme, sửa user |
| Author | Tạo/sửa post của mình, upload media | Sửa post người khác, manage CPT |
| Contributor | Viết draft, không publish | Upload media, publish |
| Subscriber | Chỉ profile cá nhân | (gần như không có quyền) |
| Pi Marketing (custom) | Như Editor + truy cập Fluent Forms entries | Sửa theme, cài plugin |

**Tạo role custom `pi_marketing`:**

**File: `inc/roles.php`**

```php
<?php
/**
 * Pi Dentist — Custom roles
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'pi_register_custom_roles' );
function pi_register_custom_roles() {
    // Chạy 1 lần (theo flag option)
    if ( get_option( 'pi_roles_registered_v1' ) ) {
        return;
    }
    
    // Clone Editor + thêm capabilities
    $editor = get_role( 'editor' );
    if ( ! $editor ) return;
    
    add_role(
        'pi_marketing',
        'Pi Marketing',
        $editor->capabilities
    );
    
    $marketing = get_role( 'pi_marketing' );
    
    // Quyền Fluent Forms
    $marketing->add_cap( 'fluentform_view_forms' );
    $marketing->add_cap( 'fluentform_view_form_entries' );
    $marketing->add_cap( 'fluentform_export_forms' );
    
    // Quyền CPT custom
    foreach ( [ 'pi_service', 'pi_doctor', 'pi_case' ] as $cpt ) {
        $marketing->add_cap( "edit_{$cpt}s" );
        $marketing->add_cap( "edit_published_{$cpt}s" );
        $marketing->add_cap( "publish_{$cpt}s" );
        $marketing->add_cap( "delete_{$cpt}s" );
        $marketing->add_cap( "delete_published_{$cpt}s" );
    }
    
    update_option( 'pi_roles_registered_v1', true );
}
```

### 19.3 Workflow 1: Thêm dịch vụ niềng răng mới

**Tình huống:** Pi Dentist muốn thêm dịch vụ "Niềng răng trong suốt Spark" mới ra mắt.

**Các bước:**

```
1. Login WP Admin → Dịch vụ → Thêm mới

2. Tiêu đề: "Niềng răng trong suốt Spark"

3. Permalink: /dich-vu/nieng-rang-spark/  (auto-generated, có thể edit)

4. Nội dung (Block Editor):
   → Click "+" → search "Pi" → các Block Pattern Pi hiện ra
   → Có thể chèn template service-detail có sẵn (Pattern: pi/service-detail)
   → Hoặc tự build với các block native
   
   Cấu trúc đề xuất:
   ┌──────────────────────────────┐
   │ Heading H2: Tổng quan         │
   │ Paragraph: Giới thiệu...      │
   │ Image: Ảnh minh họa            │
   │ Heading H2: Quy trình điều trị│
   │ Pattern: pi/journey-timeline  │ ← chèn pattern timeline
   │ Heading H2: Trước & sau        │
   │ Gallery: Ảnh case              │
   │ Heading H2: Câu hỏi thường gặp│
   │ Block: details (FAQ accordion)│
   └──────────────────────────────┘

5. Sidebar (right):
   → Featured Image: upload ảnh đại diện 1200x800px
   → Categories (pi_service_category): "Niềng trong suốt"
   → Excerpt: 2-3 dòng tóm tắt (sẽ hiển thị ở archive)

6. Meta box "Service Details" (custom):
   → price_from: 35000000
   → price_to: 90000000
   → duration_min_months: 12
   → duration_max_months: 24
   → service_icon: spark-icon  (chọn từ dropdown)
   → highlights: ["Vô hình hoàn toàn", "Tháo lắp linh hoạt", "Thoải mái"]
   → pros: liệt kê dấu cộng
   → cons: liệt kê dấu trừ (lưu ý)
   → faq: bảng câu hỏi-trả lời
   → cta_text: "Đặt lịch tư vấn miễn phí"
   → cta_url: /dat-lich/?service=spark

7. Sidebar (right) tiếp:
   → Rank Math SEO: Focus keyword "niềng răng spark"
     ✅ Rank Math gợi ý cải thiện title, meta, density
   → Schema: tự động sinh DentalProcedure schema

8. Click "Preview" → mở tab mới → kiểm tra
   ✅ Hiển thị đúng layout
   ✅ Ảnh load được
   ✅ Mobile responsive OK

9. Click "Publish" → site live ngay
   ✅ LiteSpeed tự purge cache archive /dich-vu/
   ✅ Service mới xuất hiện trong grid 4 cột trên homepage (nếu set is_featured)
```

**Thời gian:** 15-30 phút cho dịch vụ mới đầy đủ thông tin.

### 19.4 Workflow 2: Đăng bài blog "Khoảnh khắc Pi"

**Tình huống:** Đăng case study "Khách hàng A — Niềng răng hô vẩu sau 18 tháng".

**Các bước:**

```
1. WP Admin → Bài viết → Thêm mới

2. Tiêu đề: "Hành trình 18 tháng — Chị Linh từ răng hô vẩu đến nụ cười tự tin"

3. Permalink: /kien-thuc/hanh-trinh-18-thang-chi-linh/

4. Block Editor:
   → Pattern: pi/case-study-template (nếu đã tạo sẵn)
   → Cấu trúc:
     - Heading H2: Trước khi điều trị
     - Image: ảnh trước (kèm caption)
     - Paragraph: Mô tả tình trạng
     - Heading H2: Phương pháp lựa chọn
     - Block quote: Lời bác sĩ
     - Heading H2: Quá trình
     - Gallery: Ảnh từng tháng
     - Heading H2: Kết quả
     - Image: ảnh sau (compare)
     - Pattern: pi/cta-booking (synced) ← chèn CTA cuối bài

5. Sidebar:
   → Featured Image: ảnh đại diện 1200x630
   → Categories: "Khoảnh khắc Pi"
   → Tags: "niềng-răng-hô", "case-thực-tế", "18-tháng"
   → Excerpt: 1-2 câu hook

6. Rank Math SEO:
   → Focus keyword: "niềng răng hô vẩu"
   → Title tag: tự động hoặc edit thủ công
   → Meta description: 150-160 ký tự, có CTA

7. Publish ngay hoặc Schedule:
   → Schedule cho 9:00 sáng thứ 3 (giờ vàng cho dental traffic)

8. Sau publish:
   → Auto share Facebook (nếu kết nối Jetpack/Buffer)
   → Pin post lên top archive 1 tuần (tick "Sticky")
```

### 19.5 Workflow 3: Cập nhật giá / khuyến mãi

**Tình huống:** Pi Dentist tung khuyến mãi "Niềng kim loại giảm 5 triệu trong tháng 12".

**Cách 1 — Sửa Synced Pattern `pi-promo-banner`:**

```
1. WP Admin → Khối có thể sử dụng (Synced Patterns) → "Pi Promo Banner"
2. Edit: thay text:
   "🎉 Khuyến mãi tháng 12: Niềng răng kim loại giảm 5 triệu — Chỉ còn 25 triệu"
3. Update
   → Tất cả các trang có chèn Pattern này tự động update
   → Cache purge
```

**Cách 2 — Sửa giá trên service entry:**

```
1. WP Admin → Dịch vụ → "Niềng răng mắc cài kim loại"
2. Meta box "Service Details":
   → price_from: 25000000  (thay từ 30000000)
3. Update
   → Bảng giá ở archive /dich-vu/ tự update
   → Service card trên homepage tự update
```

**Cách 3 — Thêm banner promo lên header (qua Customizer):**

```
1. WP Admin → Giao diện → Customize → Pi Dentist Settings
2. "Promo Banner Text": "🎉 Khuyến mãi tháng 12 - Click để xem"
3. "Promo Banner URL": /khuyen-mai-thang-12/
4. "Promo Banner Active": ✅
5. Save & Publish
   → Banner hiện trên đỉnh mọi page (qua hook generate_before_header)
```

### 19.6 Workflow 4: Edit homepage qua Block Pattern

**Tình huống:** Đạt muốn đổi tagline hero từ "Niềng răng cao cấp" sang "Niềng răng đẳng cấp Pi" và thay ảnh hero.

**Các bước:**

```
1. WP Admin → Trang → Trang chủ → Edit

2. Block Editor mở ra với toàn bộ homepage là một sequence Block Patterns:
   ┌─────────────────────────────────┐
   │ ▶ Pi Hero Banner               │ ← click vào pattern này
   │ ▶ Pi Commitments               │
   │ ▶ Pi Philosophy                │
   │ ▶ Pi Doctors Carousel          │
   │ ▶ Pi Technology (Synced)       │
   │ ▶ Pi Services Grid             │
   │ ▶ Pi Simulation CTA            │
   │ ▶ Pi Journey Timeline          │
   │ ▶ Pi Pricing Table             │
   │ ▶ Pi Knowledge Blog            │
   │ ▶ Pi CTA Booking (Synced)      │
   └─────────────────────────────────┘

3. Click "Pi Hero Banner" → khi click vào pattern, các block bên trong
   xuất hiện trong list:
   - Heading: "Niềng răng cao cấp"  ← click vào, edit text inline
   - Paragraph subtitle
   - Buttons group
   - Image background
   
4. Edit heading: "Niềng răng đẳng cấp Pi"

5. Click vào Image → Replace → upload ảnh mới
   → Đảm bảo ảnh 1920x1080, < 500KB, định dạng JPG/WebP

6. Click "Update" góc phải trên
   → Cache purge
   → Site live ngay
```

> **Quan trọng:** Pattern là "stamp" — khi insert đã copy code vào page. Sửa Pattern không sửa các page đã insert. Nếu muốn sửa hàng loạt, dùng Synced Pattern.

### 19.7 Workflow 5: Quản lý booking submissions

**Tình huống:** Khách điền form đặt lịch — team sales cần lấy thông tin gọi lại.

**Các bước:**

```
1. WP Admin → Fluent Forms → All Forms → "Đặt lịch tư vấn"

2. Tab "Entries":
   ┌─────────────────────────────────────────────────────────┐
   │ ID │ Họ tên   │ SĐT      │ Dịch vụ      │ Time      │ Status   │
   ├────┼──────────┼──────────┼──────────────┼───────────┼──────────┤
   │ 23 │ Nguyễn A │ 09xxxxx  │ Niềng kim    │ 3h trước  │ ⚪ Mới   │
   │ 22 │ Trần B   │ 09xxxxx  │ Spark        │ Hôm qua   │ 🟢 Đã GọI│
   │ 21 │ Lê C     │ 09xxxxx  │ Mắc cài sứ   │ 2 ngày    │ 🔵 Booked│
   └────┴──────────┴──────────┴──────────────┴───────────┴──────────┘

3. Click vào entry → mở chi tiết:
   - Họ tên, SĐT, Email, Dịch vụ quan tâm
   - Thời gian mong muốn
   - Tin nhắn thêm
   - Source (UTM nếu có)
   - IP, User Agent (cho fraud detection)

4. Sales action:
   → Click "Mark as Read" sau khi đọc
   → Add note: "Đã gọi lúc 14:30, hẹn 16/12 19h"
   → Update status: Mới → Đã gọi → Đặt lịch → Hoàn tất
   → Export CSV cuối tuần báo cáo

5. Filter:
   → Theo dịch vụ: chỉ hiện Spark
   → Theo status: chỉ hiện chưa gọi
   → Theo ngày: tuần này
   → Search: theo tên/SĐT
```

**Email tự động:**
- Khi có booking mới → Email đến `sales@pidentist.vn` (group inbox)
- Đồng thời SMS đến số trực sales (qua Twilio v2)
- Auto-reply email cho khách: "Chúng tôi đã nhận yêu cầu, sẽ gọi lại trong 30 phút"

**Sync Google Sheets (v2):**
- Fluent Forms → Settings → Integrations → Google Sheets
- Mỗi entry → 1 row trong sheet "Bookings 2025"
- Team sales theo dõi sheet thay vì vào WP Admin
- Có thể filter, sort, share view

### 19.8 Workflow 6: SEO publishing checklist

Mỗi khi publish 1 page/post mới, admin theo checklist sau:

```
✅ TRƯỚC KHI VIẾT
  □ Research keyword: search volume, competition (qua Rank Math AI)
  □ Outline: H1 → H2 → H3 hierarchy
  □ Internal link plan: link đến 2-3 trang/post liên quan đã có

✅ KHI VIẾT
  □ Title: chứa focus keyword, < 60 ký tự
  □ Slug: ngắn, chứa keyword, không dấu
  □ H1 đúng 1 lần (chính title)
  □ H2-H3 cấu trúc logic
  □ Đoạn mở đầu chứa focus keyword trong 100 từ đầu
  □ Image: alt text mô tả + chứa keyword (1-2 ảnh)
  □ Internal link: ≥ 2 link sang trang nội bộ
  □ External link: ≥ 1 link sang nguồn uy tín (NIH, ADA, JADA...)
  □ CTA cuối bài: "Đặt lịch" hoặc "Liên hệ"

✅ RANK MATH CHECK
  □ Rank Math score ≥ 80/100 (target 90+)
  □ Focus keyword set
  □ Meta description: 140-160 ký tự, hấp dẫn, có CTA
  □ Social: OG image preview đúng (1200x630)
  □ Schema: đã có schema phù hợp (Article/Service/Doctor)

✅ TECHNICAL
  □ Mobile preview render OK
  □ Tốc độ load: PageSpeed ≥ 85 mobile
  □ Không có lỗi console
  □ All images có lazy load + WebP

✅ AFTER PUBLISH
  □ Submit URL Google Search Console (Inspect → Request Indexing)
  □ Share Facebook page
  □ Internal share team Slack/Zalo
  □ Track: GA4 → 24h sau check pageviews
```

### 19.9 Editor onboarding (cho người mới)

**Document hướng dẫn cho Editor mới (1-2 ngày training):**

```
DAY 1 — WP BASICS (4h)
- WordPress là gì, vai trò editor
- Login flow + 2FA
- Dashboard tour
- Khái niệm: Post, Page, Custom Post Type, Media, Categories, Tags
- Block Editor cơ bản: 10 block phổ biến
- Cách upload, optimize ảnh
- Permalink, SEO slug

DAY 1 — PI DENTIST SPECIFIC (2h)
- Tour 12 trang chính
- 3 CPT: Service, Doctor, Case
- Block Pattern library (5 pattern chính)
- Synced Pattern (5 patterns)
- Workflow 1-6 (như trên)

DAY 2 — HANDS-ON (4h)
- Bài tập 1: Tạo 1 service mới với data giả
- Bài tập 2: Đăng 1 blog post 800 từ với SEO check
- Bài tập 3: Update giá qua Synced Pattern
- Bài tập 4: Xử lý 5 booking submissions giả lập
- Q&A

DAY 2 — ADVANCED (2h)  
- Rank Math deeper
- Fluent Forms entries management
- Image optimization workflow
- Khi nào hỏi developer (technical issue checklist)
```

### 19.10 Hỏi/đáp thường gặp

| Q | A |
|---|---|
| Site đang chậm sau khi publish | Vào LiteSpeed Cache → Toolbox → Purge All |
| Ảnh upload bị lỗi "exceeded max" | Tăng `upload_max_filesize` trong php.ini hoặc resize ảnh |
| Block Editor đứng | Hard reload (Ctrl+Shift+R), tắt extension Chrome lạ |
| Quên mật khẩu Admin | "Lost password" → email reset, hoặc SSH `wp user update <id> --user_pass=<new>` |
| Edit page nhưng không thấy thay đổi | Chưa Update? Cache browser? → Ctrl+Shift+R |
| Một section trên homepage biến mất | Edit Trang chủ → kiểm tra Block Pattern còn không, undo nếu cần |
| Form submit không gửi mail | Check Fluent Forms → Settings → Email Settings; test SMTP |
| Rank Math báo "Schema error" | Mở Schema tab → kiểm tra trường missing (location, hours...) |
| Site bị deface | Liên hệ developer NGAY, đừng tự xử |
| Plugin update làm hỏng | Quay lại bản cũ qua FTP/SSH, hoặc UpdraftPlus restore |

### 19.11 Maintenance content (định kỳ)

| Tần suất | Việc | Người phụ trách |
|----------|------|-----------------|
| Hàng ngày | Check booking submissions | Sales team |
| Hàng ngày | Reply comment blog (nếu có) | Marketing |
| Hàng tuần | Đăng 1-2 blog post | Content writer |
| Hàng tuần | Rotate hero ảnh nếu cần fresh | Marketing |
| Hàng tháng | Update giá nếu có thay đổi | Đạt + Marketing |
| Hàng tháng | Audit Rank Math: post nào score < 80? | SEO lead |
| Hàng tháng | Add 1-2 case study mới | Marketing + bác sĩ |
| Hàng quý | Review service descriptions | Đạt + bác sĩ |
| Hàng quý | Update đội ngũ bác sĩ (thêm/sửa) | HR + Đạt |
| Hàng quý | Audit toàn site UX (user testing 5 người) | Marketing |

---

## 20. MAINTENANCE & MIGRATION

### 20.1 Monthly health check

Mỗi đầu tháng, chạy checklist:

```bash
# === SERVER HEALTH ===
□ Uptime VPS: ≥ 99.9% tháng trước (kiểm tra UptimeRobot)
□ Disk usage: < 70% (nếu cao, chạy cleanup)
   df -h
□ RAM usage trung bình: < 80%
   free -h
□ CPU load: < 1.5 trên 1 vCPU
   uptime
□ Nginx error log: < 100 errors/tháng
   tail -1000 /var/log/nginx/error.log | grep -i error | wc -l
□ PHP slow log: review query > 5s
   cat /var/log/php8.2-slow.log
□ MySQL slow query log: tối ưu query > 2s
   mysqldumpslow /var/log/mysql/slow.log

# === WORDPRESS HEALTH ===
□ WP Admin → Site Health: tất cả Critical = 0, Recommended < 5
□ WP version: latest (tự auto-update minor, manual major)
□ Theme version: latest GeneratePress
□ Plugins: tất cả update mới nhất
   wp plugin list --update=available
□ Wordfence scan: 0 critical issues
□ Database optimize:
   wp db optimize
   wp db check
□ Transient cleanup:
   wp transient delete --all
□ Spam comments: empty
   wp comment delete $(wp comment list --status=spam --format=ids)
□ Trash: empty
   wp post delete $(wp post list --post_status=trash --format=ids) --force

# === SECURITY AUDIT ===
□ User accounts: chỉ người còn làm
   wp user list --role=administrator
□ Failed login attempts trong tháng: < 1000 (nếu cao, tăng rate limit)
□ Wordfence Live Traffic: kiểm tra suspicious IP
□ SSL cert: còn ≥ 30 ngày
   echo | openssl s_client -servername pidentist.vn -connect pidentist.vn:443 2>/dev/null | openssl x509 -noout -dates

# === BACKUP ===
□ UpdraftPlus: 30 backup gần nhất đều thành công
□ Test restore staging: thành công < 30 phút
□ Google Drive dung lượng: < 80% sử dụng

# === PERFORMANCE ===
□ PageSpeed Insights mobile: ≥ 85
□ LCP < 2.5s, INP < 200ms, CLS < 0.1
□ Cloudflare cache hit ratio: > 80%
□ LiteSpeed cache hit ratio: > 70%

# === SEO ===
□ Google Search Console: errors = 0
□ Sitemap: lastmod cập nhật
□ Index coverage: tất cả trang quan trọng đã indexed
□ Top 10 queries: rank trend
□ Manual actions: 0
□ Page Experience: Good

# === ANALYTICS ===
□ GA4: traffic so với tháng trước (tăng/giảm/why)
□ Top 10 pages: nội dung phù hợp?
□ Bounce rate: < 60% target
□ Conversion (form submit): tăng tháng/tháng?
```

### 20.2 Plugin update strategy

**Phân loại update:**

| Loại | Strategy | Frequency |
|------|----------|-----------|
| Security patches | Update NGAY, test sau | Real-time |
| Minor version | Auto-update OK | Weekly |
| Major version | Test staging trước, schedule deploy | Monthly |
| WP core minor | Auto-update | Real-time |
| WP core major | Manual sau 2 tuần (đợi cộng đồng test) | 6 months |

**Quy trình update major plugin:**

```bash
# 1. Backup full
wp updraft-plus backup --include-files --include-database

# 2. Sync production → staging
# (xem section 17.4)

# 3. Trên staging:
wp plugin update <plugin-slug>

# 4. Smoke test toàn site:
- Homepage render OK
- WP Admin login OK
- Block Editor mở OK
- Form submit OK
- Critical pages /dich-vu/, /bac-si/, blog OK

# 5. Nếu OK → schedule deploy production lúc traffic thấp (00:00-04:00)
# 6. Nếu lỗi → tìm cách downgrade hoặc tìm plugin thay thế

# 7. Sau update production:
wp cache flush
wp litespeed-purge all
# Test lại smoke 5 phút
```

### 20.3 Database maintenance

**Mỗi tháng:**

```bash
# Login MySQL
mysql -u root -p

USE pidentist_db;

-- Kiểm tra size từng table
SELECT 
  table_name, 
  ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)',
  table_rows
FROM information_schema.TABLES
WHERE table_schema = 'pidentist_db'
ORDER BY (data_length + index_length) DESC
LIMIT 20;

-- Tables thường lớn nhất:
-- pi_options (autoload phình)
-- pi_postmeta (revisions)
-- pi_actionscheduler_logs (action scheduler logs)
-- pi_wfblocks7 (Wordfence logs)

-- Cleanup autoload options không cần
SELECT option_name, length(option_value) AS size
FROM pi_options 
WHERE autoload = 'yes' 
ORDER BY size DESC 
LIMIT 20;
-- Identify suspicious large options → tắt autoload:
-- UPDATE pi_options SET autoload = 'no' WHERE option_name = '<big_option>';

-- Optimize tables (defrag)
OPTIMIZE TABLE pi_posts, pi_postmeta, pi_options, pi_comments, pi_commentmeta;

EXIT;
```

**Hoặc chạy qua WP-CLI:**

```bash
wp db optimize
wp db check
wp db repair  # nếu có lỗi
```

### 20.4 Migration scenarios

#### 20.4.1 Đổi VPS provider (DigitalOcean → Vultr)

**Quy trình zero-downtime:**

```
1. Provision VPS mới ở Vultr (cùng spec)
2. Run provisioning script (section 18.3)
3. SSH vào VPS cũ → backup DB + uploads:
   wp db export migration.sql
   tar -czf uploads.tar.gz wp-content/uploads/
4. SCP sang VPS mới
5. Restore DB + uploads + clone child theme từ git
6. Cài plugins, restore wp-config.php
7. Test site qua IP trực tiếp / hosts file:
   echo "<NEW_VPS_IP> pidentist.vn" >> /etc/hosts
   # Browser test https://pidentist.vn → lúc này đi vào VPS mới
8. Sync incremental changes (rsync uploads, mysqldump diff)
9. Trong Cloudflare DNS → đổi A record → IP VPS mới
   - TTL trước đó đã giảm xuống 60s → propagate nhanh
10. Đợi 5-10 phút, monitor traffic shift
11. VPS cũ keep alive 1 tuần làm fallback, sau đó destroy
```

#### 20.4.2 All-in-One WP Migration tool (cho hosting nhỏ)

Plugin: [All-in-One WP Migration](https://wordpress.org/plugins/all-in-one-wp-migration/)

```
1. Cài plugin trên cả 2 site (cũ + mới)
2. Site cũ: All-in-One → Export → Export to File
   → Tạo file .wpress (chứa cả DB + files + plugins + theme)
3. Download file
4. Site mới (đã cài WP fresh): All-in-One → Import → Upload file
5. Plugin tự search/replace domain
6. Login lại với credentials cũ
```

> **Lưu ý:** Free version giới hạn 512MB. File > 512MB cần Premium ($69 lifetime) hoặc dùng cách thủ công (mysqldump + rsync).

#### 20.4.3 Đổi domain (`pidentist.vn` → `pidentistplus.vn`)

```bash
# 1. Backup full

# 2. Update WP options
wp option update siteurl 'https://pidentistplus.vn'
wp option update home 'https://pidentistplus.vn'

# 3. Search/replace toàn DB (an toàn với serialized)
wp search-replace 'https://pidentist.vn' 'https://pidentistplus.vn' --all-tables --skip-columns=guid
wp search-replace '//pidentist.vn' '//pidentistplus.vn' --all-tables --skip-columns=guid

# 4. Update Nginx server_name
sed -i 's/pidentist.vn/pidentistplus.vn/g' /etc/nginx/sites-available/pidentist.vn
mv /etc/nginx/sites-available/pidentist.vn /etc/nginx/sites-available/pidentistplus.vn
ln -sf /etc/nginx/sites-available/pidentistplus.vn /etc/nginx/sites-enabled/

# 5. Renew SSL với domain mới
certbot --nginx -d pidentistplus.vn -d www.pidentistplus.vn

# 6. 301 redirect domain cũ
# Thêm vhost cũ:
server {
    listen 443 ssl http2;
    server_name pidentist.vn www.pidentist.vn;
    # ... ssl config ...
    return 301 https://pidentistplus.vn$request_uri;
}

# 7. Cloudflare: setup site mới, hoặc update record
# 8. Google Search Console: add property mới + Change of Address tool
# 9. Update Schema, GA4, Pixel với domain mới
```

### 20.5 Disaster recovery drill

**Mỗi 6 tháng, diễn tập:**

```
Drill 1: "VPS bị xóa hoàn toàn"
  → Provision VPS mới + restore từ backup
  → Target: live trở lại trong 4 giờ
  → Document thực tế mất bao lâu, bottleneck ở đâu

Drill 2: "Database corrupt"
  → DROP DB + restore từ backup gần nhất
  → Target: < 1 giờ

Drill 3: "Hacker xóa toàn bộ posts"
  → Restore từ backup hôm trước (chỉ DB tables posts/postmeta)
  → Target: < 30 phút

Drill 4: "Mất Google Drive (account bị khoá)"
  → Có backup local PC?
  → Có backup VPS thứ 2?
  → Build lại từ git repo + manual content?
```

### 20.6 GDPR / Privacy compliance

**Yêu cầu:**

```
✅ Privacy Policy page có sẵn (link footer)
✅ Cookie consent banner (nếu phục vụ EU traffic)
✅ Data export tool (WP có sẵn: Tools → Export Personal Data)
✅ Data erasure tool (Tools → Erase Personal Data)
✅ Form có checkbox "Tôi đồng ý cho Pi Dentist liên hệ qua SĐT/email"
✅ Email lưu trữ encrypted (Fluent Forms + DB)
✅ Không track IP nếu user opt-out
✅ Cookie list:
  - wordpress_logged_in_* (admin only)
  - wp-settings-* (admin pref)
  - cf_bm (Cloudflare bot management)
  - _ga, _gid (GA4 — cần consent)
  - _fbp (FB Pixel — cần consent)
```

**Plugin gợi ý:** [Complianz GDPR](https://wordpress.org/plugins/complianz-gdpr/) (free tier ổn).

### 20.7 Documentation maintenance

**Tài liệu cần keep updated:**

```
docs/
├── PROJECT_SPEC_WP.md        ← bản này (review mỗi quý)
├── PROMPTS_WP.md             ← prompt history
├── DEPLOYMENT_LOG.md         ← log mỗi lần deploy production
├── BACKUP_RESTORE_LOG.md     ← log test restore monthly
├── INCIDENT_LOG.md           ← bug, hack, downtime
├── CONTENT_GUIDELINES.md     ← brand voice, tone, ảnh quy chuẩn
├── EDITOR_HANDBOOK.md        ← user manual cho marketing team
├── PERFORMANCE_REPORT.md     ← PageSpeed monthly
├── SEO_REPORT.md             ← rank tracking monthly
└── PASSWORD_VAULT.md         ← (encrypted, hoặc dùng 1Password/Bitwarden)
```

**Nguyên tắc:** Tài liệu sống trong git, mỗi update = commit + push. Đổi quan trọng → tag version.

---

## 21. TIMELINE TRIỂN KHAI

### 21.1 Tổng quan phân kỳ

Toàn bộ dự án Pi Dentist v1.0 dự kiến **10–15 ngày làm việc** (≈ 2-3 tuần thực tế nếu có gián đoạn). Chia thành 6 phase mapping với file `PROMPTS_WP.md`:

```
┌──────────────────────────────────────────────────────────────────┐
│ Phase 0: Setup       │ ▓▓                          │ 0.5-1 ngày  │
│ Phase 1: Templates   │   ▓▓▓▓                      │ 2-3 ngày    │
│ Phase 2: CPT         │       ▓▓                    │ 1-2 ngày    │
│ Phase 3: Patterns    │         ▓▓▓▓                │ 2-3 ngày    │
│ Phase 4: Plugins     │             ▓▓▓             │ 1-2 ngày    │
│ Phase 5: Deploy      │                ▓▓▓          │ 1-2 ngày    │
│ Phase 6: Polish/Go-live│                  ▓▓        │ 1 ngày      │
└──────────────────────────────────────────────────────────────────┘
   Day 1    3    5    7    9    11   13   15
```

### 21.2 Phase 0 — Setup local + child theme (0.5-1 ngày)

**Mục tiêu:** Có môi trường local chạy WordPress + GeneratePress + child theme `pidentist` skeleton.

**Output cụ thể:**

```
✅ LocalWP installed, site pidentist.local running
✅ WP latest, GeneratePress activated
✅ Child theme `pidentist` activated (chỉ có style.css + functions.php skeleton)
✅ Git repo updental/pidentist init, child theme symlink
✅ VS Code + extensions setup
✅ wp-config.php có WP_DEBUG = true
✅ Browse pidentist.local hiển thị "Hello World" trắng tinh GeneratePress default
```

**Liên kết PROMPTS_WP.md:**
- Prompt 0.1: Setup LocalWP + WP install
- Prompt 0.2: Tạo child theme skeleton
- Prompt 0.3: Init git + commit đầu tiên

**Acceptance criteria:**
- Truy cập `pidentist.local` không 500 error
- WP Admin login với `piadmin` / mật khẩu local
- `wp theme list` thấy `pidentist` active

---

### 21.3 Phase 1 — Convert `index.html` → templates (2-3 ngày)

**Mục tiêu:** Site local render giống index.html mock 95%, nhưng đã là WordPress thật (header.php, footer.php, page-templates).

**Output cụ thể:**

```
✅ assets/css/main.css (port từ <style> trong index.html, dùng CSS variables)
✅ assets/css/typography.css, components.css, sections/*.css
✅ assets/js/main.js, navigation.js, floating.js
✅ assets/fonts/ self-host Inter + Playfair Display
✅ inc/enqueue.php load CSS/JS theo trang
✅ header.php override GP với π logo + main nav
✅ footer.php với 4 cột + social + bottom credits
✅ front-page.php render the_content() (chuẩn bị cho Block Patterns Phase 3)
✅ inc/customizer.php với tất cả setting (phone, email, address, social, hours)
✅ inc/menus.php register 4 nav locations + Pi_Nav_Walker
✅ inc/floating-elements.php hook wp_footer render 3 floating
✅ inc/gp-hooks.php hook generate_before_header (promo banner)
✅ Trang chủ render được hero, footer, floating qua template
   (sections 2-10 chưa có vì chưa có Block Patterns — sẽ làm Phase 3)
```

**Liên kết PROMPTS_WP.md:**
- Prompt 1.1: Port CSS từ index.html → child theme
- Prompt 1.2: Port JS từ index.html
- Prompt 1.3: Self-host fonts
- Prompt 1.4: Tạo header.php với π logo + nav
- Prompt 1.5: Tạo footer.php
- Prompt 1.6: Customizer settings
- Prompt 1.7: Floating elements + GP hooks

**Acceptance criteria:**
- Browse pidentist.local: header + footer giống mock 95%
- Mobile responsive header (menu hamburger hoạt động)
- Footer hiển thị đúng số ĐT, email từ Customizer
- 3 floating buttons xuất hiện góc dưới phải
- PageSpeed mobile ≥ 80 (chưa optimize)

---

### 21.4 Phase 2 — Đăng ký CPT (1-2 ngày)

**Mục tiêu:** 3 CPT (`pi_service`, `pi_doctor`, `pi_case`) + 2 taxonomies + meta boxes hoạt động trong WP Admin.

**Output cụ thể:**

```
✅ inc/cpt.php: register pi_service, pi_doctor, pi_case (full args)
✅ inc/taxonomies.php: pi_service_category (hierarchical), pi_case_tag (flat)
✅ inc/meta-fields.php: register_post_meta cho tất cả meta fields
✅ inc/meta-boxes.php: render meta box truyền thống cho pi_service
   - Meta box "Service Details" với input cho price, duration, icon, highlights, pros, cons, faq, cta
✅ inc/meta-boxes-doctor.php: meta box cho pi_doctor (specialties, experience, certifications)
✅ inc/meta-boxes-case.php: meta box cho pi_case (before/after, treatment_method, duration_months)
✅ archive-pi_service.php template
✅ single-pi_service.php template
✅ archive-pi_doctor.php template
✅ single-pi_doctor.php template
✅ archive-pi_case.php template
✅ single-pi_case.php template
✅ template-parts/card/service-card.php
✅ template-parts/card/doctor-card.php
✅ template-parts/card/case-card.php
✅ Permalink flush: /dich-vu/, /bac-si/, /khoanh-khac-pi/ work
✅ Block Editor cho 3 CPT show_in_rest = true
```

**Liên kết PROMPTS_WP.md:**
- Prompt 2.1: Register 3 CPT
- Prompt 2.2: Register 2 taxonomies
- Prompt 2.3: Register post meta + meta boxes
- Prompt 2.4: Tạo archive templates
- Prompt 2.5: Tạo single templates
- Prompt 2.6: Tạo card template parts

**Acceptance criteria:**
- WP Admin sidebar có 3 menu: "Dịch vụ", "Bác sĩ", "Khoảnh khắc Pi"
- Tạo được 1 service test "Niềng kim loại" với meta fields, hiển thị trên `/dich-vu/`
- Tạo được 1 doctor test, hiển thị `/bac-si/`
- Tạo 1 case test, hiển thị `/khoanh-khac-pi/`
- Single page render đẹp (chưa có content thật)

**Seed data:** Sau Phase 2 nên seed 3-5 entries mỗi CPT (data fake) để test layout.

---

### 21.5 Phase 3 — Tạo Block Patterns (2-3 ngày)

**Mục tiêu:** 5 Block Patterns + 5 Synced Patterns ready, admin có thể compose homepage qua Block Editor.

**Output cụ thể:**

```
✅ inc/pattern-categories.php: 3 categories (pi-homepage, pi-sections, pi-cta)
✅ inc/block-patterns.php: register 5 Block Patterns
   - pi/hero-banner
   - pi/commitments (4 cột grid)
   - pi/philosophy (2 columns + π symbol)
   - pi/technology-navy (3 cards + ghost-white CTA)
   - pi/pricing-table (table 4 rows + installment box)
✅ inc/editor-config.php: add_editor_style + theme color palette + disable custom colors
✅ assets/css/editor.css: style cho Block Editor preview
✅ 5 Synced Patterns seed data (qua wp_insert_post post_type=wp_block):
   - Pi CTA Booking (form + heading)
   - Pi Pricing Comparison (table)
   - Pi Contact Info Block (số ĐT + giờ + địa chỉ)
   - Pi Business Hours
   - Pi Promo Banner
✅ Trang chủ compose qua Block Editor:
   - Insert pi/hero-banner
   - Insert pi/commitments
   - Insert pi/philosophy
   - Insert template-part doctors-carousel (lấy từ CPT pi_doctor)
   - Insert pi/technology-navy
   - Insert section services-grid (lấy từ CPT pi_service)
   - Insert pi/simulation-cta
   - Insert pi/journey-timeline
   - Insert pi/pricing-table
   - Insert section knowledge-blog (lấy từ posts)
   - Insert Synced Pattern: Pi CTA Booking
✅ Trang chủ render đầy đủ 11 sections + header + footer + floating
```

**Liên kết PROMPTS_WP.md:**
- Prompt 3.1: Pattern categories
- Prompt 3.2: Hero Banner pattern
- Prompt 3.3: Commitments pattern
- Prompt 3.4: Philosophy pattern
- Prompt 3.5: Technology Navy pattern
- Prompt 3.6: Pricing Table pattern
- Prompt 3.7: Synced Patterns seed (5 patterns)
- Prompt 3.8: Editor config + CSS
- Prompt 3.9: Compose homepage qua Block Editor

**Acceptance criteria:**
- Browse `pidentist.local` thấy 11 sections giống index.html mock
- Mobile + desktop responsive đúng
- Block Pattern hiển thị đúng trong Block Editor (preview match frontend)
- Sửa heading hero qua Block Editor → reflect ngay frontend
- Sửa Synced Pattern Pi CTA Booking → reflect ở mọi nơi đã insert
- PageSpeed mobile ≥ 75 (chưa cache)

---

### 21.6 Phase 4 — Plugin stack (1-2 ngày)

**Mục tiêu:** Tất cả plugin cần thiết installed + configured + tích hợp với child theme.

**Output cụ thể:**

```
✅ Custom Post Type UI: installed (fallback, không dùng v1.0)
✅ Rank Math: setup wizard hoàn tất
   - Setup Mode: Custom mode
   - Site type: LocalBusiness → Dentist
   - Logo + favicon
   - Social profiles
   - Sitemap enabled, all CPT included
   - Schema config: LocalBusiness site-wide, DentalProcedure cho pi_service
   - Local SEO with NAP
✅ Fluent Forms: form "Đặt lịch tư vấn" tạo xong
   - 9 fields theo spec section 13
   - 2 notifications (admin + auto-reply)
   - reCAPTCHA + honeypot
   - Embed shortcode trong CTA Booking pattern
✅ LiteSpeed Cache: configured đầy đủ (section 14.4)
✅ Redis Object Cache: connected, drop-in installed
✅ Nginx Helper: configured
✅ Wordfence: scan đầu tiên hoàn tất, 2FA bật cho admin
✅ UpdraftPlus: kết nối Google Drive, backup đầu tiên thành công
✅ WPS Hide Login: URL đổi thành /dang-nhap-pi/
✅ inc/security.php: hardening code applied
```

**Liên kết PROMPTS_WP.md:**
- Prompt 4.1: Cài plugin stack qua wp-cli
- Prompt 4.2: Cấu hình Rank Math (wizard + schema filters)
- Prompt 4.3: Tạo Fluent Forms "Đặt lịch tư vấn"
- Prompt 4.4: Cấu hình LiteSpeed Cache + Redis
- Prompt 4.5: Cấu hình Wordfence + 2FA
- Prompt 4.6: Cấu hình UpdraftPlus
- Prompt 4.7: Apply security hardening code

**Acceptance criteria:**
- Submit form đặt lịch test → email đến đúng inbox
- Auto-reply email đến địa chỉ submit
- Rank Math score trên homepage ≥ 85
- LiteSpeed Cache: hit ratio > 50% sau 1h test
- Backup đầu tiên có file trên Google Drive
- Wordfence dashboard: 0 critical issues
- Login URL `/dang-nhap-pi/` work, `/wp-login.php` redirect 404

---

### 21.7 Phase 5 — Deploy VPS (1-2 ngày)

**Mục tiêu:** Site live trên VPS production, domain trỏ qua Cloudflare, HTTPS active, smoke test pass.

**Output cụ thể:**

```
✅ VPS Vultr Tokyo provisioned, Ubuntu 22.04
✅ Provisioning script chạy thành công (Nginx, PHP 8.2, MariaDB, Redis, Fail2ban)
✅ Firewall UFW chỉ mở 22, 80, 443
✅ SSH key auth, root login disabled, deploy user created
✅ DB pidentist_db + 2 users (wp + backup)
✅ Nginx vhost cấu hình đầy đủ (FastCGI cache, security blocks, rate limit)
✅ PHP-FPM tuned (pm.max_children, OPcache + JIT)
✅ Redis cấu hình maxmemory + LRU
✅ SSL Let's Encrypt active, auto-renew test pass
✅ WP installed via wp-cli
✅ Child theme cloned từ git
✅ Plugins cài lại (giống local)
✅ DB import từ local (search/replace domain)
✅ Uploads sync từ local (rsync)
✅ Cloudflare DNS pointing, proxy ON
✅ Cloudflare SSL Full Strict, HSTS, page rules
✅ wp-config.php production: DISALLOW_FILE_EDIT, FORCE_SSL_ADMIN, fresh salts
✅ system cron cho wp-cron.php
✅ DB dump cron + rsync sang VPS thứ 2 (optional v1.5)
✅ UpdraftPlus reconnect Google Drive trên production
✅ UptimeRobot monitor active
```

**Liên kết PROMPTS_WP.md:**
- Prompt 5.1: Provision VPS (chạy 01-provision.sh)
- Prompt 5.2: Cấu hình Nginx vhost + SSL
- Prompt 5.3: Setup MariaDB + tuning
- Prompt 5.4: Cấu hình PHP-FPM + OPcache
- Prompt 5.5: Cấu hình Redis
- Prompt 5.6: Install WP + theme + plugins production
- Prompt 5.7: Migrate DB + uploads local → production
- Prompt 5.8: Setup Cloudflare
- Prompt 5.9: Setup monitoring

**Acceptance criteria:**
- `https://pidentist.vn` accessible với HTTPS valid
- WP Admin login work
- Site render đúng trên production (giống local)
- PageSpeed Insights production: mobile ≥ 85, desktop ≥ 95
- SSL Labs grade A
- Backup đầu tiên trên production thành công
- Đặt 1 booking test trên production → email đến đúng

---

### 21.8 Phase 6 — Polish + Go-live (1 ngày)

**Mục tiêu:** Site production sẵn sàng cho khách thật, content đầy đủ, marketing setup, monitoring active.

**Output cụ thể:**

```
✅ CONTENT SEED:
   - 5 services thật (đầy đủ meta, ảnh, FAQ)
   - 3 doctors thật (CV, ảnh chuyên nghiệp)
   - 5 case studies thật (before/after, story)
   - 10 blog posts đầu tiên (SEO optimized)
   - All static pages có content (Về Pi, Tuyển dụng, Liên hệ, Bảng giá, Privacy)
   
✅ SEO READY:
   - Sitemap submitted Google Search Console
   - Bing Webmaster Tools verified
   - Schema validated (Schema.org validator + Google Rich Results)
   - All Rank Math scores ≥ 80
   - Open Graph + Twitter Cards preview check
   
✅ MARKETING TRACKING:
   - Google Analytics 4 active (qua Rank Math hoặc Site Kit)
   - Facebook Pixel installed (qua Site Kit hoặc Pixel Insert plugin)
   - Google Tag Manager (optional)
   - GA4 events: form_submit, click_phone, click_zalo, scroll_depth_75
   
✅ LEGAL:
   - Privacy Policy có nội dung
   - Terms of Service
   - Cookie consent banner
   - Disclaimer y khoa: "Kết quả có thể khác nhau giữa các bệnh nhân"
   
✅ ACCESSIBILITY:
   - Lighthouse a11y ≥ 95
   - Keyboard navigation work
   - Skip-to-content link
   - Alt text tất cả ảnh
   - ARIA labels đúng
   
✅ FINAL TESTS:
   - Cross-browser: Chrome, Safari, Firefox, Edge
   - Cross-device: iOS Safari (iPhone 12+), Android Chrome (Samsung S22+)
   - Form submission từ 5 thiết bị khác nhau
   - 5 user testing (người ngoài) — average task completion < 2 phút
   
✅ TEAM TRAINING:
   - Editor handbook printed/PDF
   - Marketing team training session 4h
   - Sales team training Fluent Forms entries 1h
   - Backup recovery drill 1h
   
✅ LAUNCH:
   - Cloudflare Development Mode OFF
   - Maintenance mode OFF
   - Email blast announcement (existing customers)
   - Facebook post + organic
   - Soft-launch 24h, monitor closely
   - Full launch
```

**Liên kết PROMPTS_WP.md:**
- Prompt 6.1: Bulk import services (CSV → wp-cli)
- Prompt 6.2: Bulk import doctors  
- Prompt 6.3: Bulk import case studies
- Prompt 6.4: SEO final pass (rank-math review)
- Prompt 6.5: Marketing tracking setup
- Prompt 6.6: Legal pages content
- Prompt 6.7: Accessibility final audit
- Prompt 6.8: Cross-browser test + fix
- Prompt 6.9: Editor handbook generation
- Prompt 6.10: Go-live checklist

**Acceptance criteria:**
- Tất cả 12 trang chính có content thật
- ≥ 5 services, ≥ 3 doctors, ≥ 5 cases, ≥ 10 blog posts
- PageSpeed mobile ≥ 90, desktop ≥ 95
- Lighthouse: SEO 100, A11y ≥ 95, Best Practices ≥ 95, Performance ≥ 85
- Google Search Console: sitemap submitted, no errors
- Schema validator: 0 errors
- Form đặt lịch test thành công từ 5 thiết bị
- Marketing team self-service được sau training
- 5 user testing complete task < 2 phút

---

### 21.9 Risks & mitigation

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| GeneratePress update làm breakage | Trung bình | Cao | Test staging trước khi update production |
| LiteSpeed Cache xung đột plugin | Cao | Trung bình | Disable từng plugin để isolate, exclude path |
| Block Pattern markup không render đúng trên mobile | Cao | Cao | Test mobile-first ngay từ Phase 3 |
| Block Editor lag khi edit Pattern lớn | Trung bình | Thấp | Chia Pattern thành nhiều Pattern nhỏ |
| Cloudflare cache HTML stale | Cao | Cao | Page Rule "Bypass on Cookie", purge sau update |
| Form spam | Cao | Trung bình | reCAPTCHA v3 + honeypot + rate limit |
| Wordfence false positive block IP thật | Trung bình | Thấp | Whitelist Cloudflare IPs, monitor weekly |
| VPS down | Thấp | Rất cao | Snapshot weekly + UptimeRobot alert |
| Content team không quen Block Editor | Trung bình | Trung bình | Training 4h + Editor Handbook |
| SEO migration ảnh hưởng rank (nếu đổi domain) | Trung bình | Cao | 301 redirect đầy đủ + Search Console Change of Address |
| Backup fail nhưng không phát hiện | Trung bình | Rất cao | Test restore monthly + email alert nếu fail |

### 21.10 Sau v1.0 — Roadmap v1.5 / v2.0

**v1.5 (3-6 tháng sau go-live):**

```
□ Booking app: lịch hẹn online thực sự (chọn ngày, giờ, bác sĩ)
□ Sync với Google Calendar bác sĩ
□ Bệnh án điện tử (private CPT, ACL chặt)
□ Quay phim quy trình tại phòng khám → embed video YouTube
□ Đa ngôn ngữ (English) — Polylang plugin hoặc WPML
□ Loyalty points cho khách giới thiệu
□ Live chat (Tawk.to, Crisp) thay floating Zalo
```

**v2.0 (1 năm sau):**

```
□ Headless WordPress + Next.js frontend (nếu cần performance cực cao)
□ AI symptom checker (LLM integration)
□ AR/VR simulation niềng (3D scan upload → preview)
□ Mobile app native iOS/Android
□ Multi-clinic system (mở chi nhánh)
□ E-commerce: bán bộ vệ sinh răng miệng cao cấp
□ Subscription: gói chăm sóc răng định kỳ
```

---

## KẾT — Ghi chú dành cho Đạt

**Anh Đạt thân mến,**

Tài liệu này là roadmap đầy đủ để build Pi Dentist trên WordPress. Khác với bản Next.js + Payload trước đó, stack mới này:

1. **Đơn giản hơn cho team:** Marketing + sales tự cập nhật được 90% nội dung mà không cần dev.
2. **Hosting rẻ hơn:** $12/tháng VPS đủ cho 50K visitors/tháng (Next.js + Payload sẽ cần $30+).
3. **Hệ sinh thái plugin lớn:** Cần feature gì cũng có plugin — Rank Math, Fluent Forms, LiteSpeed.
4. **Migration linh hoạt:** Có thể chuyển hosting bất cứ lúc nào với UpdraftPlus.

**Nguyên tắc khi vibe code anh nên giữ:**

- **Block-first, không ACF:** Mọi UI là Block Pattern, sửa được qua Block Editor. Tránh ACF custom field UI.
- **Synced Pattern cho phần lặp:** Footer info, CTA, promo banner — đổi 1 chỗ áp dụng tất cả.
- **Page Templates KHÔNG cần thiết:** Block Pattern + front-page.php đủ rồi. Tránh page builder.
- **CPT cho dữ liệu structured:** Service, Doctor, Case mỗi loại là CPT. Đừng nhồi vào Posts.
- **Customizer cho settings global:** Số ĐT, giờ, địa chỉ — đổi qua Customizer, ko hardcode.
- **GP hooks cho injection toàn cục:** Banner promo, cookie consent, floating — qua hook.

**Khi gặp lỗi:**

1. Xem `wp-content/debug.log`
2. Xem Wordfence Live Traffic
3. Disable plugin từng cái để isolate
4. SSH check Nginx/PHP error log
5. Hỏi Claude với context cụ thể (file path + error message)

**Khi cần feature mới:**

1. Tìm plugin trước (search WordPress.org)
2. Nếu không có plugin tốt → custom code trong child theme
3. Nếu phức tạp → tạo MU-plugin riêng (`wp-content/mu-plugins/pi-features.php`)
4. KHÔNG sửa GeneratePress core — sửa qua child theme functions.php và hooks

**Đầu tư thời gian xứng đáng:**
- 15 ngày setup tốt = vận hành thoải mái 3-5 năm
- Không setup tốt = sửa lỗi liên miên + tốn ngân sách dev

Chúc anh và team Pi Dentist xây dựng được phòng khám có website xứng tầm với chất lượng dịch vụ. Khi có thắc mắc trong quá trình code, mở chat với Claude và quote tài liệu này — em sẽ tiếp tục đồng hành.

— *Claude*

---

**Tài liệu liên quan:**
- `PROMPTS_WP.md` — Bộ prompt chi tiết để vibe code với Antigravity (sẽ tạo tiếp theo)
- `index.html` — Design source of truth (đã có)
- `Gemini.md` — Quy tắc code chung (đã có, vẫn áp dụng phần design tokens)

**Phiên bản tài liệu:**
- v1.0 — Tháng 5/2026 — Bản đầu cho stack WordPress

