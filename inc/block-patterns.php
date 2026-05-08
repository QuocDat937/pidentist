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

	// ═══════════════════════════════════════════════
	// PATTERN 3: Pi - Philosophy 2-column
	// ═══════════════════════════════════════════════
	register_block_pattern( 'pi/philosophy', [
		'title'       => 'Pi - Triết lý π (2 columns)',
		'description' => 'Section triết lý: ký tự π lớn bên trái, text giải thích bên phải',
		'categories'  => [ 'pi-homepage', 'pi-sections' ],
		'keywords'    => [ 'triết lý', 'philosophy', 'pi', 'về chúng tôi' ],
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
	// PATTERN 4: Pi - Technology (nền navy)
	// ═══════════════════════════════════════════════
	register_block_pattern( 'pi/technology-navy', [
		'title'       => 'Pi - Công nghệ (nền navy)',
		'description' => 'Section công nghệ & tiêu chuẩn quốc tế — 3 cột tech cards trên nền navy',
		'categories'  => [ 'pi-homepage', 'pi-sections' ],
		'keywords'    => [ 'công nghệ', 'technology', 'CBCT', 'scanner', 'AI' ],
		'content'     => '
<!-- wp:group {"className":"technology pi-navy-bg","style":{"color":{"background":"#002147","text":"#ffffff"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group technology pi-navy-bg has-text-color has-background" style="color:#ffffff;background-color:#002147">
  <!-- wp:group {"className":"section-header","layout":{"type":"constrained"}} -->
  <div class="wp-block-group section-header">
    <!-- wp:paragraph {"className":"section-label section-label-gold"} -->
    <p class="section-label section-label-gold">CÔNG NGHỆ &amp; TIÊU CHUẨN</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":2,"className":"section-heading section-heading-white"} -->
    <h2 class="wp-block-heading section-heading section-heading-white">Đầu tư từ ngày đầu —<br>không thỏa hiệp về tiêu chuẩn</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"className":"section-sub section-sub-white"} -->
    <p class="section-sub section-sub-white">Trang thiết bị hiện đại nhất, đáp ứng chuẩn quốc tế về chẩn đoán và điều trị chỉnh nha</p>
    <!-- /wp:paragraph -->
    <!-- wp:html -->
    <div class="gold-line"></div>
    <!-- /wp:html -->
  </div>
  <!-- /wp:group -->

  <!-- wp:group {"className":"tech-grid","layout":{"type":"grid","columnCount":3}} -->
  <div class="wp-block-group tech-grid">

    <!-- wp:group {"className":"tech-card"} -->
    <div class="wp-block-group tech-card">
      <!-- wp:html -->
      <div class="tech-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 2a15 15 0 0 1 4 10 15 15 0 0 1-4 10 15 15 0 0 1-4-10A15 15 0 0 1 12 2z"/><path d="M2 12h20"/></svg></div>
      <!-- /wp:html -->
      <!-- wp:heading {"level":3,"className":"tech-title"} -->
      <h3 class="wp-block-heading tech-title">CBCT 3D Scanner</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"tech-desc"} -->
      <p class="tech-desc">Chụp X-quang 3 chiều toàn hàm, chẩn đoán chính xác tuyệt đối cấu trúc xương, chân răng và đường thở.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"tech-card"} -->
    <div class="wp-block-group tech-card">
      <!-- wp:html -->
      <div class="tech-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 8h4M7 12h10M7 16h6"/></svg></div>
      <!-- /wp:html -->
      <!-- wp:heading {"level":3,"className":"tech-title"} -->
      <h3 class="wp-block-heading tech-title">Scan kỹ thuật số iTero</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"tech-desc"} -->
      <p class="tech-desc">Lấy dấu không cần bột, thoải mái và chính xác hơn 10 lần so với phương pháp truyền thống.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"tech-card"} -->
    <div class="wp-block-group tech-card">
      <!-- wp:html -->
      <div class="tech-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
      <!-- /wp:html -->
      <!-- wp:heading {"level":3,"className":"tech-title"} -->
      <h3 class="wp-block-heading tech-title">Phần mềm AI lập kế hoạch</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"className":"tech-desc"} -->
      <p class="tech-desc">Mô phỏng kết quả trước khi bắt đầu điều trị. Bạn thấy trước nụ cười tương lai ngay tại phòng khám.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

  </div>
  <!-- /wp:group -->

  <!-- wp:group {"className":"tech-cta","layout":{"type":"constrained"}} -->
  <div class="wp-block-group tech-cta">
    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
      <!-- wp:button {"className":"btn btn-ghost-white"} -->
      <div class="wp-block-button btn btn-ghost-white"><a class="wp-block-button__link" href="/lien-he/">Tham quan phòng khám →</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->

</div>
<!-- /wp:group -->
		',
	] );

	// ═══════════════════════════════════════════════
	// PATTERN 5: Pi - Bảng giá (table + mobile cards)
	// ═══════════════════════════════════════════════
	register_block_pattern( 'pi/pricing-table', [
		'title'       => 'Pi - Bảng giá (table)',
		'description' => 'Bảng giá so sánh 4 phương pháp — desktop table + mobile cards + installment box',
		'categories'  => [ 'pi-homepage', 'pi-sections' ],
		'keywords'    => [ 'bảng giá', 'pricing', 'giá', 'so sánh' ],
		'content'     => '
<!-- wp:group {"className":"pricing","layout":{"type":"constrained"}} -->
<div class="wp-block-group pricing">
  <!-- wp:group {"className":"section-header","layout":{"type":"constrained"}} -->
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
          <th>Đặc điểm nổi bật</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Mắc cài kim loại</strong></td>
          <td class="price-cell">XX triệu</td>
          <td>18–24 tháng</td>
          <td>Hiệu quả cao nhất, phù hợp mọi ca</td>
          <td><a href="/lien-he/" class="btn btn-gold">Đặt lịch</a></td>
        </tr>
        <tr>
          <td><strong>Mắc cài sứ</strong></td>
          <td class="price-cell">XX triệu</td>
          <td>18–24 tháng</td>
          <td>Thẩm mỹ hơn, ít nhìn thấy</td>
          <td><a href="/lien-he/" class="btn btn-gold">Đặt lịch</a></td>
        </tr>
        <tr class="highlight">
          <td><strong>Niềng trong suốt</strong></td>
          <td class="price-cell">XX triệu</td>
          <td>12–18 tháng</td>
          <td>Gần vô hình, tháo lắp dễ dàng</td>
          <td><a href="/lien-he/" class="btn btn-gold">Đặt lịch</a></td>
        </tr>
        <tr>
          <td><strong>Niềng mặt trong</strong></td>
          <td class="price-cell">XX triệu</td>
          <td>18–24 tháng</td>
          <td>Hoàn toàn ẩn, bí mật tuyệt đối</td>
          <td><a href="/lien-he/" class="btn btn-gold">Đặt lịch</a></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- /wp:html -->

  <!-- wp:html -->
  <div class="pricing-cards-mobile">
    <div class="pricing-card-m">
      <h3 class="method-name">Mắc cài kim loại</h3>
      <p class="method-price">Từ XX triệu</p>
      <p class="method-detail">⏱ 18–24 tháng</p>
      <p class="method-detail">✦ Hiệu quả cao nhất, phù hợp mọi ca</p>
      <a href="/lien-he/" class="btn btn-gold">Đặt lịch tư vấn</a>
    </div>
    <div class="pricing-card-m">
      <h3 class="method-name">Mắc cài sứ</h3>
      <p class="method-price">Từ XX triệu</p>
      <p class="method-detail">⏱ 18–24 tháng</p>
      <p class="method-detail">✦ Thẩm mỹ hơn, ít nhìn thấy</p>
      <a href="/lien-he/" class="btn btn-gold">Đặt lịch tư vấn</a>
    </div>
    <div class="pricing-card-m highlight-card">
      <h3 class="method-name">Niềng trong suốt</h3>
      <p class="method-price">Từ XX triệu</p>
      <p class="method-detail">⏱ 12–18 tháng</p>
      <p class="method-detail">✦ Gần vô hình, tháo lắp dễ dàng</p>
      <a href="/lien-he/" class="btn btn-gold">Đặt lịch tư vấn</a>
    </div>
    <div class="pricing-card-m">
      <h3 class="method-name">Niềng mặt trong</h3>
      <p class="method-price">Từ XX triệu</p>
      <p class="method-detail">⏱ 18–24 tháng</p>
      <p class="method-detail">✦ Hoàn toàn ẩn, bí mật tuyệt đối</p>
      <a href="/lien-he/" class="btn btn-gold">Đặt lịch tư vấn</a>
    </div>
  </div>
  <!-- /wp:html -->

  <!-- wp:html -->
  <div class="installment-box">
    <h3>Trả góp <span class="gold-highlight">0% lãi suất</span></h3>
    <p>Chỉ từ <span class="gold-highlight">X triệu/tháng</span> — Hỗ trợ trả góp qua thẻ tín dụng và công ty tài chính</p>
  </div>
  <!-- /wp:html -->

  <!-- wp:html -->
  <div class="trust-badges">
    <div class="trust-badge">
      <span class="badge-icon">✓</span>
      Cam kết không phát sinh
    </div>
    <div class="trust-badge">
      <span class="badge-icon">★</span>
      Bảo hành kết quả
    </div>
    <div class="trust-badge">
      <span class="badge-icon">%</span>
      Trả góp 0%
    </div>
  </div>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->
		',
	] );

}
