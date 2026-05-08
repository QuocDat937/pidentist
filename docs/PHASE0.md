# PHASE 0 — SETUP LOCAL + CHILD THEME (0.5–1 ngày)

> **Mục tiêu:** Có LocalWP chạy WordPress + GeneratePress + child theme `pidentist` skeleton, Git init, VS Code ready.
> **Ref:** PROJECT_SPEC_WP.md — Section 4, 17

---

## PROMPT 0.1 — Tạo child theme skeleton

```
Tôi đang build website WordPress cho phòng khám chỉnh nha "Pi Dentist" (pidentist.vn).
Stack: WordPress 6.4+ / GeneratePress Free (parent theme) / child theme "pidentist".

Hãy tạo TOÀN BỘ file skeleton cho child theme `pidentist` theo cấu trúc bên dưới.
Chỉ tạo file với nội dung tối thiểu (placeholder) — chưa viết logic:

pidentist/
├── style.css                # Theme metadata (Template: generatepress)
├── functions.php            # Entry point: define constants + require modules
├── screenshot.png           # (skip)
├── assets/
│   ├── css/
│   │   ├── tokens.css       # CSS custom properties (copy từ bên dưới)
│   │   ├── base.css         # Reset, typography, container — placeholder
│   │   ├── buttons.css      # 4 button variants — placeholder
│   │   ├── header.css       # Sticky header — placeholder
│   │   ├── footer.css       # Footer 4 columns — placeholder
│   │   ├── sections.css     # Common section patterns — placeholder
│   │   ├── cards.css        # Card hover, shadow — placeholder
│   │   ├── animations.css   # Reveal, fade-in — placeholder
│   │   ├── floating.css     # FloatingCTA, ContactWidgets, BackToTop — placeholder
│   │   ├── editor.css       # Block Editor styles — placeholder
│   │   └── patterns/
│   │       ├── hero.css
│   │       ├── commitments.css
│   │       ├── philosophy.css
│   │       ├── services-grid.css
│   │       └── pricing-table.css
│   ├── js/
│   │   ├── header.js        # Sticky scroll, mobile menu toggle — placeholder
│   │   ├── reveal.js        # IntersectionObserver — placeholder
│   │   ├── floating.js      # Show/hide floating CTA — placeholder
│   │   ├── carousel.js      # Doctors carousel — placeholder
│   │   └── smooth-scroll.js # Anchor smooth scroll — placeholder
│   ├── fonts/               # (empty, sẽ download fonts Phase 1)
│   └── images/
│       └── placeholders/    # (empty)
├── inc/
│   ├── enqueue.php          # wp_enqueue_scripts — placeholder
│   ├── theme-supports.php   # add_theme_support — placeholder
│   ├── menus.php            # register_nav_menus — placeholder
│   ├── cpt.php              # placeholder
│   ├── taxonomies.php       # placeholder
│   ├── meta-fields.php      # placeholder
│   ├── block-patterns.php   # placeholder
│   ├── pattern-categories.php # placeholder
│   ├── customizer.php       # placeholder
│   ├── gp-hooks.php         # placeholder
│   ├── floating-elements.php # placeholder
│   ├── shortcodes.php       # placeholder
│   ├── editor-config.php    # placeholder
│   └── rank-math-defaults.php # placeholder
├── template-parts/
│   ├── header/
│   │   ├── site-branding.php
│   │   └── nav-mobile.php
│   ├── footer/
│   │   ├── footer-brand.php
│   │   ├── footer-links.php
│   │   └── footer-bottom.php
│   ├── card/
│   │   ├── service-card.php
│   │   ├── doctor-card.php
│   │   ├── case-card.php
│   │   └── post-card.php
│   ├── section/
│   │   ├── section-header.php
│   │   ├── booking-cta.php
│   │   └── page-hero.php
│   └── floating/
│       ├── cta.php
│       ├── contact-widgets.php
│       └── back-to-top.php
├── front-page.php
├── header.php
├── footer.php
├── page.php
├── single.php
├── archive.php
├── 404.php
├── search.php
└── searchform.php

### style.css metadata:
Theme Name: Pi Dentist
Theme URI: https://pidentist.vn
Description: Child theme của GeneratePress dành riêng cho Pi Dentist — Medical Premium Orthodontic Clinic.
Author: Pi Dentist Dev
Author URI: https://pidentist.vn
Template: generatepress
Version: 1.0.0
Text Domain: pidentist

### functions.php constants:
PIDENTIST_VERSION = '1.0.0'
PIDENTIST_DIR = get_stylesheet_directory()
PIDENTIST_URI = get_stylesheet_directory_uri()
Rồi require_once tất cả file trong inc/ theo thứ tự:
theme-supports → enqueue → menus → cpt → taxonomies → meta-fields → customizer → pattern-categories → block-patterns → editor-config → gp-hooks → floating-elements → shortcodes → rank-math-defaults

### tokens.css (COPY NGUYÊN NỘI DUNG):
:root {
  --pi-navy: #002147;
  --pi-navy-light: #003366;
  --pi-navy-dark: #001a33;
  --pi-gold: #C9A96E;
  --pi-gold-light: #E8D5A8;
  --pi-gold-hover: #b8944f;
  --pi-white: #FFFFFF;
  --pi-off-white: #F8F7F4;
  --pi-light-gray: #EDECEA;
  --pi-text: #1A1A1A;
  --pi-text-soft: #666666;
  --pi-success: #2E7D5B;
  --pi-font-heading: 'Playfair Display', Georgia, 'Times New Roman', serif;
  --pi-font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  --pi-radius-card: 16px;
  --pi-radius-btn: 6px;
  --pi-shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
  --pi-shadow-md: 0 8px 30px rgba(0,0,0,0.08);
  --pi-shadow-lg: 0 16px 48px rgba(0,0,0,0.12);
  --pi-transition: 0.3s cubic-bezier(0.22, 1, 0.36, 1);
  --pi-container: 1200px;
}

### inc/theme-supports.php:
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5', ['comment-list','comment-form','search-form','gallery','caption','style','script']);
add_theme_support('responsive-embeds');
add_theme_support('align-wide');
add_theme_support('editor-styles');
add_theme_support('wp-block-styles');

Mỗi file placeholder chỉ cần:
<?php defined('ABSPATH') || exit; // Pi Dentist — [tên module]

Mỗi file JS placeholder chỉ cần:
// Pi Dentist — [tên module] — Phase 1

Mỗi file CSS placeholder chỉ cần:
/* Pi Dentist — [tên module] — Phase 1 */
```

