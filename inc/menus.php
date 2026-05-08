<?php
/**
 * Pi Dentist — Menus & Navigation Walker
 *
 * Register nav menu locations and custom Walker for dropdown support.
 * Ref: PROJECT_SPEC_WP.md section 10.5
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/* ───────────────────────────────────────────────
 * 1. Register Menu Locations
 * ─────────────────────────────────────────────── */
add_action( 'after_setup_theme', 'pi_register_nav_menus' );

/**
 * Register 4 nav menu locations.
 */
function pi_register_nav_menus() {
	register_nav_menus( array(
		'primary'          => __( 'Menu chính (header)', 'pidentist' ),
		'mobile'           => __( 'Menu mobile', 'pidentist' ),
		'footer-services'  => __( 'Footer - Dịch vụ', 'pidentist' ),
		'footer-info'      => __( 'Footer - Thông tin', 'pidentist' ),
	) );
}

/* ───────────────────────────────────────────────
 * 2. Custom Walker — Pi_Nav_Walker
 *    Output đúng class .nav-item / .nav-link / .dropdown / .dropdown-item
 *    + chevron ▼ cho parent items có submenu
 * ─────────────────────────────────────────────── */
class Pi_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Start sub-level: output dropdown wrapper.
	 *
	 * @param string   $output HTML output.
	 * @param int      $depth  Depth of the current item.
	 * @param stdClass $args   Nav menu arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= "\n<div class=\"dropdown\" role=\"menu\">\n";
	}

	/**
	 * End sub-level: close dropdown wrapper.
	 *
	 * @param string   $output HTML output.
	 * @param int      $depth  Depth of the current item.
	 * @param stdClass $args   Nav menu arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= "</div>\n";
	}

	/**
	 * Start element.
	 *
	 * @param string   $output HTML output.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of the current item.
	 * @param stdClass $args   Nav menu arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$has_children = in_array( 'menu-item-has-children', $item->classes, true );
		$url          = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
		$title        = esc_html( $item->title );

		// Build custom classes for the link
		$classes = array();
		if ( $item->current ) {
			$classes[] = 'current';
		}
		if ( $item->current_item_ancestor ) {
			$classes[] = 'current-ancestor';
		}

		if ( $depth === 0 ) {
			// Top-level: wrap in .nav-item div
			$output .= '<div class="nav-item">';

			// Chevron indicator for parent items
			$chevron = $has_children ? ' <span class="chevron" aria-hidden="true">▼</span>' : '';

			// Add aria-haspopup for accessibility
			$aria = $has_children ? ' aria-haspopup="true"' : '';

			$link_class = 'nav-link';
			if ( ! empty( $classes ) ) {
				$link_class .= ' ' . implode( ' ', $classes );
			}

			$output .= sprintf(
				'<a href="%s" class="%s"%s>%s%s</a>',
				$url,
				esc_attr( $link_class ),
				$aria,
				$title,
				$chevron
			);
		} else {
			// Sub-level: dropdown item
			$link_class = 'dropdown-item';
			if ( ! empty( $classes ) ) {
				$link_class .= ' ' . implode( ' ', $classes );
			}

			$output .= sprintf(
				'<a href="%s" class="%s" role="menuitem">%s</a>',
				$url,
				esc_attr( $link_class ),
				$title
			);
		}
	}

	/**
	 * End element.
	 *
	 * @param string   $output HTML output.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of the current item.
	 * @param stdClass $args   Nav menu arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( $depth === 0 ) {
			$output .= "</div>\n";
		}
	}
}
