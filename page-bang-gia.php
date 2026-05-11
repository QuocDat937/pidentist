<?php
/**
 * Pi Dentist — Trang Bảng Giá
 *
 * Template Name: Trang Bảng Giá
 * Slug: page-bang-gia
 *
 * Custom page template cho /bang-gia/.
 * Render: page hero → pricing table (desktop/mobile) → chi phí bao gồm → trả góp → CTA.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<?php
// Page Hero
get_template_part( 'template-parts/section/page-hero', null, array(
	'label'      => 'BẢNG GIÁ',
	'heading'    => 'Bảng giá dịch vụ chỉnh nha',
	'sub'        => 'Minh bạch từ chi phí đến kết quả — cam kết không phát sinh',
	'breadcrumb' => true,
) );
?>

<main class="pi-pricing-page" id="main-content">

	<!-- ══════════════════════════════════════════════
	     Section 1: Bảng giá chi tiết theo phương pháp
	     ══════════════════════════════════════════════ -->
	<section class="pricing-detail pi-section" aria-label="Bảng giá chi tiết">
		<div class="container">

			<!-- Section Header -->
			<div class="section-header">
				<p class="section-label">CHI TIẾT BẢNG GIÁ</p>
				<h2 class="section-heading">Bảng giá chi tiết theo phương pháp</h2>
				<p class="section-sub">4 phương pháp × 3 mức độ — giá niêm yết là giá cuối cùng</p>
				<div class="gold-line"></div>
			</div>

			<!-- Desktop Table -->
			<div class="pricing-page-table-wrap">
				<table class="pricing-page-table">
					<thead>
						<tr>
							<th>Phương pháp</th>
							<th>Mức độ</th>
							<th>Giá từ</th>
							<th>Giá đến</th>
							<th>Thời gian</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<!-- Niềng mắc cài kim loại (3 rows) -->
						<tr class="method-first-row">
							<td class="method-name-cell" rowspan="3">
								<a href="<?php echo esc_url( home_url( '/dich-vu/mac-cai-kim-loai/' ) ); ?>" class="method-link">Niềng mắc cài kim loại</a>
							</td>
							<td><span class="level-badge level-nhe">Nhẹ</span></td>
							<td class="price-cell">25 triệu</td>
							<td class="price-cell">35 triệu</td>
							<td>18–24 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-tb">Trung bình</span></td>
							<td class="price-cell">35 triệu</td>
							<td class="price-cell">45 triệu</td>
							<td>18–24 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-kho">Khó</span></td>
							<td class="price-cell">45 triệu</td>
							<td class="price-cell">60 triệu</td>
							<td>18–24 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>

						<!-- Niềng mắc cài sứ (3 rows) -->
						<tr class="method-first-row">
							<td class="method-name-cell" rowspan="3">
								<a href="<?php echo esc_url( home_url( '/dich-vu/mac-cai-su/' ) ); ?>" class="method-link">Niềng mắc cài sứ</a>
							</td>
							<td><span class="level-badge level-nhe">Nhẹ</span></td>
							<td class="price-cell">35 triệu</td>
							<td class="price-cell">45 triệu</td>
							<td>18–24 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-tb">Trung bình</span></td>
							<td class="price-cell">45 triệu</td>
							<td class="price-cell">55 triệu</td>
							<td>18–24 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-kho">Khó</span></td>
							<td class="price-cell">55 triệu</td>
							<td class="price-cell">70 triệu</td>
							<td>18–24 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>

						<!-- Niềng trong suốt (3 rows) -->
						<tr class="method-first-row">
							<td class="method-name-cell" rowspan="3">
								<a href="<?php echo esc_url( home_url( '/dich-vu/nieng-trong-suot/' ) ); ?>" class="method-link">Niềng trong suốt</a>
							</td>
							<td><span class="level-badge level-nhe">Nhẹ</span></td>
							<td class="price-cell">50 triệu</td>
							<td class="price-cell">65 triệu</td>
							<td>12–18 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-tb">Trung bình</span></td>
							<td class="price-cell">65 triệu</td>
							<td class="price-cell">85 triệu</td>
							<td>12–18 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-kho">Khó</span></td>
							<td class="price-cell">85 triệu</td>
							<td class="price-cell">120 triệu</td>
							<td>12–18 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>

						<!-- Niềng mặt trong (3 rows) -->
						<tr class="method-first-row">
							<td class="method-name-cell" rowspan="3">
								<a href="<?php echo esc_url( home_url( '/dich-vu/nieng-mat-trong/' ) ); ?>" class="method-link">Niềng mặt trong</a>
							</td>
							<td><span class="level-badge level-nhe">Nhẹ</span></td>
							<td class="price-cell">80 triệu</td>
							<td class="price-cell">100 triệu</td>
							<td>20–30 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-tb">Trung bình</span></td>
							<td class="price-cell">100 triệu</td>
							<td class="price-cell">130 triệu</td>
							<td>20–30 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
						<tr>
							<td><span class="level-badge level-kho">Khó</span></td>
							<td class="price-cell">130 triệu</td>
							<td class="price-cell">180 triệu</td>
							<td>20–30 tháng</td>
							<td><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold btn-sm">Đặt lịch</a></td>
						</tr>
					</tbody>
				</table>
			</div><!-- .pricing-page-table-wrap -->

			<!-- Mobile Cards -->
			<div class="pricing-page-cards-mobile">
				<?php
				$methods = array(
					array(
						'name'     => 'Niềng mắc cài kim loại',
						'slug'     => 'mac-cai-kim-loai',
						'duration' => '18–24 tháng',
						'levels'   => array(
							array( 'label' => 'Nhẹ',       'class' => 'level-nhe', 'from' => '25 triệu', 'to' => '35 triệu' ),
							array( 'label' => 'Trung bình','class' => 'level-tb',  'from' => '35 triệu', 'to' => '45 triệu' ),
							array( 'label' => 'Khó',       'class' => 'level-kho', 'from' => '45 triệu', 'to' => '60 triệu' ),
						),
					),
					array(
						'name'     => 'Niềng mắc cài sứ',
						'slug'     => 'mac-cai-su',
						'duration' => '18–24 tháng',
						'levels'   => array(
							array( 'label' => 'Nhẹ',       'class' => 'level-nhe', 'from' => '35 triệu', 'to' => '45 triệu' ),
							array( 'label' => 'Trung bình','class' => 'level-tb',  'from' => '45 triệu', 'to' => '55 triệu' ),
							array( 'label' => 'Khó',       'class' => 'level-kho', 'from' => '55 triệu', 'to' => '70 triệu' ),
						),
					),
					array(
						'name'     => 'Niềng trong suốt',
						'slug'     => 'nieng-trong-suot',
						'duration' => '12–18 tháng',
						'levels'   => array(
							array( 'label' => 'Nhẹ',       'class' => 'level-nhe', 'from' => '50 triệu', 'to' => '65 triệu' ),
							array( 'label' => 'Trung bình','class' => 'level-tb',  'from' => '65 triệu', 'to' => '85 triệu' ),
							array( 'label' => 'Khó',       'class' => 'level-kho', 'from' => '85 triệu', 'to' => '120 triệu' ),
						),
					),
					array(
						'name'     => 'Niềng mặt trong',
						'slug'     => 'nieng-mat-trong',
						'duration' => '20–30 tháng',
						'levels'   => array(
							array( 'label' => 'Nhẹ',       'class' => 'level-nhe', 'from' => '80 triệu',  'to' => '100 triệu' ),
							array( 'label' => 'Trung bình','class' => 'level-tb',  'from' => '100 triệu', 'to' => '130 triệu' ),
							array( 'label' => 'Khó',       'class' => 'level-kho', 'from' => '130 triệu', 'to' => '180 triệu' ),
						),
					),
				);

				foreach ( $methods as $method ) :
				?>
				<div class="pricing-m-card">
					<div class="pricing-m-card__header">
						<h3 class="pricing-m-card__title">
							<a href="<?php echo esc_url( home_url( '/dich-vu/' . $method['slug'] . '/' ) ); ?>">
								<?php echo esc_html( $method['name'] ); ?>
							</a>
						</h3>
						<span class="pricing-m-card__duration">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
							<?php echo esc_html( $method['duration'] ); ?>
						</span>
					</div>
					<div class="pricing-m-card__body">
						<?php foreach ( $method['levels'] as $level ) : ?>
						<div class="pricing-m-card__row">
							<span class="level-badge <?php echo esc_attr( $level['class'] ); ?>"><?php echo esc_html( $level['label'] ); ?></span>
							<span class="pricing-m-card__price"><?php echo esc_html( $level['from'] ); ?> – <?php echo esc_html( $level['to'] ); ?></span>
						</div>
						<?php endforeach; ?>
					</div>
					<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold pricing-m-card__cta">Đặt lịch</a>
				</div>
				<?php endforeach; ?>
			</div><!-- .pricing-page-cards-mobile -->

		</div>
	</section>

	<!-- ══════════════════════════════════════════════
	     Section 2: Đã bao gồm trong giá niêm yết
	     ══════════════════════════════════════════════ -->
	<section class="pricing-included pi-section" aria-label="Chi phí bao gồm">
		<div class="container">

			<!-- Section Header -->
			<div class="section-header">
				<p class="section-label">CHI PHÍ BAO GỒM</p>
				<h2 class="section-heading">Đã bao gồm trong giá niêm yết</h2>
				<p class="section-sub">Toàn bộ chi phí điều trị được tính trọn gói — không phát sinh bất kỳ khoản nào</p>
				<div class="gold-line"></div>
			</div>

			<div class="included-grid">
				<div class="included-item">
					<span class="included-check" aria-hidden="true">✓</span>
					<span>Khám và chẩn đoán ban đầu</span>
				</div>
				<div class="included-item">
					<span class="included-check" aria-hidden="true">✓</span>
					<span>Chụp X-quang CBCT 3D toàn hàm</span>
				</div>
				<div class="included-item">
					<span class="included-check" aria-hidden="true">✓</span>
					<span>Scan kỹ thuật số lấy dấu răng</span>
				</div>
				<div class="included-item">
					<span class="included-check" aria-hidden="true">✓</span>
					<span>Khí cụ chỉnh nha (mắc cài/khay niềng)</span>
				</div>
				<div class="included-item">
					<span class="included-check" aria-hidden="true">✓</span>
					<span>Tái khám định kỳ trong suốt quá trình</span>
				</div>
				<div class="included-item">
					<span class="included-check" aria-hidden="true">✓</span>
					<span>Hàm duy trì (retainer) sau điều trị</span>
				</div>
				<div class="included-item included-item--center">
					<span class="included-check" aria-hidden="true">✓</span>
					<span>Bảo hành kết quả theo cam kết</span>
				</div>
			</div>

		</div>
	</section>

	<!-- ══════════════════════════════════════════════
	     Section 3: Trả góp 0% lãi suất
	     ══════════════════════════════════════════════ -->
	<section class="pricing-installment pi-section" aria-label="Trả góp">
		<div class="container">

			<!-- Section Header -->
			<div class="section-header">
				<p class="section-label">TRẢ GÓP</p>
				<h2 class="section-heading">Trả góp 0% lãi suất</h2>
				<p class="section-sub">Hỗ trợ trả góp qua thẻ tín dụng và công ty tài chính — không lãi suất, không phí ẩn</p>
				<div class="gold-line"></div>
			</div>

			<!-- Installment Navy Box -->
			<div class="installment-navy-box">
				<div class="installment-navy-header">
					<h3>Trả góp <span class="gold-text">0% lãi suất</span></h3>
					<p>Hỗ trợ trả góp qua thẻ tín dụng và công ty tài chính — không lãi suất, không phí ẩn</p>
				</div>
				<div class="installment-table-wrap">
					<table class="installment-table">
						<thead>
							<tr>
								<th>Kỳ hạn</th>
								<th>Trả mỗi tháng (VD: gói 60 triệu)</th>
								<th>Ghi chú</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>12 tháng</td>
								<td>~5 triệu/tháng</td>
								<td><em>Phổ biến nhất</em></td>
							</tr>
							<tr>
								<td>18 tháng</td>
								<td>~3.3 triệu/tháng</td>
								<td><em>Linh hoạt</em></td>
							</tr>
							<tr>
								<td>24 tháng</td>
								<td>~2.5 triệu/tháng</td>
								<td><em>Tiết kiệm nhất</em></td>
							</tr>
						</tbody>
					</table>
				</div>
				<p class="installment-note">* Số tiền trả góp mỗi tháng phụ thuộc vào tổng chi phí điều trị thực tế</p>
			</div>

		</div>
	</section>

	<!-- ══════════════════════════════════════════════
	     Section 4: CTA cuối trang
	     ══════════════════════════════════════════════ -->
	<section class="pricing-cta pi-section pi-navy-bg" aria-label="Đặt lịch tư vấn">
		<div class="container">
			<div class="pricing-cta-content">
				<p class="pricing-cta-text">Bác sĩ sẽ tư vấn phương pháp phù hợp nhất và báo giá chính xác cho bạn</p>
				<div class="pricing-cta-buttons">
					<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold">Đặt lịch tư vấn miễn phí</a>
					<?php
					$phone       = get_theme_mod( 'pi_phone', '0909 XXX XXX' );
					$phone_clean = preg_replace( '/[^0-9+]/', '', $phone );
					?>
					<a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="btn btn-outline-white"><?php echo esc_html( $phone ); ?></a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer();