---

## PROMPT 0.2 — Enqueue CSS/JS đúng cách

```
Tiếp tục child theme pidentist.

Viết đầy đủ nội dung file `inc/enqueue.php` theo yêu cầu:

1. Hook vào `wp_enqueue_scripts` priority 20
2. Load parent theme GeneratePress style.css (BẮT BUỘC)
3. Load Google Fonts: Playfair Display (400,500,600,700,italic 400) + Inter (300-700), display=swap
4. Load tokens.css TRƯỚC, rồi các CSS con có dependency ['pi-tokens']
5. Load CSS theo thứ tự: tokens → base → buttons → header → footer → sections → cards → animations → floating
6. Load pattern CSS CHỈ KHI is_front_page(): hero, commitments, philosophy, services-grid, pricing-table
7. Load JS defer: header.js, reveal.js, floating.js, smooth-scroll.js
8. Load carousel.js CHỈ KHI is_front_page() || is_post_type_archive('pi_doctor')
9. Filter script_loader_tag để thêm `defer` cho các JS handle Pi
10. Hook after_setup_theme để add_editor_style cho tokens.css + editor.css

Sử dụng constants PIDENTIST_VERSION và PIDENTIST_URI đã define trong functions.php.
```

---

## PROMPT 0.3 — Git init + .gitignore + .editorconfig

```
Tạo các file cấu hình dự án cho child theme pidentist:

1. File `.gitignore` — ignore WP core, plugins, uploads, cache, .env, SQL, nhưng GIỮA child theme pidentist
2. File `.editorconfig` — PHP dùng tab indent 4, JS/CSS/JSON dùng space indent 2, UTF-8, LF line endings
3. File `.vscode/extensions.json` — recommend extensions: PHP Intelephense, WordPress Snippets, GitLens, Prettier, ESLint, Code Spell Checker
4. File `README.md` cho repo:

# Pi Dentist — WordPress Child Theme

Stack: WordPress 6.4+ | GeneratePress | Block Patterns | CPT native

## Quick start
1. Install LocalWP → create site `pidentist.local`
2. Activate GeneratePress parent
3. Clone repo → symlink/copy to wp-content/themes/pidentist
4. Activate child theme
5. Settings → Permalinks → /%postname%/ → Save

## Structure
- `inc/` — PHP modules (1 file = 1 concern)
- `assets/css/` — CSS files with tokens.css as foundation
- `assets/js/` — Vanilla JS, no jQuery
- `template-parts/` — Reusable template fragments
- `patterns/` CSS in `assets/css/patterns/`
```

---

**✅ PHASE 0 DONE khi:**
- [ ] Child theme `pidentist` activate không lỗi
- [ ] Browse pidentist.local hiển thị GP default + title "Pi Dentist"
- [ ] WP Admin → Appearance → Themes → "Pi Dentist" active
- [ ] Git repo init, first commit pushed
- [ ] VS Code mở project, extensions installed
