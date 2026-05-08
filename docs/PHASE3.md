# PHASE 3 — BLOCK PATTERNS + SYNCED PATTERNS + HOMEPAGE (2–3 ngày)

> **Mục tiêu:** 5+ Block Patterns + 5 Synced Patterns ready. Admin compose homepage 11 sections qua Block Editor.
> **Ref:** PROJECT_SPEC_WP.md — Section 8, 9, 7.9

---

## PROMPT 3.1 — Pattern Categories + Editor config

```
Tham chiếu PROJECT_SPEC_WP.md section 8.2 + 8.5.

Viết đầy đủ 2 file:

### 1. inc/pattern-categories.php
Copy từ spec section 8.2:
- register_block_pattern_category 'pi-homepage': 'Pi Dentist - Homepage'
- register_block_pattern_category 'pi-sections': 'Pi Dentist - Sections'
- register_block_pattern_category 'pi-cta': 'Pi Dentist - CTA'
- Ẩn remote patterns: add_filter('should_load_remote_block_patterns', '__return_false')

### 2. inc/editor-config.php
Copy từ spec section 8.5:
- add_theme_support('editor-styles')
- add_editor_style() load: tokens.css, base.css, buttons.css, sections.css, + tất cả pattern CSS
- remove_theme_support('core-block-patterns') — ẩn patterns mặc định
- Custom color palette 9 màu Pi: navy, navy-light, navy-dark, gold, gold-light, white, off-white, text, text-soft
- add_theme_support('disable-custom-colors') — chỉ cho phép palette Pi
```

---

## PROMPT 3.2 — Block Pattern: Hero Banner

```
Tham chiếu PROJECT_SPEC_WP.md section 8.3 (Pattern 1).

Viết đầy đủ trong file `inc/block-patterns.php`:

register_block_pattern('pi/hero-banner', [...])
- title: 'Pi - Hero Banner (Navy)'
- categories: ['pi-homepage']
- content: Copy NGUYÊN block markup từ spec section 8.3 Pattern 1:
  - wp:group className "pi-hero"
  - hero-bg div
  - hero-content group (constrained 800px)
  - hero-label paragraph "CHỈNH NHA CHUYÊN SÂU"
  - h1 heading "Kỷ nguyên mới<br>của chỉnh nha chính xác"
  - hero-sub paragraph
  - 2 buttons: btn-gold "Đặt lịch tư vấn miễn phí" → /lien-he/, btn-outline-white "Khám phá Pi Dentist" → /ve-pi/
  - scroll-indicator div

CSS đã viết ở PHASE 1 (assets/css/patterns/hero.css).
Kiểm tra lại CSS hero.css đã match với block markup.
```

---

## PROMPT 3.3 — Block Pattern: Commitments Grid (4 cột)

```
Tham chiếu PROJECT_SPEC_WP.md section 8.3 (Pattern 2) + 8.4.

Thêm vào `inc/block-patterns.php`:

register_block_pattern('pi/commitments', [...])
- title: 'Pi - Cam kết grid (4 cột)'
- categories: ['pi-homepage', 'pi-sections']
- content: Copy block markup từ spec Pattern 2:
  - wp:group className "commitments" background white
  - commitments-grid: grid 4 columns
  - 4 commitment-items, mỗi item có:
    - commitment-icon SVG
    - h3 commitment-title
    - p commitment-desc
  - 4 nội dung: "Chỉ chuyên chỉnh nha", "Bác sĩ đào tạo quốc tế", "Công nghệ số 100%", "Theo dõi trọn đời"

Viết CSS `assets/css/patterns/commitments.css`:
Copy từ spec section 8.4:
- .commitments: padding 100px 0
- .commitments-grid: grid 4 columns, gap 32px
- .commitment-item: text-align center, padding 32px, background off-white, border-radius 16px, border light-gray, hover translateY(-6px) + shadow + gold border
- .commitment-icon: 56x56, margin auto, color gold
- .commitment-title: heading font, 20px, navy
- .commitment-desc: 15px, text-soft
- Responsive: tablet 2 cols, mobile 1 col
```

---

## PROMPT 3.4 — Block Pattern: Philosophy 2-column

```
Tham chiếu PROJECT_SPEC_WP.md section 8.3 (Pattern 3).

Thêm vào `inc/block-patterns.php`:

register_block_pattern('pi/philosophy', [...])
- title: 'Pi - Triết lý π (2 columns)'
- categories: ['pi-homepage', 'pi-sections']
- content: Copy block markup từ spec Pattern 3:
  - wp:group className "philosophy"
  - wp:columns className "philosophy-grid"
  - Column 1 "philosophy-visual": giant π symbol
  - Column 2 "philosophy-content": section-label "VỀ PI DENTIST", h2 "Chính xác như hằng số π", 2 paragraphs, text-link "Tìm hiểu thêm về Pi →"

Viết CSS `assets/css/patterns/philosophy.css`:
- .philosophy: padding 100px 0, background var(--pi-off-white)
- .philosophy-grid: display flex, align-items center, gap 80px, max-width var(--pi-container), margin 0 auto, padding 0 24px
- .philosophy-visual: flex 0 0 auto
- .pi-symbol: font-size clamp(200px, 25vw, 350px), font-weight 700, color var(--pi-gold), opacity 0.15, font-family heading, line-height 1
- .philosophy-content: flex 1
- .philosophy-text: font-size 17px, line-height 1.8, color var(--pi-text-soft), margin-bottom 16px
- Responsive mobile: flex-direction column, π symbol font-size 150px, text-align center
```

