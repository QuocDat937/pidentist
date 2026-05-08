# PHASE 1 — CONVERT index.html → TEMPLATES (2–3 ngày)

> **Mục tiêu:** Header, footer, floating elements, Customizer, nav walker hoạt động. Site local render giống index.html mock 95% ở phần header/footer/floating.
> **Ref:** PROJECT_SPEC_WP.md — Section 2, 4, 7, 10

---

## PROMPT 1.1 — Port CSS tokens + base + buttons từ index.html

```
Tôi có file `index.html` (85KB) chứa toàn bộ CSS inline trong <style>.
Tham chiếu PROJECT_SPEC_WP.md section 2.2–2.6.

Hãy viết đầy đủ 3 file CSS cho child theme pidentist:

### 1. assets/css/base.css
- Box-sizing border-box reset
- Body: font-family var(--pi-font-body), font-size 16px, line-height 1.7, color var(--pi-text), background var(--pi-white)
- Heading h1–h6: font-family var(--pi-font-heading), font-weight 600, color var(--pi-navy), line-height 1.2
- Typography scale theo bảng: Hero H1 clamp(36px,5vw,68px), Section H2 42px, Sub H3 18-22px, Body 15-17px, Caption 13-14px
- .container: max-width var(--pi-container), margin 0 auto, padding 0 24px
- .section-label: uppercase, letter-spacing 3px, font-size 13px, font-weight 600, color var(--pi-gold)
- .section-heading: font-size 42px, font-weight 600, margin-bottom 24px
- .gold-line: width 60px, height 2px, background var(--pi-gold), margin-top 24px
- .text-link: color var(--pi-gold), font-weight 600, text-decoration none, hover underline
- .prose: max-width 720px, line-height 1.8 (cho content area)
- Responsive: tablet max 1199px giảm heading, mobile max 767px giảm tiếp

### 2. assets/css/buttons.css
Copy 4 button variants từ PROJECT_SPEC_WP.md section 2.5:
- .btn base: inline-block, padding 14px 32px, border-radius 6px, font-weight 600, font-size 15px, transition var(--pi-transition), text-decoration none, cursor pointer
- .btn-gold: background gold, color navy, hover translateY(-2px) + shadow
- .btn-outline-white: transparent + white border, hover background rgba
- .btn-outline-navy: transparent + navy border, hover fill navy
- .btn-ghost-white: rgba background + blur, hover opacity increase

### 3. assets/css/sections.css
- Section padding: 100px 0 desktop, 80px tablet, 64px mobile
- .section-header: text-align center, max-width 720px, margin 0 auto
- .section-label-gold: color var(--pi-gold) trên nền navy
- .section-heading-white: color white trên nền navy
- .pi-navy-bg: background var(--pi-navy), color white
- .pi-off-white-bg: background var(--pi-off-white)
- Section rhythm: xen kẽ trắng ↔ off-white
```

---

## PROMPT 1.2 — Port header CSS + JS + header.php

```
Tham chiếu PROJECT_SPEC_WP.md section 7.7, 10.3 (hook 4), 10.5 (nav walker).
Tham chiếu index.html: section <header class="site-header">.

Viết đầy đủ 4 file:

### 1. assets/css/header.css
Từ index.html port CSS cho .site-header:
- Position sticky top 0, z-index 1000
- Background transparent → scroll thêm class .scrolled → background var(--pi-navy), box-shadow
- .header-inner: display flex, align-items center, justify-content space-between, height 80px → 70px khi scrolled
- .logo: display flex, align-items center, gap 12px, text-decoration none
- .logo-symbol: font-size 36px, font-weight 700, color var(--pi-gold)
- .logo-text: font-family heading, font-size 20px, font-weight 600, color white
- .main-nav: display flex, gap 8px
- .nav-item: position relative
- .nav-link: color rgba(255,255,255,0.85), padding 8px 16px, font-weight 500, hover color white
- .dropdown: position absolute, top 100%, left 0, min-width 240px, background white, border-radius 12px, shadow-lg, opacity 0 → hover opacity 1
- .dropdown-item: padding 12px 20px, color var(--pi-text), hover background var(--pi-off-white)
- .header-cta: .btn.btn-gold nhỏ hơn (padding 10px 24px)
- .hamburger: display none trên desktop, hiện mobile (3 span bars, animate thành X)
- Mobile: nav ẩn, hamburger hiện, logo nhỏ hơn
- Transition smooth 0.3s cho tất cả

### 2. assets/js/header.js
- Sticky header: addEventListener scroll → add/remove .scrolled class khi scrollY > 50
- Mobile menu: hamburger click → toggle .mobile-nav-open trên body + aria-expanded
- Close mobile nav khi click link hoặc click overlay
- Close mobile nav khi resize > 768px

### 3. header.php
Copy từ PROJECT_SPEC_WP.md section 7.7:
- <!DOCTYPE html>, <html lang_attributes>, <head> wp_head, <body> body_class
- wp_body_open() + skip link
- <header class="site-header" id="siteHeader">
- Logo: a href home_url('/') với .logo-symbol π + .logo-text "Pi Dentist"
- Nav: wp_nav_menu theme_location 'primary', walker Pi_Nav_Walker, container false, items_wrap '%3$s', depth 2
- CTA button: btn btn-gold link /lien-he/
- Hamburger button 3 spans
- get_template_part('template-parts/header/nav-mobile')

### 4. template-parts/header/nav-mobile.php
- <div class="mobile-nav-overlay" id="mobileNav">
- <div class="mobile-nav-inner">
- wp_nav_menu theme_location 'mobile' (hoặc fallback 'primary')
- CTA button mobile
- Social icons (lấy từ get_theme_mod)
- </div></div>
```

