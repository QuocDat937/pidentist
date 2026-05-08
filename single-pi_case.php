<?php
/**
 * Pi Dentist — Single: Ca điều trị (pi_case)
 *
 * Chi tiết 1 ca điều trị tại /case/{slug}/.
 * Layout: Page Hero → Patient Info → Before/After + Content
 *         → Related Doctor + Service → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	// ─── Get all meta ─────────────────────────────────────────────────
	$case_id    = get_the_ID();
	$age        = get_post_meta( $case_id, '_pi_case_patient_age', true );
	$gender_raw = get_post_meta( $case_id, '_pi_case_patient_gender', true );
	$duration   = get_post_meta( $case_id, '_pi_case_duration', true );
	$diagnosis  = get_post_meta( $case_id, '_pi_case_diagnosis', true );
	$doctor_id  = absint( get_post_meta( $case_id, '_pi_case_doctor_id', true ) );
	$service_id = absint( get_post_meta( $case_id, '_pi_case_service_id', true ) );

	// Translate gender.
	$gender_map = array(
		'male'   => 'Nam',
		'female' => 'Nữ',
	);
	$gender = isset( $gender_map[ $gender_raw ] ) ? $gender_map[ $gender_raw ] : '';
?>

<main class="pi-single pi-single-case" id="main-content">

	<?php
	// ─── 1. Page Hero ─────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'CASE ĐIỀU TRỊ',
		'heading'    => get_the_title(),
		'sub'        => $diagnosis,
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── 2. Case Detail ────────────────────────────────────────── -->
	<article class="case-detail">
		<div class="container">

			<?php // ─── Patient Info Bar ──────────────────────────────── ?>
			<?php if ( $age || $gender || $duration ) : ?>
				<div class="case-patient-info reveal">
					<?php if ( $age ) : ?>
						<div class="patient-info-item">
							<span class="patient-info-icon" aria-hidden="true">👤</span>
							<div class="patient-info-text">
								<span class="patient-info-label">Bệnh nhân</span>
								<span class="patient-info-value">
									<?php
									echo esc_html( $age );
									if ( $gender ) {
										echo ', ' . esc_html( $gender );
									}
									?>
								</span>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $duration ) : ?>
						<div class="patient-info-item">
							<span class="patient-info-icon" aria-hidden="true">⏱️</span>
							<div class="patient-info-text">
								<span class="patient-info-label">Thời gian điều trị</span>
								<span class="patient-info-value"><?php echo esc_html( $duration ); ?></span>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $diagnosis ) : ?>
						<div class="patient-info-item">
							<span class="patient-info-icon" aria-hidden="true">📋</span>
							<div class="patient-info-text">
								<span class="patient-info-label">Chẩn đoán</span>
								<span class="patient-info-value"><?php echo esc_html( $diagnosis ); ?></span>
							</div>
						</div>
					<?php endif; ?>

					<?php
					// Show related doctor name inline.
					if ( $doctor_id ) :
						$doctor_name = get_the_title( $doctor_id );
						if ( $doctor_name ) :
					?>
						<div class="patient-info-item">
							<span class="patient-info-icon" aria-hidden="true">🩺</span>
							<div class="patient-info-text">
								<span class="patient-info-label">Bác sĩ điều trị</span>
								<span class="patient-info-value">
									<a href="<?php echo esc_url( get_permalink( $doctor_id ) ); ?>"><?php echo esc_html( $doctor_name ); ?></a>
								</span>
							</div>
						</div>
					<?php
						endif;
					endif;
					?>
				</div>
			<?php endif; ?>

			<?php // ─── Before/After Gallery ──────────────────────────── ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="case-gallery reveal">
					<h2 class="section-heading">Trước & Sau điều trị</h2>
					<div class="gold-line"></div>
					<div class="case-before-after">
						<div class="case-before">
							<span class="case-ba-label">Trước</span>
							<?php the_post_thumbnail( 'large', array(
								'alt' => esc_attr( get_the_title() . ' — Trước điều trị' ),
							) ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php // ─── Content: Diagnosis + Treatment + Result ──────── ?>
			<?php if ( get_the_content() ) : ?>
				<div class="case-content prose reveal">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

			<?php // ─── Related Doctor & Service Links ────────────────── ?>
			<?php if ( $doctor_id || $service_id ) : ?>
				<div class="case-related-links reveal">
					<?php if ( $doctor_id ) :
						$doc_name  = get_the_title( $doctor_id );
						$doc_title = get_post_meta( $doctor_id, '_pi_doctor_title', true );
						if ( $doc_name ) :
					?>
						<a href="<?php echo esc_url( get_permalink( $doctor_id ) ); ?>" class="case-related-link">
							<span class="case-related-icon" aria-hidden="true">🩺</span>
							<div class="case-related-text">
								<span class="case-related-label">Bác sĩ điều trị</span>
								<span class="case-related-name"><?php echo esc_html( $doc_name ); ?></span>
								<?php if ( $doc_title ) : ?>
									<span class="case-related-sub"><?php echo esc_html( $doc_title ); ?></span>
								<?php endif; ?>
							</div>
							<span class="case-related-arrow" aria-hidden="true">→</span>
						</a>
					<?php
						endif;
					endif;
					?>

					<?php if ( $service_id ) :
						$svc_name    = get_the_title( $service_id );
						$svc_tagline = get_post_meta( $service_id, '_pi_service_tagline', true );
						if ( $svc_name ) :
					?>
						<a href="<?php echo esc_url( get_permalink( $service_id ) ); ?>" class="case-related-link">
							<span class="case-related-icon" aria-hidden="true">🦷</span>
							<div class="case-related-text">
								<span class="case-related-label">Dịch vụ sử dụng</span>
								<span class="case-related-name"><?php echo esc_html( $svc_name ); ?></span>
								<?php if ( $svc_tagline ) : ?>
									<span class="case-related-sub"><?php echo esc_html( $svc_tagline ); ?></span>
								<?php endif; ?>
							</div>
							<span class="case-related-arrow" aria-hidden="true">→</span>
						</a>
					<?php
						endif;
					endif;
					?>
				</div>
			<?php endif; ?>

		</div>
	</article>

	<!-- ─── CTA Booking ──────────────────────────────────────────── -->
	<?php get_template_part( 'template-parts/section/booking-cta' ); ?>

</main>

<?php
endwhile;

get_footer();
