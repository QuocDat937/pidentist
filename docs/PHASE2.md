# PHASE 2 — ĐĂNG KÝ CPT + TAXONOMIES + META + TEMPLATES (1–2 ngày)

> **Mục tiêu:** 3 CPT (pi_service, pi_doctor, pi_case) + 2 taxonomies + meta boxes + archive/single templates hoạt động.
> **Ref:** PROJECT_SPEC_WP.md — Section 5, 6, 7.4–7.6

---

## PROMPT 2.1 — Register 3 Custom Post Types

```
Tham chiếu PROJECT_SPEC_WP.md section 5.2.

Viết đầy đủ file `inc/cpt.php` đăng ký 3 CPT:

### CPT 1: pi_service — Dịch vụ chỉnh nha
- label: 'Dịch vụ'
- labels đầy đủ tiếng Việt (name, singular_name, add_new, add_new_item, edit_item, all_items, view_item, search_items, not_found, menu_name)
- public: true
- has_archive: 'dich-vu'
- rewrite: ['slug' => 'dich-vu', 'with_front' => false]
- menu_icon: 'dashicons-smiley'
- menu_position: 20
- supports: ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes']
- show_in_rest: true, rest_base: 'services'
- taxonomies: ['pi_service_category']

### CPT 2: pi_doctor — Bác sĩ
- label: 'Bác sĩ'
- labels đầy đủ tiếng Việt
- has_archive: 'bac-si'
- rewrite slug: 'bac-si'
- menu_icon: 'dashicons-businessperson'
- menu_position: 21
- supports: ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes']
- show_in_rest: true, rest_base: 'doctors'

### CPT 3: pi_case — Ca điều trị
- label: 'Ca điều trị'
- labels đầy đủ tiếng Việt
- has_archive: 'case'
- rewrite slug: 'case'
- menu_icon: 'dashicons-images-alt2'
- menu_position: 22
- supports: ['title', 'editor', 'thumbnail', 'excerpt']
- show_in_rest: true, rest_base: 'cases'

### Cuối file: Đổi blog base /kien-thuc/
add_action('init', function() {
    global $wp_rewrite;
    $wp_rewrite->set_permastruct('post', '/kien-thuc/%postname%/');
});

Wrap tất cả trong add_action('init', ...) priority 10.
```

---

## PROMPT 2.2 — Register 2 Taxonomies

```
Tham chiếu PROJECT_SPEC_WP.md section 5.3.

Viết đầy đủ file `inc/taxonomies.php`:

### Taxonomy 1: pi_service_category — Loại dịch vụ
- Attach to: ['pi_service']
- label: 'Loại dịch vụ'
- hierarchical: true (like categories)
- show_in_rest: true
- show_admin_column: true
- rewrite slug: 'loai-dich-vu'

### Taxonomy 2: pi_case_tag — Tag ca điều trị
- Attach to: ['pi_case']
- label: 'Tag ca'
- hierarchical: false (like tags)
- show_in_rest: true
- show_admin_column: true
- rewrite slug: 'tag-case'

### Seed default terms (chạy 1 lần):
Sau khi register, add_action('init') kiểm tra option 'pi_terms_seeded':
- pi_service_category: 'Mắc cài', 'Trong suốt', 'Mặt trong', 'Trẻ em'
- pi_case_tag: 'hô', 'móm', 'thưa', 'khấp khểnh', 'khớp cắn sâu', 'khớp cắn hở', 'tuổi teen', 'người lớn'
Dùng wp_insert_term() + update_option('pi_terms_seeded', true)
```

---

## PROMPT 2.3 — Register post meta + meta boxes cho pi_service

```
Tham chiếu PROJECT_SPEC_WP.md section 5.2 (dòng 580-688).

Viết đầy đủ file `inc/meta-fields.php`:

### Part 1: register_post_meta cho pi_service
- _pi_service_tagline (string)
- _pi_service_price_from (number, sanitize absint)
- _pi_service_duration (string)
- _pi_service_suitable_for (string)
- _pi_service_thumb_color (string)
- _pi_service_is_featured (boolean)
Tất cả: single true, show_in_rest true, auth_callback current_user_can edit_posts

### Part 2: register_post_meta cho pi_doctor
- _pi_doctor_title (string) — "Bác sĩ chỉnh nha"
- _pi_doctor_credentials (string) — Bằng cấp
- _pi_doctor_specialties (string) — Chuyên sâu
- _pi_doctor_is_featured (boolean)

### Part 3: register_post_meta cho pi_case
- _pi_case_patient_age (string) — "25 tuổi"
- _pi_case_patient_gender (string) — "male"/"female"
- _pi_case_duration (string) — "18 tháng"
- _pi_case_diagnosis (string)
- _pi_case_doctor_id (number)
- _pi_case_service_id (number)
- _pi_case_is_featured (boolean)

### Part 4: Meta Box cho pi_service
Copy code meta box từ PROJECT_SPEC_WP.md section 5.2 (dòng 612-687):
- add_meta_box 'pi_service_details' ở sidebar 'side' priority 'high'
- Render function: nonce, input fields cho tagline, price_from, duration, suitable_for, thumb_color (select 4 options), is_featured (checkbox)
- Save function trên hook save_post_pi_service: verify nonce, check autosave, check capability, update_post_meta cho tất cả fields

### Part 5: Meta Box cho pi_doctor
Tương tự structure:
- Fields: title, credentials, specialties, is_featured
- Save trên save_post_pi_doctor

### Part 6: Meta Box cho pi_case
- Fields: patient_age, patient_gender (select male/female), duration, diagnosis, doctor_id (dropdown posts pi_doctor), service_id (dropdown posts pi_service), is_featured
- Save trên save_post_pi_case
```

