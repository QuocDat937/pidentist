<?php
/**
 * Pi Dentist — Critical CSS (Inline Above-the-fold)
 *
 * Giải quyết render-blocking CSS bằng cách:
 * 1. Inline critical CSS vào <head> (styles cần cho viewport đầu tiên).
 * 2. Async load các file CSS còn lại (non-blocking).
 * 3. Cung cấp <noscript> fallback cho trường hợp JS bị tắt.
 *
 * Critical CSS được đọc từ assets/css/critical.css và cache trong
 * transient để tránh đọc file mỗi request.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/* ───────────────────────────────────────────────
 * 1. INLINE CRITICAL CSS vào <head>
 *    Priority 2 — sau preload fonts (priority 1), trước wp_enqueue_styles.
 * ─────────────────────────────────────────────── */
add_action( 'wp_head', 'pi_inline_critical_css', 2 );

/**
 * Đọc critical.css và inline trực tiếp vào <head>.
 *
 * Dùng transient cache (24h) để tránh file_get_contents mỗi request.
 * Cache tự xoá khi PIDENTIST_VERSION thay đổi (deploy mới).
 */
function pi_inline_critical_css() {
	// Không inline critical CSS trong admin.
	if ( is_admin() ) {
		return;
	}

	$cache_key = 'pi_critical_css_' . PIDENTIST_VERSION;
	$css       = get_transient( $cache_key );

	if ( false === $css ) {
		$file = PIDENTIST_DIR . '/assets/css/critical.css';

		if ( ! file_exists( $file ) ) {
			return;
		}

		$css = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents — local file.

		if ( empty( $css ) ) {
			return;
		}

		// Minify nhẹ: loại bỏ comments và whitespace thừa.
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css ); // Block comments.
		$css = preg_replace( '/\s+/', ' ', $css );                         // Collapse whitespace.
		$css = str_replace( array( ' {', '{ ', ' }', '} ', ': ', ' :', '; ', ' ;', ', ' ),
		                    array( '{',  '{',  '}',  '}',  ':',  ':',  ';',  ';',  ',' ),
		                    $css );
		$css = trim( $css );

		// Cache 24 giờ — tự invalidate khi version thay đổi.
		set_transient( $cache_key, $css, DAY_IN_SECONDS );
	}

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — CSS output, not user data.
	echo '<style id="pi-critical-css">' . $css . '</style>' . "\n";
}

/* ───────────────────────────────────────────────
 * 2. ASYNC LOAD non-critical CSS
 *    Chuyển media="all" → media="print" onload="this.media='all'"
 *    cho các stylesheet handles Pi KHÔNG nằm trong critical path.
 *
 *    Kỹ thuật media="print" là pattern đáng tin cậy nhất,
 *    được Google PageSpeed Insights khuyến nghị.
 * ─────────────────────────────────────────────── */
add_filter( 'style_loader_tag', 'pi_async_non_critical_css', 10, 4 );

/**
 * Chuyển non-critical Pi stylesheets sang async load.
 *
 * @param string $html   The link tag HTML.
 * @param string $handle Style handle name.
 * @param string $href   Stylesheet URL.
 * @param string $media  Media attribute.
 * @return string Modified link tag.
 */
function pi_async_non_critical_css( $html, $handle, $href, $media ) {
	// Chỉ xử lý ở frontend.
	if ( is_admin() ) {
		return $html;
	}

	// Danh sách handles ĐÃ được inline trong critical.css → async load hoàn toàn.
	// Các file này vẫn load đầy đủ (chứa hover/transition/responsive bổ sung)
	// nhưng không block render nữa.
	$async_handles = array(
		'pi-tokens',
		'pi-base',
		'pi-buttons',
		'pi-header',
		'pi-footer',
		'pi-sections',
		'pi-cards',
		'pi-animations',
		'pi-floating',
		'pi-fonts',
		// Pattern CSS.
		'pi-pattern-front-page-bundle',
		'pi-pattern-services-grid',
		'pi-pattern-single-service',
		'pi-pattern-doctors-grid',
		'pi-pattern-cases-grid',
		'pi-pattern-blog',
		'pi-pattern-contact-page',
		'pi-pattern-pricing-page',
		'pi-pattern-about-page',
		'pi-pattern-booking-form',
	);

	if ( ! in_array( $handle, $async_handles, true ) ) {
		return $html;
	}

	// Đã async rồi → bỏ qua.
	if ( strpos( $html, 'onload=' ) !== false ) {
		return $html;
	}

	// Chuyển sang media="print" + onload swap → non-blocking.
	// Noscript fallback đảm bảo CSS vẫn load khi JS bị tắt.
	$noscript = '<noscript><link rel="stylesheet" href="' . esc_url( $href ) . '" media="' . esc_attr( $media ) . '"></noscript>' . "\n";

	// Thay thế media attribute.
	$html = str_replace(
		"media='" . $media . "'",
		"media='print' onload=\"this.media='" . esc_attr( $media ) . "'\"",
		$html
	);

	// Fallback: nếu dùng dấu ngoặc kép thay vì ngoặc đơn.
	$html = str_replace(
		'media="' . $media . '"',
		'media="print" onload="this.media=\'' . esc_attr( $media ) . '\'"',
		$html
	);

	return $html . $noscript;
}

/* ───────────────────────────────────────────────
 * 3. CLEAR TRANSIENT khi theme update/save
 *    Đảm bảo critical CSS luôn fresh sau deploy.
 * ─────────────────────────────────────────────── */
add_action( 'after_switch_theme', 'pi_clear_critical_css_cache' );
add_action( 'customize_save_after', 'pi_clear_critical_css_cache' );

/**
 * Xoá transient cache critical CSS.
 */
function pi_clear_critical_css_cache() {
	global $wpdb;

	// Xoá tất cả transient có prefix pi_critical_css_.
	$wpdb->query(
		$wpdb->prepare(
			"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
			'%_transient_pi_critical_css_%',
			'%_transient_timeout_pi_critical_css_%'
		)
	);
}
