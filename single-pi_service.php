<?php
/**
 * Pi Dentist — Single: Dịch vụ (pi_service)
 *
 * Chi tiết 1 dịch vụ chỉnh nha tại /dich-vu/{slug}/.
 * Layout: Page Hero → Quick Info → Content → Pros/Cons → FAQ
 *         → Related Doctors → Related Cases → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	// ─── Get all meta ─────────────────────────────────────────────────
	$service_id   = get_the_ID();
	$tagline      = get_post_meta( $service_id, '_pi_service_tagline', true );
	$price_from   = get_post_meta( $service_id, '_pi_service_price_from', true );
	$duration     = get_post_meta( $service_id, '_pi_service_duration', true );
	$suitable_for = get_post_meta( $service_id, '_pi_service_suitable_for', true );
?>

<main class="pi-single pi-single-service" id="main-content">

	<?php
	// ─── 1. Page Hero ─────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'DỊCH VỤ',
		'heading'    => get_the_title(),
		'sub'        => $tagline,
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── 2. Service Detail Article ─────────────────────────────── -->
	<article class="service-detail">
		<div class="container">

			<?php // ─── Quick Info Bar ─────────────────────────────────── ?>
			<?php if ( $price_from || $duration || $suitable_for ) : ?>
				<div class="service-meta reveal">
					<?php if ( $price_from ) : ?>
						<div class="meta-item">
							<span class="meta-icon" aria-hidden="true">💰</span>
							<div class="meta-text">
								<span class="meta-label">Giá từ</span>
								<span class="meta-value"><?php echo esc_html( number_format( $price_from, 0, ',', '.' ) ); ?> triệu</span>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $duration ) : ?>
						<div class="meta-item">
							<span class="meta-icon" aria-hidden="true">⏱️</span>
							<div class="meta-text">
								<span class="meta-label">Thời gian</span>
								<span class="meta-value"><?php echo esc_html( $duration ); ?></span>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $suitable_for ) : ?>
						<div class="meta-item">
							<span class="meta-icon" aria-hidden="true">👤</span>
							<div class="meta-text">
								<span class="meta-label">Phù hợp</span>
								<span class="meta-value"><?php echo esc_html( $suitable_for ); ?></span>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php // ─── Main Content (Editor content) ───────────────── ?>
			<div class="service-description prose reveal">
				<?php the_content(); ?>
			</div>

			<?php
			// ─── Pros / Cons Grid ─────────────────────────────────────
			// Content authors can add advantages/disadvantages via
			// the Block Editor. We also support a structured approach
			// using post meta (serialised JSON arrays) if available.
			$advantages    = get_post_meta( $service_id, '_pi_service_advantages', true );
			$disadvantages = get_post_meta( $service_id, '_pi_service_disadvantages', true );

			// Parse JSON strings if stored as such.
			if ( is_string( $advantages ) && ! empty( $advantages ) ) {
				$advantages = json_decode( $advantages, true );
			}
			if ( is_string( $disadvantages ) && ! empty( $disadvantages ) ) {
				$disadvantages = json_decode( $disadvantages, true );
			}

			if ( ! empty( $advantages ) || ! empty( $disadvantages ) ) :
			?>
				<section class="service-pros-cons reveal">
					<h2 class="section-heading">Ưu điểm & Hạn chế</h2>
					<div class="gold-line"></div>

					<div class="pros-cons-grid">
						<?php if ( ! empty( $advantages ) && is_array( $advantages ) ) : ?>
							<div class="pros">
								<h3>Ưu điểm</h3>
								<ul class="check-list">
									<?php foreach ( $advantages as $item ) : ?>
										<li>
											<span class="check-icon" aria-hidden="true">✓</span>
											<?php echo esc_html( $item ); ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $disadvantages ) && is_array( $disadvantages ) ) : ?>
							<div class="cons">
								<h3>Hạn chế</h3>
								<ul class="cross-list">
									<?php foreach ( $disadvantages as $item ) : ?>
										<li>
											<span class="cross-icon" aria-hidden="true">!</span>
											<?php echo esc_html( $item ); ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php
			// ─── FAQ Section ──────────────────────────────────────────
			$faq = get_post_meta( $service_id, '_pi_service_faq', true );

			if ( is_string( $faq ) && ! empty( $faq ) ) {
				$faq = json_decode( $faq, true );
			}

			if ( ! empty( $faq ) && is_array( $faq ) ) :
			?>
				<section class="service-faq reveal">
					<h2 class="section-heading">Câu hỏi thường gặp</h2>
					<div class="gold-line"></div>

					<div class="faq-list">
						<?php foreach ( $faq as $index => $qa ) : ?>
							<?php
							$question = isset( $qa['question'] ) ? $qa['question'] : ( isset( $qa['q'] ) ? $qa['q'] : '' );
							$answer   = isset( $qa['answer'] )   ? $qa['answer']   : ( isset( $qa['a'] ) ? $qa['a'] : '' );
							if ( empty( $question ) ) {
								continue;
							}
							?>
							<details class="faq-item" id="faq-<?php echo esc_attr( $index ); ?>">
								<summary class="faq-question">
									<span class="faq-q-text"><?php echo esc_html( $question ); ?></span>
									<span class="faq-toggle" aria-hidden="true">+</span>
								</summary>
								<?php if ( $answer ) : ?>
									<div class="faq-answer">
										<?php echo wp_kses_post( $answer ); ?>
									</div>
								<?php endif; ?>
							</details>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

		</div>
	</article>

	<?php
	// ─── Related Doctors ──────────────────────────────────────────────
	// Query pi_doctor where _pi_doctor_services contains this service ID.
	$related_doctors = new WP_Query( array(
		'post_type'      => 'pi_doctor',
		'posts_per_page' => 4,
		'post_status'    => 'publish',
		'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'     => '_pi_doctor_services',
				'value'   => '"' . $service_id . '"',
				'compare' => 'LIKE',
			),
		),
	) );

	if ( $related_doctors->have_posts() ) :
	?>
		<section class="service-related-doctors pi-off-white-bg">
			<div class="container">
				<?php
				get_template_part( 'template-parts/section/section-header', null, array(
					'label'   => 'ĐỘI NGŨ BÁC SĨ',
					'heading' => 'Bác sĩ chuyên trách',
					'sub'     => 'Đội ngũ bác sĩ giàu kinh nghiệm trong lĩnh vực ' . strtolower( get_the_title() ),
				) );
				?>
				<div class="cards-grid-3">
					<?php
					while ( $related_doctors->have_posts() ) :
						$related_doctors->the_post();
						get_template_part( 'template-parts/card/doctor-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
	// ─── Related Cases ────────────────────────────────────────────────
	$related_cases = new WP_Query( array(
		'post_type'      => 'pi_case',
		'posts_per_page' => 6,
		'post_status'    => 'publish',
		'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'     => '_pi_case_service_id',
				'value'   => $service_id,
				'compare' => '=',
				'type'    => 'NUMERIC',
			),
		),
	) );

	if ( $related_cases->have_posts() ) :
	?>
		<section class="service-related-cases">
			<div class="container">
				<?php
				get_template_part( 'template-parts/section/section-header', null, array(
					'label'   => 'CASE ĐIỀU TRỊ',
					'heading' => 'Kết quả thực tế',
					'sub'     => 'Những ca điều trị ' . strtolower( get_the_title() ) . ' tại Pi Dentist',
				) );
				?>
				<div class="cards-grid-3">
					<?php
					while ( $related_cases->have_posts() ) :
						$related_cases->the_post();
						get_template_part( 'template-parts/card/case-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- ─── CTA Booking ──────────────────────────────────────────── -->
	<?php get_template_part( 'template-parts/section/booking-cta' ); ?>

</main>

<?php
endwhile;

get_footer();