---

## PROMPT 1.3 — Port footer CSS + footer.php + template parts

```
Tham chiếu PROJECT_SPEC_WP.md section 7.8.
Tham chiếu index.html: <footer class="site-footer">.

Viết đầy đủ 5 file:

### 1. assets/css/footer.css
Từ index.html port CSS cho .site-footer:
- Background var(--pi-navy), color rgba(255,255,255,0.7)
- Padding 80px 0 40px
- .footer-grid: display grid, grid-template-columns repeat(4, 1fr), gap 40px
- Column 1 (brand): logo π white, tagline, mô tả ngắn
- Column 2 (dịch vụ): links list, color white 0.7 → hover 1
- Column 3 (thông tin): links list
- Column 4 (liên hệ): phone, email, address, giờ làm việc
- .footer-bottom: border-top rgba(255,255,255,0.1), padding-top 24px, margin-top 40px, display flex, justify-content space-between
- Responsive: mobile 1 column stack
- Social icons row: flex gap 16px, color var(--pi-gold)

### 2. footer.php
Copy từ PROJECT_SPEC_WP.md section 7.8:
- <footer class="site-footer">
- .container > .footer-grid
- get_template_part 3 footer parts
- .footer-bottom
- wp_footer()
- </body></html>

### 3. template-parts/footer/footer-brand.php
- Logo π trắng + "Pi Dentist"
- Tagline: get_bloginfo('description')
- Paragraph mô tả ngắn
- Social icons: Facebook, Instagram, YouTube, TikTok, Zalo — lấy URL từ get_theme_mod('pi_facebook_url') etc.

### 4. template-parts/footer/footer-links.php
- 2 columns: "Dịch vụ" + "Thông tin"
- wp_nav_menu theme_location 'footer-services' + 'footer-info'
- Fallback: list links thủ công /dich-vu/, /bac-si/, /bang-gia/, /ve-pi/, /lien-he/, /kien-thuc/

### 5. template-parts/footer/footer-bottom.php
- © {year} Pi Dentist. All rights reserved.
- Links: Privacy Policy + Terms of Service
```

---

## PROMPT 1.4 — Floating elements CSS + JS + PHP

```
Tham chiếu PROJECT_SPEC_WP.md section 10.4.

Viết đầy đủ 3 file:

### 1. assets/css/floating.css
- .floating-cta: position fixed, bottom 24px, left 50%, transform translateX(-50%), z-index 999, opacity 0, transition 0.4s, pointer-events none
- .floating-cta.show: opacity 1, pointer-events auto
- .contact-widgets: position fixed, bottom 100px, right 24px, display flex, flex-direction column, gap 12px, z-index 998
- .widget-btn: width 56px, height 56px, border-radius 50%, display flex, align-items center, justify-content center, font-size 20px, box-shadow var(--pi-shadow-md), transition var(--pi-transition)
- .widget-zalo: background #0068FF, color white
- .widget-phone: background var(--pi-gold), color var(--pi-navy)
- .widget-btn:hover: transform scale(1.1)
- .back-to-top: position fixed, bottom 24px, right 24px, width 44px, height 44px, border-radius 50%, background var(--pi-navy), color white, opacity 0, transition 0.3s
- .back-to-top.show: opacity 1
- Mobile: floating-cta full width bottom 0, border-radius 0

### 2. assets/js/floating.js
Copy từ PROJECT_SPEC_WP.md section 10.4:
- DOMContentLoaded
- Get elements: floatingCta, contactWidgets, backToTop
- Trigger point: header height + 200 hoặc 800px
- Scroll handler passive: toggle .show class
- backToTop click: scrollTo top smooth

### 3. inc/floating-elements.php
Copy từ PROJECT_SPEC_WP.md section 10.4:
- add_action('wp_footer', callback, 30)
- Skip is_admin() || is_404()
- Get phone + zalo_url từ get_theme_mod
- Render: floating-cta div, contact-widgets div (Zalo + Phone), back-to-top button
```