---

## PROMPT 2.4 — Template archive-pi_service.php + service-card.php

```
Tham chiếu PROJECT_SPEC_WP.md section 7.4–7.5.

Viết đầy đủ 2 file:

### 1. archive-pi_service.php
Copy từ spec section 7.4:
- get_header()
- <main class="pi-archive pi-archive-services">
- get_template_part page-hero với label 'DỊCH VỤ', heading 'Phương pháp chỉnh nha phù hợp cho bạn'
- <section class="services-archive"> .container > .services-grid
- Loop: have_posts → get_template_part card/service-card
- the_posts_pagination
- CTA Booking synced pattern cuối trang
- get_footer()

### 2. template-parts/card/service-card.php
Copy từ spec section 7.5:
- Get meta: thumb_color, tagline, price, suitable_for
- <article class="service-card reveal">
- Thumbnail link hoặc gradient placeholder theo thumb_color
- .service-body: h3 service-name link, p tagline, p price "Từ X triệu", p suitable, text-link "Tìm hiểu thêm →"

### 3. assets/css/patterns/services-grid.css
- .services-grid: display grid, grid-template-columns repeat(auto-fill, minmax(280px, 1fr)), gap 32px
- .services-archive: padding 80px 0
- .service-card: card styles (sử dụng base từ cards.css)
- .service-thumb: aspect-ratio 3/2, border-radius top 16px
- .service-thumb.metal: linear-gradient(135deg, #8D8D8D, #B5B5B5)
- .service-thumb.ceramic: linear-gradient(135deg, #F5E6C8, #DBC5A0)
- .service-thumb.clear: linear-gradient(135deg, #B8D4E3, #87CEEB)
- .service-thumb.lingual: linear-gradient(135deg, #2C2C2C, #4A4A2E)
- .service-body: padding 24px
- .service-name: font-family heading, 20px
- .service-tagline: color text-soft, 14px
- .service-price: font-weight 600, color var(--pi-navy), 18px
```

---

## PROMPT 2.5 — Template single-pi_service.php

```
Tham chiếu PROJECT_SPEC_WP.md section 7.6.

Viết đầy đủ file `single-pi_service.php`:
Copy structure từ spec section 7.6:

1. get_header()
2. Loop the_post → get meta: tagline, price, duration, suitable, advantages, disadvantages, faq
3. Page hero: label 'DỊCH VỤ', heading get_the_title(), sub tagline, breadcrumb true
4. <article class="service-detail"> .container
5. Quick info bar: .service-meta 3 meta-items (Giá từ, Thời gian, Phù hợp)
6. .service-description.prose → the_content()
7. Pros/Cons grid 2 columns (nếu có): .pros check-list ✓, .cons cross-list !
8. FAQ section (nếu có): <details> <summary> accordion
9. Related doctors: query pi_doctor where _pi_doctor_services LIKE service_id
10. Related cases: query pi_case where _pi_case_service_id = service_id
11. CTA Booking synced pattern
12. get_footer()

Thêm CSS cần thiết cho single-service layout (inline hoặc file riêng).
```

---

## PROMPT 2.6 — Templates archive/single cho pi_doctor + pi_case