---

## PROMPT 3.5 — Block Pattern: Technology Navy

```
Tham chiếu PROJECT_SPEC_WP.md section 8.3 (Pattern 4).

Thêm vào `inc/block-patterns.php`:

register_block_pattern('pi/technology-navy', [...])
- title: 'Pi - Công nghệ (nền navy)'
- categories: ['pi-homepage']
- content: Copy block markup từ spec Pattern 4:
  - wp:group className "technology pi-navy-bg" style background #002147, color #fff
  - section-header: label gold "CÔNG NGHỆ & TIÊU CHUẨN", h2 white, gold-line
  - tech-grid: 3 columns: "CBCT 3D Scanner", "Scan kỹ thuật số iTero", "Phần mềm AI lập kế hoạch"
  - CTA button ghost-white

Viết CSS cho technology section (có thể trong sections.css hoặc file riêng):
- .technology: padding 100px 0
- .tech-grid: display grid, grid-template-columns repeat(3, 1fr), gap 32px
- .tech-item: background rgba(255,255,255,0.05), border 1px solid rgba(255,255,255,0.1), border-radius 16px, padding 40px 32px, transition hover border-color gold
- .tech-item h3: color white, font-size 22px
- .tech-item p: color rgba(255,255,255,0.7)
- .tech-cta: text-align center, margin-top 48px
- Responsive: tablet 2 cols, mobile 1 col
```

---

## PROMPT 3.6 — Block Pattern: Pricing Table

```
Tham chiếu PROJECT_SPEC_WP.md section 8.3 (Pattern 5).

Thêm vào `inc/block-patterns.php`:

register_block_pattern('pi/pricing-table', [...])
- title: 'Pi - Bảng giá (table)'
- categories: ['pi-homepage', 'pi-sections']
- content: Copy block markup từ spec Pattern 5:
  - section-header: label "BẢNG GIÁ", h2 "Minh bạch từ chi phí đến kết quả", sub, gold-line
  - HTML table.pricing-table: 4 rows (Kim loại, Sứ, Trong suốt highlight, Mặt trong) + columns (Phương pháp, Giá từ, Thời gian, Đặc điểm, Link)
  - installment-box: h3 "Trả góp 0% lãi suất" + paragraph

Viết CSS `assets/css/patterns/pricing-table.css`:
- .pricing: padding 100px 0
- .pricing-table: width 100%, border-collapse collapse, margin-top 48px
- .pricing-table th: background var(--pi-off-white), padding 16px 20px, text-align left, font-weight 600, font-size 14px, text-transform uppercase, letter-spacing 1px
- .pricing-table td: padding 20px, border-bottom 1px solid var(--pi-light-gray)
- .pricing-table tr.highlight: background linear-gradient(135deg, rgba(201,169,110,0.08), rgba(201,169,110,0.03)), border-left 3px solid var(--pi-gold)
- .pricing-table tr:hover: background var(--pi-off-white)
- .installment-box: background var(--pi-off-white), border-radius 16px, padding 32px, margin-top 48px, text-align center, border 1px dashed var(--pi-gold)
- Responsive mobile: table horizontal scroll wrapper, min-width 600px
```

---

## PROMPT 3.7 — Thêm 3 Block Patterns bổ sung (Simulation CTA, Timeline, Doctors Carousel section)

```
Thêm vào `inc/block-patterns.php` 3 patterns nữa:

### Pattern 6: pi/simulation-cta
- Section CTA giữa trang: "Xem trước nụ cười tương lai" + paragraph + 2 buttons
- Background off-white
- Layout: 2 columns (text trái + image placeholder phải)

### Pattern 7: pi/journey-timeline
- Section "Hành trình 5 bước tại Pi Dentist"
- 5 bước: 1. Tư vấn ban đầu → 2. Chẩn đoán 3D → 3. Lập kế hoạch → 4. Bắt đầu điều trị → 5. Hoàn tất & theo dõi
- Layout: timeline vertical với step numbers + connecting line
- Background off-white

### Pattern 8: pi/services-grid-home (section wrapper cho homepage)
- Section header: label "DỊCH VỤ", heading "Phương pháp chỉnh nha tại Pi Dentist"
- Chứa shortcode hoặc PHP query pi_service is_featured → render cards
- Vì Block Pattern không chạy PHP → dùng wp:query block hoặc Latest Posts block configured cho pi_service

Viết CSS tương ứng cho mỗi pattern.
```

---

## PROMPT 3.8 — Synced Patterns seed (5 patterns)

