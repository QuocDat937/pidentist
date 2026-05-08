<?php
/**
 * Pi Dentist — Card: Dịch vụ (service-card)
 *
 * Hiển thị 1 service card trong grid.
 * Dùng trong: archive-pi_service.php, front-page section 6.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$thumb_color  = get_post_meta( get_the_ID(), '_pi_service_thumb_color', true );
$tagline      = get_post_meta( get_the_ID(), '_pi_service_tagline', true );
$price_from   = get_post_meta( get_the_ID(), '_pi_service_price_from', true );
$suitable_for = get_post_meta( get_the_ID(), '_pi_service_suitable_for', true );
$permalink    = get_the_permalink();
?>

<article class="service-card reveal" id="service-<?php echo esc_attr( get_the_ID() ); ?>">

	<!-- Thumbnail hoặc Gradient Placeholder -->
	<a href="<?php echo esc_url( $permalink ); ?>" class="service-thumb-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="service-thumb">
				<?php the_post_thumbnail( 'medium_large', array(
					'alt'     => esc_attr( get_the_title() ),
					'loading' => 'lazy',
				) ); ?>
			</div>
		<?php else : ?>
			<div class="service-thumb <?php echo esc_attr( $thumb_color ); ?>"></div>
		<?php endif; ?>
	</a>

	<!-- Card Body -->
	<div class="service-body">
		<h3 class="service-name">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
		</h3>

		<?php if ( $tagline ) : ?>
			<p class="service-tagline"><?php echo esc_html( $tagline ); ?></p>
		<?php endif; ?>

		<?php if ( $price_from ) : ?>
			<p class="service-price">Từ <?php echo esc_html( number_format( $price_from, 0, ',', '.' ) ); ?> triệu</p>
		<?php endif; ?>

		<?php if ( $suitable_for ) : ?>
			<p class="service-suitable"><?php echo esc_html( $suitable_for ); ?></p>
		<?php endif; ?>

		<a href="<?php echo esc_url( $permalink ); ?>" class="card-link">
			Tìm hiểu thêm <span aria-hidden="true">→</span>
		</a>
	</div>

</article>
