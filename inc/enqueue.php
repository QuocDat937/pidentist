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
add_action( 'wp_enqueue_scripts', 'pi_dequeue_jquery', 99 );

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

	/* --- Self-hosted Fonts: Inter + Playfair Display (woff2) --- */
	wp_enqueue_style(
		'pi-fonts',
		$uri . '/assets/css/fonts.css',
		array( 'generatepress-parent' ),
		$ver
	);

	/* --- Design Tokens (load TRƯỚC mọi CSS con) --- */
	wp_enqueue_style(
		'pi-tokens',
		$uri . '/assets/css/tokens.css',
		array( 'generatepress-parent', 'pi-fonts' ),
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

	/* --- Pattern CSS (CHỈ front-page) — BUNDLED để giảm render-blocking --- */
	if ( is_front_page() ) {
		wp_enqueue_style(
			'pi-pattern-front-page-bundle',
			$uri . '/assets/css/patterns/front-page-bundle.css',
			array( 'pi-tokens' ),
			$ver
		);
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

	if ( is_singular( 'pi_service' ) ) {
		wp_enqueue_style(
			'pi-pattern-single-service',
			$uri . '/assets/css/patterns/single-service.css',
			array( 'pi-tokens', 'pi-sections', 'pi-cards' ),
			$ver
		);
	}

	if ( is_post_type_archive( 'pi_doctor' ) || is_singular( 'pi_doctor' ) ) {
		wp_enqueue_style(
			'pi-pattern-doctors-grid',
			$uri . '/assets/css/patterns/doctors-grid.css',
			array( 'pi-tokens', 'pi-cards' ),
			$ver
		);
	}

	if ( is_post_type_archive( 'pi_case' ) || is_singular( 'pi_case' ) || is_tax( 'pi_case_tag' ) ) {
		wp_enqueue_style(
			'pi-pattern-cases-grid',
			$uri . '/assets/css/patterns/cases-grid.css',
			array( 'pi-tokens', 'pi-cards' ),
			$ver
		);
	}

	/* --- Cross-CPT: related sections on single templates --- */
	// Single doctor shows related service-cards + case-cards.
	if ( is_singular( 'pi_doctor' ) ) {
		wp_enqueue_style(
			'pi-pattern-services-grid',
			$uri . '/assets/css/patterns/services-grid.css',
			array( 'pi-tokens', 'pi-cards' ),
			$ver
		);
		wp_enqueue_style(
			'pi-pattern-cases-grid',
			$uri . '/assets/css/patterns/cases-grid.css',
			array( 'pi-tokens', 'pi-cards' ),
			$ver
		);
	}

	// Single service shows related doctor-cards + case-cards.
	if ( is_singular( 'pi_service' ) ) {
		wp_enqueue_style(
			'pi-pattern-doctors-grid',
			$uri . '/assets/css/patterns/doctors-grid.css',
			array( 'pi-tokens', 'pi-cards' ),
			$ver
		);
		wp_enqueue_style(
			'pi-pattern-cases-grid',
			$uri . '/assets/css/patterns/cases-grid.css',
			array( 'pi-tokens', 'pi-cards' ),
			$ver
		);
	}

	/* --- Blog, Search, 404, Page CSS (trừ front-page — đã có bundle) --- */
	if (
		! is_front_page() && (
			is_home() || is_archive() || is_singular( 'post' ) ||
			is_search() || is_404() || is_page()
		)
	) {
		wp_enqueue_style(
			'pi-pattern-blog',
			$uri . '/assets/css/patterns/blog.css',
			array( 'pi-tokens', 'pi-cards', 'pi-sections' ),
			$ver
		);
	}

	/* --- Contact Page CSS (trang Liên hệ /lien-he/) --- */
	if ( is_page( 'lien-he' ) ) {
		wp_enqueue_style(
			'pi-pattern-contact-page',
			$uri . '/assets/css/patterns/contact-page.css',
			array( 'pi-tokens', 'pi-sections', 'pi-pattern-booking-form' ),
			$ver
		);
	}

	/* --- Pricing Page CSS (trang Bảng giá /bang-gia/) --- */
	if ( is_page( 'bang-gia' ) ) {
		wp_enqueue_style(
			'pi-pattern-pricing-page',
			$uri . '/assets/css/patterns/pricing-page.css',
			array( 'pi-tokens', 'pi-sections', 'pi-buttons' ),
			$ver
		);
	}

	/* --- About Page CSS (trang Về Pi /ve-pi/) --- */
	if ( is_page( 've-pi' ) ) {
		wp_enqueue_style(
			'pi-pattern-about-page',
			$uri . '/assets/css/patterns/about-page.css',
			array( 'pi-tokens', 'pi-sections', 'pi-cards', 'pi-buttons' ),
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

	/* --- Service TOC JS (CHỈ single pi_service) --- */
	if ( is_singular( 'pi_service' ) ) {
		wp_enqueue_script(
			'pi-service-toc',
			$uri . '/assets/js/service-toc.js',
			array(),
			$ver,
			true
		);
	}

	/* --- Booking Form JS (loads on ALL pages — CTA Booking pattern injected via GP hook) --- */
	if ( ! is_404() ) {
		wp_enqueue_script(
			'pi-booking-form',
			$uri . '/assets/js/booking-form.js',
			array(),
			$ver,
			true
		);

		wp_localize_script( 'pi-booking-form', 'piBookingAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'phone'   => esc_html( get_theme_mod( 'pi_phone', '0909 XXX XXX' ) ),
		) );

		/* Booking form CSS — needed on all pages that show CTA booking */
		if ( ! is_front_page() ) {
			wp_enqueue_style(
				'pi-pattern-booking-form',
				$uri . '/assets/css/patterns/booking-form.css',
				array( 'pi-tokens' ),
				$ver
			);
		}
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
 * 3. PRELOAD FONTS — inject <link rel="preload"> vào <head>
 *    Preload 2 critical fonts: Inter regular (body) + Playfair Display 600 (headings)
 * ─────────────────────────────────────────────── */
add_action( 'wp_head', 'pi_preload_fonts', 1 );

/**
 * Preload critical font files để giảm FOIT/FOUT.
 * Chỉ preload 2 file quan trọng nhất — browser sẽ tự tải weights khác khi cần.
 */
function pi_preload_fonts() {
	$fonts = array(
		'/assets/fonts/inter-v20-latin-vietnamese-regular.woff2',
		'/assets/fonts/playfair-display-v40-latin-vietnamese-600.woff2',
	);
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_stylesheet_directory_uri() . $font )
		);
	}
}

/* ───────────────────────────────────────────────
 * 4. GOOGLE ANALYTICS — GA4 (gtag.js)
 *    Measurement ID: G-932C89X43Z
 *    - Chỉ load ở front-end (KHÔNG load trong admin)
 *    - Async load để không block rendering
 * ─────────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', 'pi_enqueue_ga4', 5 );

/**
 * Enqueue Google Analytics 4 (gtag.js).
 * Priority 5 để load SỚM trong <head> (trước CSS/JS khác).
 */
function pi_enqueue_ga4() {
	// Không load GA trong admin hoặc khi user đang preview.
	if ( is_admin() || is_preview() ) {
		return;
	}

	$ga_id = 'G-932C89X43Z';

	// Load gtag.js library.
	wp_enqueue_script(
		'pi-gtag',
		'https://www.googletagmanager.com/gtag/js?id=' . $ga_id,
		array(),
		null, // Không version — Google tự quản lý cache.
		false // Trong <head>, không phải footer.
	);

	// Config inline script.
	wp_add_inline_script(
		'pi-gtag',
		"window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','" . esc_js( $ga_id ) . "');"
	);
}

/**
 * Thêm `async` attribute cho gtag.js script (thay vì defer).
 * Google khuyến nghị async cho gtag.js.
 */
add_filter( 'script_loader_tag', 'pi_async_gtag', 10, 2 );

function pi_async_gtag( $tag, $handle ) {
	if ( 'pi-gtag' !== $handle ) {
		return $tag;
	}
	// Thay defer bằng async nếu WP đã thêm defer.
	$tag = str_replace( ' defer', '', $tag );
	if ( strpos( $tag, 'async' ) === false ) {
		$tag = str_replace( ' src=', ' async src=', $tag );
	}
	return $tag;
}

/* ───────────────────────────────────────────────
 * 5. DEQUEUE jQuery — Theme dùng Vanilla JS only
 *    jQuery + jQuery Migrate gây render-blocking (~34 KiB).
 *    Chỉ dequeue ở frontend, giữ nguyên cho admin.
 *    Priority 99 để chạy SAU tất cả plugins đã enqueue.
 * ─────────────────────────────────────────────── */

/**
 * Gỡ jQuery và jQuery Migrate khỏi frontend.
 *
 * Theme Pi Dentist dùng 100% Vanilla JS — jQuery không cần thiết.
 * Nếu plugin nào cần jQuery ở frontend → cần review lại.
 */
function pi_dequeue_jquery() {
	// Chỉ xử lý ở frontend — admin cần jQuery cho Gutenberg/plugins.
	if ( is_admin() ) {
		return;
	}

	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );

	wp_dequeue_script( 'jquery-core' );
	wp_deregister_script( 'jquery-core' );

	wp_dequeue_script( 'jquery-migrate' );
	wp_deregister_script( 'jquery-migrate' );
}

/* ───────────────────────────────────────────────
 * 6. EDITOR STYLES → xem inc/editor-config.php
 *    (tokens + base + buttons + sections + patterns + editor.css)
 * ─────────────────────────────────────────────── */
