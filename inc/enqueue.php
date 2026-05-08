<?php
/**
 * Pi Dentist — Enqueue CSS & JS
 *
 * - Priority 20 để load SAU GeneratePress parent.
 * - CSS dependency chain: tokens → base → buttons → header → ...
 * - Pattern CSS chỉ load khi is_front_page().
 * - Carousel JS chỉ load khi front-page hoặc archive pi_doctor.
 * - Tất cả JS đều defer qua filter script_loader_tag.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/* ───────────────────────────────────────────────
 * 1. FRONT-END: CSS & JS
 * ─────────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', 'pi_enqueue_styles', 20 );
add_action( 'wp_enqueue_scripts', 'pi_enqueue_scripts', 20 );

/**
 * Enqueue tất cả stylesheets.
 */
function pi_enqueue_styles() {
	$ver = PIDENTIST_VERSION;
	$uri = PIDENTIST_URI;

	/* --- Parent theme (GeneratePress) --- */
	wp_enqueue_style(
		'generatepress-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		$ver
	);

	/* --- Google Fonts: Playfair Display + Inter --- */
	$fonts_url = add_query_arg(
		array(
			'family'  => implode( '&family=', array(
				'Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400',
				'Inter:wght@300;400;500;600;700',
			) ),
			'display' => 'swap',
		),
		'https://fonts.googleapis.com/css2'
	);

	wp_enqueue_style(
		'pi-google-fonts',
		$fonts_url,
		array(),
		null // Google Fonts URL tự version — không append ?ver=
	);

	/* --- Design Tokens (load TRƯỚC mọi CSS con) --- */
	wp_enqueue_style(
		'pi-tokens',
		$uri . '/assets/css/tokens.css',
		array( 'generatepress-parent' ),
		$ver
	);

	/* --- Core CSS chain (tất cả depend vào pi-tokens) --- */
	$core_styles = array(
		'pi-base'       => 'base.css',
		'pi-buttons'    => 'buttons.css',
		'pi-header'     => 'header.css',
		'pi-footer'     => 'footer.css',
		'pi-sections'   => 'sections.css',
		'pi-cards'      => 'cards.css',
		'pi-animations' => 'animations.css',
		'pi-floating'   => 'floating.css',
	);

	foreach ( $core_styles as $handle => $file ) {
		wp_enqueue_style(
			$handle,
			$uri . '/assets/css/' . $file,
			array( 'pi-tokens' ),
			$ver
		);
	}

	/* --- Pattern CSS (CHỈ front-page) --- */
	if ( is_front_page() ) {
		$pattern_styles = array(
			'pi-pattern-hero'          => 'hero.css',
			'pi-pattern-commitments'   => 'commitments.css',
			'pi-pattern-philosophy'    => 'philosophy.css',
			'pi-pattern-services-grid' => 'services-grid.css',
			'pi-pattern-pricing-table' => 'pricing-table.css',
		);

		foreach ( $pattern_styles as $handle => $file ) {
			wp_enqueue_style(
				$handle,
				$uri . '/assets/css/patterns/' . $file,
				array( 'pi-tokens' ),
				$ver
			);
		}
	}

	/* --- Pattern CSS cho CPT archives/singles --- */
	if ( is_post_type_archive( 'pi_service' ) || is_singular( 'pi_service' ) ) {
		wp_enqueue_style(
			'pi-pattern-services-grid',
			$uri . '/assets/css/patterns/services-grid.css',
			array( 'pi-tokens', 'pi-cards' ),
			$ver
		);
	}
}

/**
 * Enqueue tất cả scripts (defer qua filter bên dưới).
 */
function pi_enqueue_scripts() {
	$ver = PIDENTIST_VERSION;
	$uri = PIDENTIST_URI;

	/* --- Core JS --- */
	$core_scripts = array(
		'pi-header'        => 'header.js',
		'pi-reveal'        => 'reveal.js',
		'pi-floating'      => 'floating.js',
		'pi-smooth-scroll' => 'smooth-scroll.js',
	);

	foreach ( $core_scripts as $handle => $file ) {
		wp_enqueue_script(
			$handle,
			$uri . '/assets/js/' . $file,
			array(),
			$ver,
			true // in footer
		);
	}

	/* --- Carousel JS (CHỈ front-page hoặc archive pi_doctor) --- */
	if ( is_front_page() || is_post_type_archive( 'pi_doctor' ) ) {
		wp_enqueue_script(
			'pi-carousel',
			$uri . '/assets/js/carousel.js',
			array(),
			$ver,
			true
		);
	}
}

/* ───────────────────────────────────────────────
 * 2. DEFER: thêm attribute defer cho mọi JS handle Pi
 * ─────────────────────────────────────────────── */
add_filter( 'script_loader_tag', 'pi_defer_scripts', 10, 2 );

/**
 * Thêm `defer` attribute cho các script handle bắt đầu bằng "pi-".
 *
 * @param string $tag    HTML <script> tag.
 * @param string $handle Handle name.
 * @return string
 */
function pi_defer_scripts( $tag, $handle ) {
	// Chỉ xử lý handle Pi.
	if ( strpos( $handle, 'pi-' ) !== 0 ) {
		return $tag;
	}

	// Tránh duplicate nếu WP đã thêm defer.
	if ( strpos( $tag, 'defer' ) !== false ) {
		return $tag;
	}

	return str_replace( ' src=', ' defer src=', $tag );
}

/* ───────────────────────────────────────────────
 * 3. EDITOR STYLES: tokens + editor.css cho Block Editor
 * ─────────────────────────────────────────────── */
add_action( 'after_setup_theme', 'pi_editor_styles' );

/**
 * Load CSS vào Block Editor admin để preview đúng design tokens.
 */
function pi_editor_styles() {
	add_editor_style( 'assets/css/tokens.css' );
	add_editor_style( 'assets/css/editor.css' );
}