---

## PROMPT 1.5 — Customizer settings đầy đủ

```
Tham chiếu PROJECT_SPEC_WP.md section 5.7.

Viết đầy đủ file `inc/customizer.php`:

### Sections cần tạo:
1. **pi_general** (priority 30) — "Pi - Thông tin chung"
   - pi_phone (text, default '0909 XXX XXX')
   - pi_email (email, default 'info@pidentist.vn')
   - pi_address (textarea)
   - pi_hours_weekday (text, default '8:00 – 20:00', label 'Giờ làm việc — Thứ 2 – Thứ 6')
   - pi_hours_saturday (text, default '8:00 – 17:00')
   - pi_hours_sunday (text, default 'Nghỉ')

2. **pi_social** (priority 31) — "Pi - Mạng xã hội"
   - pi_facebook_url, pi_instagram_url, pi_youtube_url, pi_tiktok_url, pi_zalo_url (all url type, default '#')

3. **pi_promo** (priority 32) — "Pi - Ưu đãi"
   - pi_promo_active (checkbox, default true)
   - pi_promo_text (textarea, default 'Ưu đãi khai trương: Scan 3D miễn phí + Giảm 20% phí điều trị')

4. **pi_map** (priority 33) — "Pi - Bản đồ Google"
   - pi_map_embed (textarea, sanitize cho phép iframe Google Maps only)

Tất cả settings dùng sanitize_callback phù hợp.
```

---

## PROMPT 1.6 — Menu registration + Pi_Nav_Walker

```
Tham chiếu PROJECT_SPEC_WP.md section 10.5.

Viết đầy đủ file `inc/menus.php`:

1. register_nav_menus với 4 locations:
   - 'primary' → 'Menu chính (header)'
   - 'mobile' → 'Menu mobile'
   - 'footer-services' → 'Footer - Dịch vụ'
   - 'footer-info' → 'Footer - Thông tin'

2. Class Pi_Nav_Walker extends Walker_Nav_Menu:
   - start_lvl: output <div class="dropdown" role="menu">
   - end_lvl: </div>
   - start_el depth 0: <div class="nav-item"> + <a class="nav-link"> + chevron ▼ nếu has-children
   - start_el depth 1: <a class="dropdown-item" role="menuitem">
   - end_el depth 0: </div>

Copy code từ PROJECT_SPEC_WP.md section 10.5.
```

---

## PROMPT 1.7 — GP Hooks: promo banner + page hero + CTA booking + credits

```
Tham chiếu PROJECT_SPEC_WP.md section 10.3.

Viết đầy đủ file `inc/gp-hooks.php` với 5 hooks:

1. **generate_before_header** → Promo banner
   - Kiểm tra get_theme_mod('pi_promo_active')
   - Render .pi-promo-banner với emoji + text

2. **generate_after_header** → Page Hero cho trang con
   - Skip is_front_page(), is_404(), is_search()
   - Phát hiện label theo CPT: DỊCH VỤ / BÁC SĨ / CASE ĐIỀU TRỊ / KIẾN THỨC
   - Lấy heading = get_the_title() hoặc post_type_archive_title
   - get_template_part('template-parts/section/page-hero')

3. **generate_before_footer** → CTA Booking synced pattern
   - Skip front_page, page lien-he, 404
   - Render synced pattern 'pi-cta-booking' qua get_page_by_path + do_blocks

4. **generate_logo_output** (filter) → Override logo
   - Return custom HTML: <a> với .logo-symbol π + .logo-text bloginfo name

5. **generate_credits** → Custom footer bottom
   - © {year} Pi Dentist. All rights reserved.
   - Privacy + Terms links
```

---

## PROMPT 1.8 — Template page-hero + section-header + front-page.php