```
Tham chiếu PROJECT_SPEC_WP.md section 9.2.

Viết file `inc/synced-patterns-seed.php`:
- Hook admin_init, check option 'pi_synced_seeded'
- wp_insert_post post_type='wp_block' cho 5 synced patterns:

### 1. Pi - CTA Booking
Copy block markup từ spec section 9.2:
- Navy background, 2 columns
- Left: h2 "Bắt đầu hành trình nụ cười hoàn hảo", promo-badge, [fluentform id="1"]
- Right: [pi_contact_block] shortcode

### 2. Pi - Bảng giá so sánh
- Table so sánh 4 phương pháp (giống pricing-table nhưng simpler, dùng cho /dich-vu/ archive)

### 3. Pi - Thông tin liên hệ
- Block chứa: phone, email, address, giờ làm việc
- Dùng shortcodes [pi_phone], [pi_address] etc.

### 4. Pi - Giờ làm việc
- Bảng giờ: T2-T6: 8:00-20:00, T7: 8:00-17:00, CN: Nghỉ

### 5. Pi - Promo Banner
- Banner text ưu đãi khai trương

update_option('pi_synced_seeded', 1) sau khi seed xong.

Thêm require_once file này trong functions.php (sau block-patterns).
```

---

## PROMPT 3.9 — Shortcodes cho dynamic content

```
Viết đầy đủ file `inc/shortcodes.php`:

### Shortcodes cần tạo:
1. [pi_phone] → output get_theme_mod('pi_phone')
2. [pi_email] → output get_theme_mod('pi_email')
3. [pi_address] → output get_theme_mod('pi_address')
4. [pi_hours] → output bảng giờ làm việc 3 dòng từ Customizer
5. [pi_social_links] → output danh sách icon links từ Customizer (5 MXH)
6. [pi_contact_block] → output full block: phone + email + address + hours + social + map embed
   - Styled card format với icon trước mỗi item
7. [pi_year] → output date('Y') — dùng trong footer ©
8. [pi_services_grid] → output WP_Query pi_service is_featured → render service-card loop
9. [pi_doctors_carousel] → output WP_Query pi_doctor is_featured → render doctor-card loop (wrapper cho carousel JS)
10. [pi_recent_posts count="3"] → output WP_Query recent posts → render post-card loop
```

---

## PROMPT 3.10 — Compose homepage qua Block Editor

```
Hướng dẫn step-by-step để compose homepage:

### Precondition:
- Trang "Trang chủ" đã tạo (Page)
- Settings > Reading > Static front page > chọn "Trang chủ"

### Nội dung trang chủ trong Block Editor:
Chèn 11 sections theo thứ tự, mix Block Patterns + shortcodes:

1. Pattern: Pi - Hero Banner
2. Pattern: Pi - Cam kết grid (4 cột)
3. Pattern: Pi - Triết lý π
4. Shortcode block: [pi_doctors_carousel] — dynamic từ CPT pi_doctor
5. Pattern: Pi - Công nghệ (nền navy)
6. Shortcode block: [pi_services_grid] — dynamic từ CPT pi_service
7. Pattern: Pi - Simulation CTA
8. Pattern: Pi - Timeline 5 bước
9. Pattern: Pi - Bảng giá
10. Shortcode block: [pi_recent_posts count="3"] — dynamic từ Posts
11. Synced Pattern: Pi - CTA Booking (insert từ Patterns > Synced)

### Tạo script WP-CLI hoặc code để auto-compose:
File `inc/homepage-compose.php`:
- Kiểm tra option 'pi_homepage_composed'
- Tìm page "Trang chủ" hoặc tạo mới
- wp_update_post post_content với tất cả 11 block markup nối tiếp
- Set show_on_front = 'page', page_on_front = page_id
```

---

## PROMPT 3.11 — Carousel JS cho doctors section

```
Viết đầy đủ file `assets/js/carousel.js`:

Vanilla JS carousel cho doctors section (KHÔNG dùng Swiper/Slick):

1. Selector: .pi-carousel-container
2. Features:
   - Scroll horizontal smooth
   - Drag/swipe support (touch + mouse)
   - Navigation arrows (prev/next)
   - Dot indicators
   - Auto-play 5s interval (pause on hover/touch)
   - Snap to card
   - Responsive: desktop 3 cards visible, tablet 2, mobile 1
3. Kích thước card: min-width 300px, gap 24px
4. Arrows: position absolute, left/right -20px (hoặc overlay), styled circle 44px, navy background, gold arrow
5. Dots: bottom center, active dot = gold
6. Smooth transitions, no jank
7. Accessible: aria-label, role="region", keyboard navigation

CSS cho carousel có thể inline hoặc thêm vào sections.css.
```

---

**✅ PHASE 3 DONE khi:**
- [ ] Browse pidentist.local → trang chủ render 11 sections giống index.html
- [ ] Mobile responsive tất cả sections
- [ ] Block Editor admin: mở trang chủ thấy tất cả patterns
- [ ] Sửa heading hero trong editor → reflect frontend ngay
- [ ] Synced Pattern CTA Booking hiện cuối trang chủ
- [ ] Sửa Synced Pattern → reflect ở mọi nơi
- [ ] Carousel doctors swipe/drag hoạt động
- [ ] PageSpeed mobile ≥ 75
