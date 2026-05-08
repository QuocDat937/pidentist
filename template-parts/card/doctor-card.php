<?php
/**
 * Pi Dentist — Card: Bác sĩ (doctor-card)
 *
 * Hiển thị 1 doctor card trong grid.
 * Dùng trong: archive-pi_doctor.php, single-pi_service.php related doctors,
 *             front-page section 4.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$doctor_title = get_post_meta( get_the_ID(), '_pi_doctor_title', true );
$credentials  = get_post_meta( get_the_ID(), '_pi_doctor_credentials', true );
$permalink    = get_the_permalink();
?>

<article class="doctor-card reveal" id="doctor-<?php echo esc_attr( get_the_ID() ); ?>">

	<!-- Thumbnail (Portrait Photo) hoặc Placeholder Avatar -->
	<a href="<?php echo esc_url( $permalink ); ?>" class="doctor-thumb-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="doctor-thumb">
				<?php the_post_thumbnail( 'medium_large', array(
					'alt'     => esc_attr( get_the_title() ),
					'loading' => 'lazy',
				) ); ?>
			</div>
		<?php else : ?>
			<div class="doctor-thumb doctor-thumb-placeholder">
				<span class="doctor-avatar-icon" aria-hidden="true">👨‍⚕️</span>
			</div>
		<?php endif; ?>
	</a>

	<!-- Card Body -->
	<div class="doctor-body">
		<h3 class="doctor-name">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
		</h3>

		<?php if ( $doctor_title ) : ?>
			<p class="doctor-title"><?php echo esc_html( $doctor_title ); ?></p>
		<?php endif; ?>

		<?php if ( $credentials ) : ?>
			<p class="doctor-credentials"><?php echo esc_html( $credentials ); ?></p>
		<?php endif; ?>

		<a href="<?php echo esc_url( $permalink ); ?>" class="card-link">
			Xem chi tiết <span aria-hidden="true">→</span>
		</a>
	</div>

</article>
