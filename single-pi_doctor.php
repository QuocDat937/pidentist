<?php
/**
 * Pi Dentist — Single: Bác sĩ (pi_doctor)
 *
 * Chi tiết 1 bác sĩ tại /bac-si/{slug}/.
 * Layout: Page Hero → Info Panel → Content (CV) → Related Services
 *         → Related Cases → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	// ─── Get all meta ─────────────────────────────────────────────────
	$doctor_id    = get_the_ID();
	$doctor_title = get_post_meta( $doctor_id, '_pi_doctor_title', true );
	$credentials  = get_post_meta( $doctor_id, '_pi_doctor_credentials', true );
	$specialties  = get_post_meta( $doctor_id, '_pi_doctor_specialties', true );
	$services_raw = get_post_meta( $doctor_id, '_pi_doctor_services', true );
?>

<main class="pi-single pi-single-doctor" id="main-content">

	<?php
	// ─── 1. Page Hero ─────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'BÁC SĨ',
		'heading'    => get_the_title(),
		'sub'        => $doctor_title,
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── 2. Doctor Detail ──────────────────────────────────────── -->
	<article class="doctor-detail">
		<div class="container">

			<!-- Doctor Profile Layout: Photo + Info -->
			<div class="doctor-profile reveal">

				<!-- Photo Column -->
				<div class="doctor-photo-col">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="doctor-photo">
							<?php the_post_thumbnail( 'large', array(
								'alt' => esc_attr( get_the_title() ),
							) ); ?>
						</div>
					<?php else : ?>
						<div class="doctor-photo doctor-photo-placeholder">
							<span class="doctor-avatar-icon-lg" aria-hidden="true">👨‍⚕️</span>
						</div>
					<?php endif; ?>
				</div>

				<!-- Info Column -->
				<div class="doctor-info-col">
					<?php if ( $doctor_title ) : ?>
						<p class="doctor-info-title"><?php echo esc_html( $doctor_title ); ?></p>
					<?php endif; ?>

					<h2 class="doctor-info-name"><?php the_title(); ?></h2>
					<div class="gold-line-left"></div>

					<?php if ( $credentials ) : ?>
						<div class="doctor-info-block">
							<h3>Bằng cấp & Chứng chỉ</h3>
							<div class="doctor-info-content">
								<?php echo wp_kses_post( nl2br( $credentials ) ); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $specialties ) : ?>
						<div class="doctor-info-block">
							<h3>Chuyên sâu</h3>
							<div class="doctor-info-content">
								<?php echo wp_kses_post( nl2br( $specialties ) ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

			</div>

			<?php // ─── CV / Content ──────────────────────────────────── ?>
			<?php if ( get_the_content() ) : ?>
				<div class="doctor-cv prose reveal">
					<h2 class="section-heading">Giới thiệu chi tiết</h2>
					<div class="gold-line"></div>
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

		</div>
	</article>

	<?php
	// ─── Related Services ─────────────────────────────────────────────
	// Parse _pi_doctor_services (stored as serialised array of IDs).
	$service_ids = array();
	if ( ! empty( $services_raw ) ) {
		if ( is_string( $services_raw ) ) {
			$service_ids = json_decode( $services_raw, true );
			if ( ! is_array( $service_ids ) ) {
				$service_ids = maybe_unserialize( $services_raw );
			}
		} elseif ( is_array( $services_raw ) ) {
			$service_ids = $services_raw;
		}
	}

	if ( ! empty( $service_ids ) && is_array( $service_ids ) ) :
		$related_services = new WP_Query( array(
			'post_type'      => 'pi_service',
			'post__in'       => array_map( 'absint', $service_ids ),
			'posts_per_page' => count( $service_ids ),
			'post_status'    => 'publish',
			'orderby'        => 'post__in',
		) );

		if ( $related_services->have_posts() ) :
	?>
		<section class="doctor-related-services pi-off-white-bg">
			<div class="container">
				<?php
				get_template_part( 'template-parts/section/section-header', null, array(
					'label'   => 'DỊCH VỤ',
					'heading' => 'Dịch vụ chuyên trách',
					'sub'     => 'Các phương pháp chỉnh nha mà ' . get_the_title() . ' đảm nhận',
				) );
				?>
				<div class="cards-grid-3">
					<?php
					while ( $related_services->have_posts() ) :
						$related_services->the_post();
						get_template_part( 'template-parts/card/service-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php
		endif;
	endif;
	?>

	<?php
	// ─── Related Cases ────────────────────────────────────────────────
	$related_cases = new WP_Query( array(
		'post_type'      => 'pi_case',
		'posts_per_page' => 6,
		'post_status'    => 'publish',
		'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'     => '_pi_case_doctor_id',
				'value'   => $doctor_id,
				'compare' => '=',
				'type'    => 'NUMERIC',
			),
		),
	) );

	if ( $related_cases->have_posts() ) :
	?>
		<section class="doctor-related-cases">
			<div class="container">
				<?php
				get_template_part( 'template-parts/section/section-header', null, array(
					'label'   => 'CASE ĐIỀU TRỊ',
					'heading' => 'Ca điều trị tiêu biểu',
					'sub'     => 'Những kết quả thực tế từ ' . get_the_title(),
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
