<?php
/**
 * Pi Dentist — Block Patterns
 *
 * Đăng ký các Block Patterns cho trang chủ và sections.
 * Mỗi pattern = "stamp" — admin insert vào page, sửa độc lập.
 *
 * Pattern CSS tương ứng nằm trong assets/css/patterns/
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'pi_register_block_patterns' );

function pi_register_block_patterns() {

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
		'keywords'    => [ 'cam kết', 'commitments', 'grid', '4 cột' ],
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

}
