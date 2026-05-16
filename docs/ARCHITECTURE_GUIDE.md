# Pi Dentist — Hướng dẫn Kiến trúc & Xây dựng Website WordPress

> Tài liệu step-by-step mô tả cấu trúc child theme và quy trình xây dựng giao diện kết nối WordPress.

---

## 1. Tổng quan Kiến trúc

**Stack:** WordPress 6.4+ → GeneratePress (parent) → `pidentist` (child theme)

```
WordPress Core
  └── GeneratePress (parent theme - free)
        └── pidentist (child theme)
              ├── Block Patterns (nội dung trang chủ)
              ├── Custom Post Types (dịch vụ, bác sĩ, case)
              ├── Template Parts (components tái sử dụng)
              └── Customizer Settings (cấu hình global)
```

**Nguyên tắc cốt lõi:**
- Block-first, KHÔNG dùng page builder (Elementor, ACF...)
- 1 file = 1 việc (tách module trong `inc/`)
- Vanilla JS only, KHÔNG jQuery
- CSS Custom Properties (design tokens)
- Mobile-first responsive

---

## 2. Cấu trúc Thư mục Child Theme

```
pidentist/
├── style.css                 ← Metadata only (khai báo child theme)
├── functions.php             ← Entry point: chỉ require modules
│
├── assets/
│   ├── css/
│   │   ├── tokens.css        ← Design tokens (màu, font, shadow...)
│   │   ├── fonts.css         ← @font-face declarations
│   │   ├── base.css          ← Reset, typography, container
│   │   ├── buttons.css       ← 4 button variants
│   │   ├── header.css        ← Sticky header styles
│   │   ├── footer.css        ← Footer 4 columns
│   │   ├── sections.css      ← Section patterns chung
│   │   ├── cards.css         ← Card components
│   │   ├── animations.css    ← Scroll reveal, fade-in
│   │   ├── floating.css      ← Floating CTA, widgets, back-to-top
│   │   └── patterns/         ← CSS riêng cho từng section/page
│   │       ├── hero.css
│   │       ├── commitments.css
│   │       ├── philosophy.css
│   │       ├── doctors-grid.css
│   │       ├── technology.css
│   │       ├── simulation.css
│   │       ├── journey.css
│   │       ├── services-grid.css
│   │       ├── pricing-table.css
│   │       ├── booking-form.css
│   │       ├── single-service.css
│   │       ├── blog.css
│   │       ├── contact-page.css
│   │       ├── pricing-page.css
│   │       ├── about-page.css
│   │       └── cases-grid.css
│   ├── js/
│   │   ├── header.js         ← Sticky header + hamburger
│   │   ├── reveal.js         ← IntersectionObserver scroll reveal
│   │   ├── floating.js       ← Show/hide floating elements
│   │   ├── smooth-scroll.js  ← Anchor smooth scroll
│   │   ├── carousel.js       ← Doctor carousel
│   │   ├── booking-form.js   ← AJAX booking form
│   │   └── service-toc.js    ← Table of contents cho service
│   ├── fonts/                ← Self-hosted woff2 (Inter, Playfair Display)
│   └── images/
│
├── inc/                      ← PHP modules (1 file = 1 concern)
│   ├── theme-supports.php    ← add_theme_support
│   ├── enqueue.php           ← wp_enqueue CSS/JS + conditional loading
│   ├── menus.php             ← register_nav_menus + Pi_Nav_Walker
│   ├── cpt.php               ← 3 Custom Post Types
│   ├── taxonomies.php        ← 2 Taxonomies
│   ├── meta-fields.php       ← register_post_meta + meta boxes
│   ├── customizer.php        ← Customizer settings (phone, social...)
│   ├── pattern-categories.php
│   ├── block-patterns.php    ← Block Patterns cho trang chủ
│   ├── synced-patterns-seed.php ← Synced Pattern (CTA Booking)
│   ├── editor-config.php     ← Block Editor palette + settings
│   ├── gp-hooks.php          ← GeneratePress hook injections
│   ├── floating-elements.php ← wp_footer floating elements
│   ├── shortcodes.php        ← [pi_services_grid], [pi_doctors_carousel]...
│   ├── homepage-compose.php  ← Auto-compose 11 sections trang chủ
│   ├── rank-math-defaults.php
│   ├── plugin-config.php
│   ├── security.php          ← Security hardening
│   ├── roles.php
│   ├── seed-data.php
│   └── ajax/
│       └── booking-form-handler.php
│
├── template-parts/
│   ├── header/   → site-branding.php, nav-mobile.php
│   ├── footer/   → footer-brand.php, footer-links.php, footer-bottom.php
│   ├── card/     → service-card.php, doctor-card.php, case-card.php, post-card.php
│   ├── section/  → section-header.php, page-hero.php, booking-cta.php
│   ├── floating/ → cta.php, contact-widgets.php, back-to-top.php
│   ├── form/     → booking-form.php
│   └── service/  → nieng-mac-cai-kim-loai.php, nieng-mac-cai-su.php...
│
├── header.php, footer.php, front-page.php
├── single-pi_service.php, archive-pi_service.php
├── single-pi_doctor.php, archive-pi_doctor.php
├── single-pi_case.php, archive-pi_case.php
├── single.php, archive.php, home.php
├── page.php, page-ve-pi.php, page-bang-gia.php, page-lien-he.php
├── 404.php, search.php
└── docs/, deploy/
```

