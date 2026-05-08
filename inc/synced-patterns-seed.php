<?php
/**
 * Pi Dentist — Synced Patterns Seed
 *
 * Tạo 5 Synced Patterns (wp_block) để tái sử dụng trên toàn site.
 * Chạy 1 lần qua admin_init → check option 'pi_synced_seeded'.
 *
 * Synced Patterns:
 * 1. Pi - CTA Booking          → Cuối trang chủ + mọi trang con
 * 2. Pi - Bảng giá so sánh     → Trang chủ, /dich-vu/, /bang-gia/
 * 3. Pi - Thông tin liên hệ    → Footer, /lien-he/, booking section
 * 4. Pi - Giờ làm việc         → Footer, /lien-he/, Google Map area
 * 5. Pi - Promo Banner         → Top header, booking CTA
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'pi_seed_synced_patterns' );

/**
 * Seed 5 Synced Patterns vào DB (post_type = wp_block).
 * Chỉ chạy 1 lần — check option 'pi_synced_seeded'.
 */
function pi_seed_synced_patterns() {

	if ( get_option( 'pi_synced_seeded' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Đặt flag NGAY ĐẦU để tránh race condition.
	update_option( 'pi_synced_seeded', 1 );

	// ═══════════════════════════════════════════════
	// 1. Pi - CTA Booking
	// Navy background, 2 columns: form + contact info
	// Ref: PROJECT_SPEC_WP.md section 9.2
	// ═══════════════════════════════════════════════
	wp_insert_post( [
		'post_title'   => 'Pi - CTA Booking',
		'post_name'    => 'pi-cta-booking',
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
      <!-- wp:shortcode -->
      [pi_contact_block]
      <!-- /wp:shortcode -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
		',
	] );

	// ═══════════════════════════════════════════════
	// 2. Pi - Bảng giá so sánh
	// Table so sánh 4 phương pháp (simpler, dùng cho /dich-vu/ archive)
	// ═══════════════════════════════════════════════
	wp_insert_post( [
		'post_title'   => 'Pi - Bảng giá so sánh',
		'post_name'    => 'pi-pricing-comparison',
		'post_status'  => 'publish',
		'post_type'    => 'wp_block',
		'post_content' => '
<!-- wp:group {"className":"pricing-comparison","layout":{"type":"constrained"}} -->
<div class="wp-block-group pricing-comparison">
  <!-- wp:group {"className":"section-header","layout":{"type":"constrained"}} -->
  <div class="wp-block-group section-header">
    <!-- wp:paragraph {"className":"section-label"} -->
    <p class="section-label">SO SÁNH PHƯƠNG PHÁP</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":2,"className":"section-heading"} -->
    <h2 class="wp-block-heading section-heading">Chọn phương pháp phù hợp với bạn</h2>
    <!-- /wp:heading -->
    <!-- wp:html -->
    <div class="gold-line"></div>
    <!-- /wp:html -->
  </div>
  <!-- /wp:group -->

  <!-- wp:html -->
  <div class="pricing-table-wrap">
    <table class="pricing-table">
      <thead>
        <tr>
          <th>Phương pháp</th>
          <th>Giá từ</th>
          <th>Thời gian</th>
          <th>Thẩm mỹ</th>
          <th>Phù hợp</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Mắc cài kim loại</strong></td>
          <td class="price-cell">Từ 25 triệu</td>
          <td>18–24 tháng</td>
          <td>⭐⭐</td>
          <td>Mọi trường hợp</td>
        </tr>
        <tr>
          <td><strong>Mắc cài sứ</strong></td>
          <td class="price-cell">Từ 35 triệu</td>
          <td>18–24 tháng</td>
          <td>⭐⭐⭐</td>
          <td>Người đi làm</td>
        </tr>
        <tr class="highlight">
          <td><strong>Niềng trong suốt</strong></td>
          <td class="price-cell">Từ 45 triệu</td>
          <td>12–18 tháng</td>
          <td>⭐⭐⭐⭐⭐</td>
          <td>Người trưởng thành, Gen Z</td>
        </tr>
        <tr>
          <td><strong>Niềng mặt trong</strong></td>
          <td class="price-cell">Từ 65 triệu</td>
          <td>18–30 tháng</td>
          <td>⭐⭐⭐⭐⭐</td>
          <td>Yêu cầu thẩm mỹ tuyệt đối</td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- /wp:html -->
</div>
<!-- /wp:group -->
		',
	] );

	// ═══════════════════════════════════════════════
	// 3. Pi - Thông tin liên hệ
	// Block chứa: phone, email, address, giờ làm việc
	// Dùng shortcodes dynamic từ Customizer
	// ═══════════════════════════════════════════════
	wp_insert_post( [
		'post_title'   => 'Pi - Thông tin liên hệ',
		'post_name'    => 'pi-contact-info',
		'post_status'  => 'publish',
		'post_type'    => 'wp_block',
		'post_content' => '
<!-- wp:group {"className":"contact-info-block","layout":{"type":"constrained"}} -->
<div class="wp-block-group contact-info-block">
  <!-- wp:heading {"level":3,"className":"contact-info-title"} -->
  <h3 class="wp-block-heading contact-info-title">Thông tin liên hệ</h3>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div class="contact-info-list">
    <div class="contact-info-item">
      <span class="contact-info-icon">📞</span>
      <div class="contact-info-content">
        <span class="contact-info-label">Hotline</span>
        <a href="tel:[pi_phone]" class="contact-info-value">[pi_phone]</a>
      </div>
    </div>
    <div class="contact-info-item">
      <span class="contact-info-icon">✉️</span>
      <div class="contact-info-content">
        <span class="contact-info-label">Email</span>
        <a href="mailto:[pi_email]" class="contact-info-value">[pi_email]</a>
      </div>
    </div>
    <div class="contact-info-item">
      <span class="contact-info-icon">📍</span>
      <div class="contact-info-content">
        <span class="contact-info-label">Địa chỉ</span>
        <span class="contact-info-value">[pi_address]</span>
      </div>
    </div>
    <div class="contact-info-item">
      <span class="contact-info-icon">🕐</span>
      <div class="contact-info-content">
        <span class="contact-info-label">Giờ làm việc</span>
        <span class="contact-info-value">[pi_hours]</span>
      </div>
    </div>
  </div>
  <!-- /wp:html -->

  <!-- wp:shortcode -->
  [pi_social_links]
  <!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
		',
	] );

	// ═══════════════════════════════════════════════
	// 4. Pi - Giờ làm việc
	// Bảng giờ: T2-T6, T7, CN
	// ═══════════════════════════════════════════════
	wp_insert_post( [
		'post_title'   => 'Pi - Giờ làm việc',
		'post_name'    => 'pi-business-hours',
		'post_status'  => 'publish',
		'post_type'    => 'wp_block',
		'post_content' => '
<!-- wp:group {"className":"business-hours-block","layout":{"type":"constrained"}} -->
<div class="wp-block-group business-hours-block">
  <!-- wp:heading {"level":3,"className":"hours-title"} -->
  <h3 class="wp-block-heading hours-title">Giờ làm việc</h3>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <table class="hours-table">
    <tbody>
      <tr>
        <td class="hours-day">Thứ 2 – Thứ 6</td>
        <td class="hours-time">8:00 – 20:00</td>
      </tr>
      <tr>
        <td class="hours-day">Thứ 7</td>
        <td class="hours-time">8:00 – 17:00</td>
      </tr>
      <tr class="hours-closed">
        <td class="hours-day">Chủ nhật</td>
        <td class="hours-time">Nghỉ</td>
      </tr>
    </tbody>
  </table>
  <!-- /wp:html -->
</div>
<!-- /wp:group -->
		',
	] );

	// ═══════════════════════════════════════════════
	// 5. Pi - Promo Banner
	// Banner text ưu đãi khai trương
	// ═══════════════════════════════════════════════
	wp_insert_post( [
		'post_title'   => 'Pi - Promo Banner',
		'post_name'    => 'pi-promo-banner',
		'post_status'  => 'publish',
		'post_type'    => 'wp_block',
		'post_content' => '
<!-- wp:group {"className":"promo-banner-block","layout":{"type":"constrained"}} -->
<div class="wp-block-group promo-banner-block">
  <!-- wp:html -->
  <div class="promo-banner-inner">
    <span class="promo-emoji">🎉</span>
    <span class="promo-banner-text"><strong>Ưu đãi khai trương:</strong> Scan 3D miễn phí + Giảm 20% phí điều trị cho 50 khách hàng đầu tiên</span>
    <a href="/lien-he/" class="promo-banner-cta">Đặt lịch ngay →</a>
  </div>
  <!-- /wp:html -->
</div>
<!-- /wp:group -->
		',
	] );

	// Admin notice.
	add_action( 'admin_notices', function () {
		echo '<div class="notice notice-success is-dismissible"><p><strong>Pi Dentist:</strong> 5 Synced Patterns đã được tạo thành công! (CTA Booking, Bảng giá, Liên hệ, Giờ làm việc, Promo Banner)</p></div>';
	} );
}