```
Viết đầy đủ 3 file:

### 1. template-parts/section/page-hero.php
Nhận args qua $args:
- $args['label'] — uppercase label (vd: 'DỊCH VỤ')
- $args['heading'] — heading text
- $args['sub'] — subtitle (optional)
- $args['breadcrumb'] — boolean (optional)

Render:
- <section class="page-hero">
- .container
- .page-hero-content
- <p class="section-label">{label}</p>
- <h1>{heading}</h1>
- <p class="page-hero-sub">{sub}</p> (nếu có)
- Breadcrumb: rank_math_the_breadcrumbs() nếu breadcrumb=true và function_exists
- CSS cho page-hero: background var(--pi-navy), color white, padding 80px 0 60px, text-align center

### 2. template-parts/section/section-header.php
Reusable section header component:
- $args['label'], $args['heading'], $args['sub']
- <div class="section-header">
- <p class="section-label">{label}</p>
- <h2 class="section-heading">{heading}</h2>
- <div class="gold-line"></div>
- <p class="section-sub">{sub}</p> (nếu có)

### 3. front-page.php
Copy từ PROJECT_SPEC_WP.md section 7.3:
- get_header()
- <main id="main-content" class="pi-front-page">
- while have_posts: the_post() → the_content()
- get_footer()
```

---

## PROMPT 1.9 — Scroll reveal CSS + JS

```
Viết 2 file cho scroll reveal animation:

### 1. assets/css/animations.css
- .reveal: opacity 0, transform translateY(30px), transition 0.8s cubic-bezier(0.22,1,0.36,1)
- .reveal.revealed: opacity 1, transform translateY(0)
- .reveal-left: translateX(-30px), .reveal-left.revealed: translateX(0)
- .reveal-right: translateX(30px), .reveal-right.revealed: translateX(0)
- .reveal-scale: scale(0.95), .reveal-scale.revealed: scale(1)
- Stagger delay: .reveal-delay-1 { transition-delay: 0.1s }, .reveal-delay-2 { 0.2s }, .reveal-delay-3 { 0.3s }, .reveal-delay-4 { 0.4s }
- @media (prefers-reduced-motion: reduce): tắt animation, opacity 1, transform none

### 2. assets/js/reveal.js
- IntersectionObserver với threshold 0.15, rootMargin '0px 0px -50px 0px'
- Observe tất cả .reveal elements
- Khi intersecting: add .revealed, unobserve
- Fallback cho browser cũ: querySelectorAll .reveal → add .revealed ngay
```

---

## PROMPT 1.10 — Smooth scroll + cards CSS

```
Viết 3 file:

### 1. assets/js/smooth-scroll.js
- Intercept click trên anchor links (href bắt đầu #)
- scrollIntoView behavior smooth
- Offset cho sticky header (80px)
- History pushState

### 2. assets/css/cards.css
- .service-card, .doctor-card, .case-card, .post-card: chung style
- background white, border-radius var(--pi-radius-card), overflow hidden
- box-shadow var(--pi-shadow-sm)
- transition var(--pi-transition)
- hover: transform translateY(-6px), box-shadow var(--pi-shadow-md)
- .card-thumb: aspect-ratio 16/9, overflow hidden, img width 100% object-fit cover
- .card-body: padding 24px
- .card-title: font-family heading, font-size 20px, margin-bottom 8px
- .card-desc: font-size 15px, color var(--pi-text-soft), line-height 1.6
- .card-meta: font-size 13px, color var(--pi-text-soft), margin-top 12px
- .card-link: .text-link style

### 3. assets/css/patterns/hero.css
Port CSS hero section từ index.html:
- .pi-hero: position relative, min-height 100vh (hoặc 90vh), display flex, align-items center, justify-content center, overflow hidden
- .hero-bg: position absolute, inset 0, background linear-gradient(135deg, var(--pi-navy) 0%, var(--pi-navy-light) 50%, var(--pi-navy-dark) 100%), z-index 0
- .hero-content: position relative, z-index 2, text-align center, color white, max-width 800px, padding 0 24px
- .hero-label: section-label style, color var(--pi-gold)
- .hero-heading: clamp(36px,5vw,68px), font-weight 600, line-height 1.1, margin 24px 0
- .hero-sub: font-size 20px, line-height 1.6, color rgba(255,255,255,0.8), max-width 600px, margin 0 auto 40px
- .hero-ctas: display flex, gap 16px, justify-content center, flex-wrap wrap
- .scroll-indicator: position absolute, bottom 40px, left 50%, transform translateX(-50%), color rgba(255,255,255,0.5), text-align center, animation bounce 2s infinite
- @keyframes bounce: 0%,100% translateY(0), 50% translateY(10px)
- Responsive mobile: min-height 85vh, heading font-size 36px, sub font-size 17px
```

---

**✅ PHASE 1 DONE khi:**
- [ ] Header sticky scroll hoạt động (transparent → navy on scroll)
- [ ] Mobile hamburger menu toggle
- [ ] Footer 4 columns render đúng với data từ Customizer
- [ ] 3 floating buttons show/hide on scroll
- [ ] Promo banner hiển thị khi bật trong Customizer
- [ ] front-page.php render the_content() (trắng vì chưa có patterns)
- [ ] PageSpeed mobile ≥ 80
- [ ] Console browser 0 errors