---

## 3. Quy trình Xây dựng Step-by-Step

### Step 1: Khởi tạo Child Theme

**1.1 Tạo `style.css` — khai báo metadata:**
```css
/*
Theme Name: Pi Dentist
Template: generatepress        ← Tên folder parent theme
Version: 1.0.0
Text Domain: pidentist
*/
/* KHÔNG viết CSS ở đây — CSS thực tế ở /assets/css/ */
```

**1.2 Tạo `functions.php` — entry point:**
```php
<?php
defined('ABSPATH') || exit;

define('PIDENTIST_VERSION', '1.0.0');
define('PIDENTIST_DIR', get_stylesheet_directory());
define('PIDENTIST_URI', get_stylesheet_directory_uri());

// Require modules — thứ tự QUAN TRỌNG
require_once PIDENTIST_DIR . '/inc/theme-supports.php';
require_once PIDENTIST_DIR . '/inc/enqueue.php';
require_once PIDENTIST_DIR . '/inc/menus.php';
// ... tiếp tục theo thứ tự dependency
```

> **Quy tắc:** `functions.php` chỉ chứa constants + require. KHÔNG viết logic ở đây.

---

### Step 2: Thiết lập Design System (CSS)

**2.1 `tokens.css` — Design tokens:**

Khai báo tất cả màu sắc, font, shadow, spacing dưới dạng CSS custom properties:
```css
:root {
  --pi-navy: #002147;
  --pi-gold: #C9A96E;
  --pi-font-heading: 'Playfair Display', Georgia, serif;
  --pi-font-body: 'Inter', sans-serif;
  --pi-radius-card: 16px;
  --pi-transition: 0.3s cubic-bezier(0.22, 1, 0.36, 1);
  --pi-container: 1200px;
}
```

**2.2 Chuỗi CSS dependency:**
```
tokens.css → base.css → buttons.css → header.css → footer.css → ...
```
Mọi CSS file đều dùng `var(--pi-*)`, KHÔNG hardcode giá trị.

**2.3 Enqueue CSS với dependency chain:**
```php
// inc/enqueue.php
add_action('wp_enqueue_scripts', 'pi_enqueue_styles', 20);

function pi_enqueue_styles() {
    // Parent theme trước
    wp_enqueue_style('generatepress-parent', get_template_directory_uri() . '/style.css');
    
    // Tokens load TRƯỚC mọi CSS con
    wp_enqueue_style('pi-tokens', $uri . '/assets/css/tokens.css',
        array('generatepress-parent'), PIDENTIST_VERSION);
    
    // Core CSS chain — tất cả depend vào pi-tokens
    $core = ['base.css', 'buttons.css', 'header.css', ...];
    foreach ($core as $file) {
        wp_enqueue_style("pi-{$name}", $uri . "/assets/css/{$file}",
            array('pi-tokens'), PIDENTIST_VERSION);
    }
    
    // Pattern CSS — CHỈ load khi cần (conditional)
    if (is_front_page()) {
        wp_enqueue_style('pi-pattern-hero', '.../patterns/hero.css');
    }
}
```

---

### Step 3: Override Header & Footer

**3.1 `header.php` — Override GP header:**

```php
<?php defined('ABSPATH') || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content">Chuyển đến nội dung</a>

<?php // Promo banner từ GP hook (inc/gp-hooks.php) ?>

<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header-inner">
            <!-- Logo -->
            <a href="<?php echo home_url('/'); ?>" class="logo">
                <span class="logo-symbol">π</span>
                <span class="logo-text">Pi Dentist</span>
            </a>
            <!-- Nav: dùng wp_nav_menu + Pi_Nav_Walker -->
            <nav class="main-nav">
                <?php wp_nav_menu(['theme_location' => 'primary',
                    'walker' => new Pi_Nav_Walker()]); ?>
            </nav>
            <!-- CTA + Hamburger -->
        </div>
    </div>
</header>

<?php get_template_part('template-parts/header/nav-mobile'); ?>
```

