<?php
/**
 * Pi Dentist — Shortcodes
 *
 * Shortcodes cho dynamic content trong Block Patterns.
 * - [pi_services_grid]  → Render service cards từ CPT pi_service
 * - [pi_phone]          → Output số điện thoại từ Customizer
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode [pi_services_grid]
 *
 * Render grid service cards từ CPT pi_service.
 * Dùng trong Pattern 8 (Homepage section 6).
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output.
 */
add_shortcode( 'pi_services_grid', 'pi_services_grid_shortcode' );

function pi_services_grid_shortcode( $atts ) {
	$atts = shortcode_atts( [
		'count' => 4,
	], $atts, 'pi_services_grid' );

	$query = new WP_Query( [
		'post_type'      => 'pi_service',
		'posts_per_page' => absint( $atts['count'] ),
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	] );

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return '<p class="pi-no-results">Chưa có dịch vụ nào.</p>';
	}

	ob_start();
	echo '<div class="services-grid">';

	while ( $query->have_posts() ) {
		$query->the_post();
		get_template_part( 'template-parts/card/service-card', null, [
			'show_price' => true,
		] );
	}

	echo '</div>';
	wp_reset_postdata();

	return ob_get_clean();
}

/**
 * Shortcode [pi_phone]
 *
 * Output số điện thoại từ Customizer setting pi_phone.
 *
 * @return string Phone number (escaped).
 */
add_shortcode( 'pi_phone', 'pi_phone_shortcode' );

function pi_phone_shortcode() {
	$phone = get_theme_mod( 'pi_phone', '0123 456 789' );
	return esc_html( $phone );
}