```
Viết đầy đủ 6 file:

### 1. archive-pi_doctor.php
- Page hero: label 'ĐỘI NGŨ BÁC SĨ', heading 'Đội ngũ bác sĩ Pi Dentist'
- .doctors-grid: loop → doctor-card template part
- CTA Booking cuối trang

### 2. template-parts/card/doctor-card.php
- Get meta: _pi_doctor_title, _pi_doctor_credentials
- <article class="doctor-card reveal">
- Thumbnail (photo) hoặc placeholder avatar
- .doctor-body: h3 tên BS, p title, p credentials
- Link "Xem chi tiết →"

### 3. single-pi_doctor.php
- Page hero: label 'BÁC SĨ', heading tên BS
- Info panel: title, credentials, specialties
- the_content() — CV chi tiết
- Related services (query _pi_doctor_services)
- Related cases (query _pi_case_doctor_id)
- CTA Booking

### 4. archive-pi_case.php
- Page hero: label 'CASE ĐIỀU TRỊ', heading 'Khoảnh khắc Pi — Trước & Sau'
- Filter by pi_case_tag taxonomy (nếu có)
- .cases-grid: loop → case-card
- CTA Booking

### 5. template-parts/card/case-card.php
- Get meta: patient_age, duration, diagnosis
- <article class="case-card reveal">
- Thumbnail (before image)
- .case-body: h3 title, p diagnosis, p "Thời gian: X tháng"
- Link "Xem chi tiết →"

### 6. single-pi_case.php
- Page hero: label 'CASE ĐIỀU TRỊ', heading title
- Patient info: age, gender, duration
- Before/After gallery (tận dụng thumbnail + content images)
- Diagnosis + Treatment plan + Result (từ content)
- Related doctor + service link
- CTA Booking
```

---

## PROMPT 2.7 — Templates cho blog, page, search, 404

```
Viết đầy đủ 6 file:

### 1. archive.php (Blog listing /kien-thuc/)
- Page hero: label 'KIẾN THỨC', heading 'Blog chỉnh nha'
- .posts-grid: loop → post-card template part
- Pagination
- CTA Booking

### 2. single.php (Blog post detail)
- Page hero: label 'KIẾN THỨC', heading get_the_title(), breadcrumb true
- <article class="post-detail"> .container
- .post-meta: date, author, category, read time (ước tính từ word count)
- .post-content.prose → the_content()
- Tags (nếu có)
- Prev/Next post navigation
- Related posts (3 bài cùng category)
- CTA Booking

### 3. template-parts/card/post-card.php
- <article class="post-card reveal">
- Thumbnail
- .post-card-body: category badge, h3 title, excerpt 2 dòng, meta (date + read time)
- Link "Đọc thêm →"

### 4. page.php (Page mặc định)
- get_header()
- <main class="pi-page"> .container
- while have_posts: the_content()
- get_footer()

### 5. search.php
- Page hero: label 'TÌM KIẾM', heading 'Kết quả cho "' . get_search_query() . '"'
- Loop results → post-card
- No results message

### 6. 404.php
- <main class="pi-404"> .container text-align center
- Big π symbol (200px)
- Heading "Trang không tồn tại"
- Paragraph "Xin lỗi, trang bạn tìm không có hoặc đã được di chuyển."
- Search form
- Button "Về trang chủ"
- Styled với navy background hoặc off-white
```

---

## PROMPT 2.8 — Seed data test (wp-cli hoặc code)

```
Tạo file `inc/seed-data.php` (chạy 1 lần qua admin_init + option flag):

Seed dữ liệu test gồm:
- 4 services: "Niềng mắc cài kim loại", "Niềng mắc cài sứ", "Niềng trong suốt", "Niềng mặt trong"
  + Meta: price_from (25/35/45/65), duration, tagline, suitable_for, thumb_color (metal/ceramic/clear/lingual), is_featured
  + Assign pi_service_category tương ứng
- 3 doctors: "BS. Nguyễn Văn A", "BS. Trần Thị B", "BS. Lê Văn C"
  + Meta: title, credentials, specialties, is_featured
- 3 cases: "Case hô vẩu 18 tháng", "Case móm 24 tháng", "Case thưa 12 tháng"
  + Meta: patient_age, gender, duration, diagnosis, doctor_id, service_id
- 5 blog posts: 5 bài viết SEO về chỉnh nha (tiêu đề + excerpt giả)
  + Category "Kiến thức"

Dùng wp_insert_post + update_post_meta.
Kiểm tra option 'pi_seed_data_v1' để chỉ chạy 1 lần.

SAU KHI seed xong → vào Settings > Permalinks > Save để flush rewrite rules.
```

---

**✅ PHASE 2 DONE khi:**
- [ ] WP Admin sidebar có 3 menu: Dịch vụ, Bác sĩ, Ca điều trị
- [ ] Tạo 1 service → hiển thị /dich-vu/ archive + /dich-vu/slug/ single
- [ ] Meta box sidebar hiện đủ fields khi edit service
- [ ] Taxonomy filter hoạt động trên admin list
- [ ] /bac-si/ + /case/ archives render đúng
- [ ] /kien-thuc/ blog archive hoạt động
- [ ] 404 page styled đẹp
- [ ] Search hoạt động