**3.2 `footer.php` — Tách thành template parts:**
```php
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <?php
            get_template_part('template-parts/footer/footer-brand');
            get_template_part('template-parts/footer/footer-links');
            ?>
        </div>
        <?php get_template_part('template-parts/footer/footer-bottom'); ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body></html>
```

---

### Step 4: GeneratePress Hooks (thay vì override templates)

File `inc/gp-hooks.php` — inject HTML vào các vị trí GP mà KHÔNG cần copy template:

| Hook | Chức năng |
|------|-----------|
| `generate_before_header` | Promo banner (toggle qua Customizer) |
| `generate_after_header` | Page Hero cho trang con |
| `generate_before_footer` | CTA Booking synced pattern |
| `generate_logo_output` | Override logo HTML (π symbol) |
| `generate_copyright` | Custom footer credits |

```php
// Ví dụ: Promo banner
add_action('generate_before_header', 'pi_hook_promo_banner');
function pi_hook_promo_banner() {
    if (!get_theme_mod('pi_promo_active', false)) return;
    $text = get_theme_mod('pi_promo_text', '');
    if (!$text) return;
    echo '<div class="pi-promo-banner">' . wp_kses_post($text) . '</div>';
}
```

---

### Step 5: Đăng ký Custom Post Types & Taxonomies

**5.1 `inc/cpt.php` — 3 CPT:**

| CPT | Slug | Archive URL |
|-----|------|-------------|
| `pi_service` | `dich-vu` | `/dich-vu/` |
| `pi_doctor` | `bac-si` | `/bac-si/` |
| `pi_case` | `case` | `/case/` |

```php
add_action('init', 'pi_register_post_types');
function pi_register_post_types() {
    register_post_type('pi_service', [
        'public'       => true,
        'has_archive'  => 'dich-vu',
        'rewrite'      => ['slug' => 'dich-vu', 'with_front' => false],
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,  // Bắt buộc cho Block Editor
        'rest_base'    => 'services',
    ]);
    // Tương tự cho pi_doctor, pi_case
}
```

**5.2 `inc/taxonomies.php` — 2 Taxonomies:**
- `pi_service_category` (hierarchical) → attach vào `pi_service`
- `pi_case_tag` (non-hierarchical) → attach vào `pi_case`

**5.3 `inc/meta-fields.php` — Meta fields:**
- Dùng `register_post_meta()` + `add_meta_box()` (native, KHÔNG ACF)
- Prefix: `_pi_` (underscore đầu = ẩn khỏi Custom Fields UI)
- Ví dụ: `_pi_service_price_from`, `_pi_doctor_specialty`

---

### Step 6: Tạo Templates cho CPT

**6.1 Mỗi CPT cần 2 template:**

| File | Chức năng |
|------|-----------|
| `single-pi_service.php` | Chi tiết 1 dịch vụ |
| `archive-pi_service.php` | Listing tất cả dịch vụ |

**6.2 Cấu trúc single template (ví dụ `single-pi_service.php`):**

```php
get_header();
while (have_posts()) : the_post();
    // 1. Lấy meta data
    $price = get_post_meta(get_the_ID(), '_pi_service_price_from', true);
    
    // 2. Page Hero
    get_template_part('template-parts/section/page-hero', null, [
        'label' => 'DỊCH VỤ', 'heading' => get_the_title()
    ]);
    
    // 3. Nội dung chính (template part hoặc Block Editor content)
    $slug = get_post_field('post_name');
    $found = locate_template("template-parts/service/{$slug}.php");
    if ($found) {
        get_template_part("template-parts/service/{$slug}");
    } else {
        the_content(); // Fallback: Block Editor content
    }
    
    // 4. Related doctors/cases (WP_Query)
    // 5. CTA Booking
endwhile;
get_footer();
```

**6.3 Truyền data qua `$args` (WP 5.5+):**
```php
// Gọi:
get_template_part('template-parts/section/page-hero', null, [
    'label' => 'DỊCH VỤ', 'heading' => 'Niềng mắc cài'
]);

// Trong template-parts/section/page-hero.php:
$label = $args['label'] ?? '';
$heading = $args['heading'] ?? '';
```

---

### Step 7: Block Patterns — Nội dung trang chủ

