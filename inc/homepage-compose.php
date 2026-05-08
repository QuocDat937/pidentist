<?php
/**
 * Pi Dentist — Homepage Auto-Compose
 *
 * Tạo trang "Trang chủ" với 11 sections từ Block Patterns + Shortcodes + Synced Pattern.
 * Chạy 1 lần qua admin_init → check option 'pi_homepage_composed'.
 *
 * Sections:
 *  1. Pattern: pi/hero-banner
 *  2. Pattern: pi/commitments
 *  3. Pattern: pi/philosophy
 *  4. Shortcode: [pi_doctors_carousel]
 *  5. Pattern: pi/technology-navy
 *  6. Pattern: pi/services-grid-home  (contains [pi_services_grid])
 *  7. Pattern: pi/simulation-cta
 *  8. Pattern: pi/journey-timeline
 *  9. Pattern: pi/pricing-table
 * 10. Shortcode: [pi_recent_posts count="3"]
 * 11. Synced Pattern: Pi - CTA Booking (wp:block ref)
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'pi_compose_homepage', 20 );

/**
 * Auto-compose homepage content.
 * Reads registered pattern content at runtime — no markup duplication.
 */
function pi_compose_homepage() {

	if ( get_option( 'pi_homepage_composed' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Set flag immediately to prevent race condition.
	update_option( 'pi_homepage_composed', 1 );

	// ─── Helper: get pattern content from registry ───────────────────
	$registry = WP_Block_Patterns_Registry::get_instance();

	/**
	 * Get registered pattern content by name.
	 *
	 * @param string $name Pattern name (e.g. 'pi/hero-banner').
	 * @return string Block markup or empty string.
	 */
	$get_pattern = function ( $name ) use ( $registry ) {
		if ( $registry->is_registered( $name ) ) {
			$pattern = $registry->get_registered( $name );
			return trim( $pattern['content'] );
		}
		return '';
	};

	// ─── Build 11 sections ───────────────────────────────────────────
	$sections = array();

	// 1. Hero Banner
	$sections[] = $get_pattern( 'pi/hero-banner' );

	// 2. Cam kết grid (4 cột)
	$sections[] = $get_pattern( 'pi/commitments' );

	// 3. Triết lý π
	$sections[] = $get_pattern( 'pi/philosophy' );

	// 4. Đội ngũ BS — dynamic shortcode
	$sections[] = '<!-- wp:shortcode -->
[pi_doctors_carousel]
<!-- /wp:shortcode -->';

	// 5. Công nghệ (nền navy)
	$sections[] = $get_pattern( 'pi/technology-navy' );

	// 6. Dịch vụ grid — pattern with embedded shortcode
	$sections[] = $get_pattern( 'pi/services-grid-home' );

	// 7. Simulation CTA
	$sections[] = $get_pattern( 'pi/simulation-cta' );

	// 8. Hành trình 5 bước
	$sections[] = $get_pattern( 'pi/journey-timeline' );

	// 9. Bảng giá
	$sections[] = $get_pattern( 'pi/pricing-table' );

	// 10. Kiến thức — dynamic shortcode
	$sections[] = '<!-- wp:shortcode -->
[pi_recent_posts count="3"]
<!-- /wp:shortcode -->';

	// 11. CTA Booking — Synced Pattern (wp:block ref)
	$cta_block = get_page_by_path( 'pi-cta-booking', OBJECT, 'wp_block' );
	if ( $cta_block ) {
		$sections[] = '<!-- wp:block {"ref":' . $cta_block->ID . '} /-->';
	}

	// Filter empty sections.
	$sections = array_filter( $sections );

	if ( empty( $sections ) ) {
		return;
	}

	$post_content = implode( "\n\n", $sections );

	// ─── Find or create "Trang chủ" page ─────────────────────────────
	$homepage = get_page_by_title( 'Trang chủ' );

	if ( $homepage ) {
		$page_id = $homepage->ID;
		wp_update_post( array(
			'ID'           => $page_id,
			'post_content' => $post_content,
			'post_status'  => 'publish',
		) );
	} else {
		$page_id = wp_insert_post( array(
			'post_title'   => 'Trang chủ',
			'post_name'    => 'trang-chu',
			'post_content' => $post_content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
		) );
	}

	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return;
	}

	// ─── Set as static front page ────────────────────────────────────
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $page_id );

	// Also create a "Blog" page for posts if not exists.
	$blog_page = get_page_by_title( 'Kiến thức' );
	if ( ! $blog_page ) {
		$blog_id = wp_insert_post( array(
			'post_title'   => 'Kiến thức',
			'post_name'    => 'kien-thuc',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		) );
		if ( $blog_id && ! is_wp_error( $blog_id ) ) {
			update_option( 'page_for_posts', $blog_id );
		}
	} else {
		update_option( 'page_for_posts', $blog_page->ID );
	}

	// Flush rewrite rules.
	flush_rewrite_rules();

	// Admin notice.
	add_action( 'admin_notices', function () {
		echo '<div class="notice notice-success is-dismissible"><p><strong>Pi Dentist:</strong> Trang chủ đã được compose thành công với 11 sections! Settings > Reading đã được cấu hình.</p></div>';
	} );
}
