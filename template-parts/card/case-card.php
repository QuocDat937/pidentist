<?php
/**
 * Pi Dentist — Card: Ca điều trị (case-card)
 *
 * Hiển thị 1 case card trong grid.
 * Dùng trong: archive-pi_case.php, single-pi_service.php related cases,
 *             single-pi_doctor.php related cases.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$patient_age = get_post_meta( get_the_ID(), '_pi_case_patient_age', true );
$duration    = get_post_meta( get_the_ID(), '_pi_case_duration', true );
$diagnosis   = get_post_meta( get_the_ID(), '_pi_case_diagnosis', true );
$permalink   = get_the_permalink();
?>

<article class="case-card reveal" id="case-<?php echo esc_attr( get_the_ID() ); ?>">

	<!-- Thumbnail (Before Image) -->
	<a href="<?php echo esc_url( $permalink ); ?>" class="case-thumb-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="case-thumb">
				<?php the_post_thumbnail( 'medium_large', array(
					'alt'     => esc_attr( get_the_title() . ' — Trước điều trị' ),
					'loading' => 'lazy',
				) ); ?>
				<span class="case-thumb-badge">Trước</span>
			</div>
		<?php else : ?>
			<div class="case-thumb case-thumb-placeholder">
				<span class="case-placeholder-icon" aria-hidden="true">📸</span>
			</div>
		<?php endif; ?>
	</a>

	<!-- Card Body -->
	<div class="case-body">
		<h3 class="case-name">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
		</h3>

		<?php if ( $diagnosis ) : ?>
			<p class="case-diagnosis"><?php echo esc_html( $diagnosis ); ?></p>
		<?php endif; ?>

		<?php if ( $duration ) : ?>
			<p class="case-duration">
				<span class="case-duration-icon" aria-hidden="true">⏱️</span>
				Thời gian: <?php echo esc_html( $duration ); ?>
			</p>
		<?php endif; ?>

		<a href="<?php echo esc_url( $permalink ); ?>" class="card-link">
			Xem chi tiết <span aria-hidden="true">→</span>
		</a>
	</div>

</article>