**7.1 Đăng ký patterns (`inc/block-patterns.php`):**

```php
add_action('init', 'pi_register_block_patterns');
function pi_register_block_patterns() {
    register_block_pattern('pi/hero-banner', [
        'title'      => 'Pi - Hero Banner',
        'categories' => ['pi-homepage'],
        'content'    => '<!-- wp:group {"className":"pi-hero"} -->
            <div class="wp-block-group pi-hero">...</div>
        <!-- /wp:group -->',
    ]);
    // Tương tự cho 8 patterns khác
}
```

**7.2 Trang chủ 11 sections (thứ tự cố định):**

| # | Section | Loại | Cách render |
|---|---------|------|-------------|
| 1 | Hero Banner | Block Pattern | Stamp vào page |
| 2 | Cam kết Pi | Block Pattern | Stamp vào page |
| 3 | Triết lý π | Block Pattern | Stamp vào page |
| 4 | Đội ngũ BS | Shortcode | `[pi_doctors_carousel]` |
| 5 | Công nghệ | Block Pattern | Stamp vào page |
| 6 | Dịch vụ | Pattern + Shortcode | Pattern chứa `[pi_services_grid]` |
| 7 | Simulation | Block Pattern | Stamp vào page |
| 8 | Hành trình | Block Pattern | Stamp vào page |
| 9 | Bảng giá | Block Pattern | Stamp vào page |
| 10 | Kiến thức | Shortcode | `[pi_recent_posts]` |
| 11 | CTA Booking | **Synced Pattern** | `<!-- wp:block {"ref":ID} /-->` |

**7.3 Auto-compose (`inc/homepage-compose.php`):**

Chạy 1 lần duy nhất khi kích hoạt theme — tự động ghép 11 sections vào page "Trang chủ":
```php
add_action('admin_init', 'pi_compose_homepage');
function pi_compose_homepage() {
    if (get_option('pi_homepage_composed')) return;
    // Lấy content từ mỗi registered pattern
    // Ghép thành post_content cho page "Trang chủ"
    // Set làm static front page
}
```

**7.4 `front-page.php` — chỉ render `the_content()`:**
```php
get_header();
?>
<main id="main-content" class="pi-front-page">
    <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
</main>
<?php get_footer();
```

---

### Step 8: Customizer — Cấu hình Global

File `inc/customizer.php` đăng ký 5 sections:

| Section | Settings |
|---------|----------|
| Pi - Thông tin chung | `pi_phone`, `pi_email`, `pi_address`, `pi_hours_*` |
| Pi - Mạng xã hội | `pi_facebook_url`, `pi_instagram_url`, `pi_zalo_url`... |
| Pi - Ưu đãi | `pi_promo_active`, `pi_promo_text` |
| Pi - Bản đồ | `pi_map_embed` |
| Pi - Booking | `pi_lead_email` |

Sử dụng trong template:
```php
$phone = get_theme_mod('pi_phone', '0909 000 000');
```

---

### Step 9: Floating Elements & JavaScript

**9.1 `inc/floating-elements.php` — Hook vào `wp_footer`:**
- Floating CTA bar (nút "Đặt lịch ngay")
- Contact widgets (Zalo + Phone)
- Back to Top button

**9.2 JavaScript (Vanilla JS, defer):**

| File | Chức năng |
|------|-----------|
| `header.js` | Sticky header + hamburger toggle |
| `reveal.js` | IntersectionObserver scroll reveal |
| `floating.js` | Show/hide floating elements on scroll |
| `carousel.js` | Doctor carousel (chỉ load khi cần) |
| `booking-form.js` | AJAX form submit |

```php
// Tự động thêm defer cho tất cả script Pi
add_filter('script_loader_tag', function($tag, $handle) {
    if (strpos($handle, 'pi-') !== 0) return $tag;
    return str_replace(' src=', ' defer src=', $tag);
}, 10, 2);
```

---

### Step 10: Navigation & Menu Walker

**10.1 Đăng ký 4 menu locations:**
```php
register_nav_menus([
    'primary'         => 'Menu chính (header)',
    'mobile'          => 'Menu mobile',
    'footer-services' => 'Footer - Dịch vụ',
    'footer-info'     => 'Footer - Thông tin',
]);
```

**10.2 Custom Walker (`Pi_Nav_Walker`):**
- Output classes: `.nav-item`, `.nav-link`, `.dropdown`, `.dropdown-item`
- Chevron ▼ cho parent items có submenu
- `aria-haspopup` cho accessibility

---

### Step 11: Kết nối WordPress Admin

**11.1 Cấu hình Reading Settings (tự động):**
- Tạo page "Trang chủ" → set làm `page_on_front`
- Tạo page "Kiến thức" → set làm `page_for_posts`
- `show_on_front` = `page`

**11.2 Tạo Menu trong WP Admin:**
1. Giao diện → Menu → Tạo menu "Menu chính"
2. Gán vào location "Menu chính (header)"
3. Thêm items: Trang chủ, Về Pi, Dịch vụ (dropdown), Bác sĩ, Bảng giá, Kiến thức, Liên hệ

**11.3 Cấu hình Customizer:**
1. Giao diện → Tùy biến
2. Điền thông tin: Pi - Thông tin chung (phone, email, address)
3. Cấu hình: Pi - Mạng xã hội, Pi - Ưu đãi, Pi - Bản đồ

**11.4 Tạo nội dung CPT:**
1. Dịch vụ → Thêm mới → Điền title, excerpt, featured image
2. Điền meta fields: giá, thời gian, đối tượng phù hợp
3. Tương tự cho Bác sĩ, Ca điều trị

---

## 4. Sơ đồ Luồng Render

```
Người dùng truy cập URL
        │
        ▼
WordPress Template Hierarchy
        │
        ├── / (trang chủ)
        │   └── front-page.php
        │       ├── get_header() → header.php
        │       ├── the_content() → 11 Block Patterns + Shortcodes
        │       └── get_footer() → footer.php
        │
        ├── /dich-vu/ (archive)
        │   └── archive-pi_service.php
        │       ├── Page Hero
        │       ├── WP_Query loop → service-card.php (×N)
        │       └── Pagination
        │
        ├── /dich-vu/nieng-trong-suot/ (single)
        │   └── single-pi_service.php
        │       ├── Page Hero + Quick Info (meta)
        │       ├── template-parts/service/nieng-trong-suot.php
        │       ├── Pros/Cons + FAQ (từ meta)
        │       ├── Related Doctors (WP_Query)
        │       └── Related Cases (WP_Query)
        │
        └── /lien-he/ (page)
            └── page-lien-he.php
                ├── Contact info (từ Customizer)
                ├── Booking form (AJAX)
                └── Google Maps (từ Customizer)
```

---

## 5. Conditional CSS/JS Loading

Hiệu suất được tối ưu bằng cách chỉ load CSS/JS khi cần:

```php
// Pattern CSS chỉ load ở front-page
if (is_front_page()) → hero.css, commitments.css, philosophy.css...

// Service CSS chỉ load khi xem dịch vụ
if (is_singular('pi_service')) → single-service.css

// Carousel JS chỉ load ở front-page hoặc archive doctor
if (is_front_page() || is_post_type_archive('pi_doctor')) → carousel.js

// Booking form JS load mọi trang (trừ 404)
if (!is_404()) → booking-form.js
```

---

## 6. Security Checklist

Tất cả được xử lý trong `inc/security.php`:
- `defined('ABSPATH') || exit;` — đầu mỗi file PHP
- Sanitize input: `sanitize_text_field()`, `absint()`, `esc_url_raw()`
- Escape output: `esc_html()`, `esc_attr()`, `esc_url()`
- Nonce verification cho forms/meta boxes
- Disable XML-RPC, ẩn WP version, block author enumeration
- REST API whitelist cho CPT

---

## 7. Tóm tắt Quy trình

| Bước | Công việc | Files chính |
|------|-----------|-------------|
| 1 | Khởi tạo child theme | `style.css`, `functions.php` |
| 2 | Design system | `tokens.css`, `base.css`, `buttons.css` |
| 3 | Header/Footer | `header.php`, `footer.php`, template-parts/ |
| 4 | GP Hooks | `inc/gp-hooks.php` |
| 5 | CPT + Meta | `inc/cpt.php`, `inc/meta-fields.php` |
| 6 | Templates CPT | `single-pi_*.php`, `archive-pi_*.php` |
| 7 | Block Patterns | `inc/block-patterns.php`, patterns CSS |
| 8 | Customizer | `inc/customizer.php` |
| 9 | Floating + JS | `inc/floating-elements.php`, `assets/js/` |
| 10 | Menu | `inc/menus.php`, WP Admin config |
| 11 | Kết nối WP | Reading settings, menu, customizer, content |

---

> **Tham khảo thêm:** `PROJECT_SPEC_WP.md` (chi tiết đầy đủ), `GEMINI.md` (quy tắc code), `PHASE0-4.md` (từng giai đoạn triển khai)
