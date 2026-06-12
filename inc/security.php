<?php
/**
 * Pi Dentist — Security Hardening
 *
 * Tất cả security hardening ở theme level.
 * Ref: PROJECT_SPEC_WP.md section 15.4
 *
 * Gồm:
 *  15.4.1  Disable XML-RPC
 *  15.4.2  Remove WP version
 *  15.4.3  DISALLOW_FILE_EDIT fallback
 *  15.4.4  Block author enumeration
 *  15.4.5  Hide login errors
 *  15.4.6  Disable REST API /wp/v2/users
 *  15.4.7  REST API restrict cho logged-out
 *  15.4.8  Security headers (CSP, X-Frame-Options, etc.)
 *  15.4.9  Disable Application Passwords
 *  15.4.10 (Optional) Limit login IP — commented out
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/* ───────────────────────────────────────────────
 * 15.4.1 Disable XML-RPC entirely
 * XML-RPC bị lạm dụng cho brute force amplification
 * Block xmlrpc.php tại Nginx tốt hơn (xem section Deploy)
 * ─────────────────────────────────────────────── */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

/* ───────────────────────────────────────────────
 * 15.4.2 Remove WordPress version từ header và scripts
 * Giúp kẻ tấn công khó xác định WP version → khó exploit
 * ─────────────────────────────────────────────── */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/*
 * NOTE (2026-06): Đã GỠ filter xóa ?ver= khỏi CSS/JS.
 * Lý do: xóa ?ver= làm mất cache busting — deploy CSS/JS mới nhưng
 * browser/LiteSpeed vẫn serve file cũ → vỡ layout cho khách cũ.
 * Lợi ích bảo mật của việc ẩn ?ver= gần như bằng 0 (version giờ là
 * filemtime, không lộ WP version). Xem pi_asset_ver() trong enqueue.php.
 */

/* ───────────────────────────────────────────────
 * 15.4.3 Disable file editing trong Admin (Plugins/Themes editor)
 * Đặt trong wp-config.php sẽ chắc hơn:
 *   define( 'DISALLOW_FILE_EDIT', true );
 *   define( 'DISALLOW_FILE_MODS', true );
 * ─────────────────────────────────────────────── */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/* ───────────────────────────────────────────────
 * 15.4.4 Disable user enumeration via /?author=N
 * Ngăn kẻ tấn công dò username qua author scan
 * ─────────────────────────────────────────────── */
add_action( 'init', 'pi_block_author_enumeration' );

/**
 * Block /?author=N requests cho non-admin users.
 */
function pi_block_author_enumeration() {
	if ( ! is_admin() && isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_die(
			esc_html__( 'Forbidden', 'pidentist' ),
			esc_html__( 'Forbidden', 'pidentist' ),
			array( 'response' => 403 )
		);
	}
}

/* ───────────────────────────────────────────────
 * 15.4.5 Hide login errors
 * Trả generic message — không tiết lộ username/email nào tồn tại
 * ─────────────────────────────────────────────── */
add_filter( 'login_errors', 'pi_hide_login_errors' );

/**
 * Thay login error bằng thông báo chung.
 *
 * @return string Generic error message.
 */
function pi_hide_login_errors() {
	return 'Thông tin đăng nhập không hợp lệ.';
}

/* ───────────────────────────────────────────────
 * 15.4.6 Remove REST API user enumeration endpoint
 * /wp/v2/users tiết lộ danh sách tất cả users → phải khoá
 * ─────────────────────────────────────────────── */
add_filter( 'rest_endpoints', 'pi_disable_rest_users' );

/**
 * Xoá /wp/v2/users và /wp/v2/users/{id} khỏi REST API.
 *
 * @param array $endpoints REST endpoints.
 * @return array Filtered endpoints.
 */
function pi_disable_rest_users( $endpoints ) {
	if ( isset( $endpoints['/wp/v2/users'] ) ) {
		unset( $endpoints['/wp/v2/users'] );
	}
	if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
		unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
}

/* ───────────────────────────────────────────────
 * 15.4.7 Restrict REST API cho user chưa login
 * Cho phép public routes cần thiết:
 *   - posts, pi_service, pi_doctor, pi_case (cho JS fetch/block editor)
 *   - rank-math (SEO sitemap ping)
 * ─────────────────────────────────────────────── */
add_filter( 'rest_authentication_errors', 'pi_restrict_rest_api' );

/**
 * Block REST API cho user chưa login, trừ whitelist routes.
 *
 * @param WP_Error|null|true $result Auth result.
 * @return WP_Error|null|true
 */
function pi_restrict_rest_api( $result ) {
	// Nếu đã có lỗi hoặc user đã login → pass through.
	if ( ! empty( $result ) || is_user_logged_in() ) {
		return $result;
	}

	// Whitelist public routes cần thiết.
	$public_routes = array(
		'/wp/v2/posts',        // Blog feed.
		'/wp/v2/pages',        // Page content.
		'/wp/v2/services',     // Service feed (rest_base).
		'/wp/v2/doctors',      // Doctor feed (rest_base).
		'/wp/v2/cases',        // Case feed (rest_base).
		'/wp/v2/categories',   // Category taxonomy.

		'/rankmath/',          // Rank Math SEO.

		'/litespeed/',         // LiteSpeed Cache — QUIC.cloud callbacks (Image Optimization, etc.).
	);

	$current_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

	foreach ( $public_routes as $route ) {
		if ( false !== strpos( $current_uri, $route ) ) {
			return $result;
		}
	}

	return new WP_Error(
		'rest_not_logged_in',
		esc_html__( 'You are not currently logged in.', 'pidentist' ),
		array( 'status' => 401 )
	);
}

/* ───────────────────────────────────────────────
 * 15.4.8 Add security headers (bổ sung cho Cloudflare/Nginx)
 * Chỉ áp dụng cho frontend, KHÔNG cho admin
 * ─────────────────────────────────────────────── */
add_action( 'send_headers', 'pi_security_headers' );

/**
 * Gửi security headers cho mọi frontend request.
 */
function pi_security_headers() {
	// Không áp dụng cho admin pages — có thể break editor/plugins.
	if ( is_admin() ) {
		return;
	}

	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(self)' );

	// HSTS — bắt buộc browser dùng HTTPS trong 1 năm (chỉ gửi khi đang HTTPS).
	// KHÔNG thêm 'preload' vội — chỉ thêm khi chắc chắn 100% mọi subdomain đều HTTPS vĩnh viễn.
	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains' );
	}

	// Content Security Policy — adjust theo embed thực tế.
	// Fonts self-hosted → không cần fonts.googleapis.com/fonts.gstatic.com.
	$csp  = "default-src 'self'; ";
	$csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com https://connect.facebook.net https://www.google.com https://www.gstatic.com; ";
	$csp .= "style-src 'self' 'unsafe-inline'; ";
	$csp .= "font-src 'self' data:; ";
	$csp .= "img-src 'self' data: https: blob:; ";
	$csp .= "frame-src 'self' https://www.google.com https://www.youtube.com https://www.facebook.com; ";
	$csp .= "connect-src 'self' https://www.google-analytics.com;";

	header( 'Content-Security-Policy: ' . $csp );
}

/* ───────────────────────────────────────────────
 * 15.4.9 Disable "Application Passwords" (WP 5.6+)
 * Nếu không dùng external app auth → tắt để giảm attack surface
 * ─────────────────────────────────────────────── */
add_filter( 'wp_is_application_passwords_available', '__return_false' );

/* ───────────────────────────────────────────────
 * 15.4.10 (Optional) Limit login form to specific IPs
 * Uncomment và thêm IP văn phòng để restrict admin login
 * ─────────────────────────────────────────────── */
// add_action( 'login_init', function() {
//     $allowed_ips = array( '203.0.113.42' ); // IP văn phòng Pi Dentist.
//     $remote_ip   = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
//     if ( ! in_array( $remote_ip, $allowed_ips, true ) ) {
//         wp_die(
//             esc_html__( 'Access denied', 'pidentist' ),
//             esc_html__( 'Access denied', 'pidentist' ),
//             array( 'response' => 403 )
//         );
//     }
// } );

/* ───────────────────────────────────────────────
 * BONUS: Remove unnecessary WP head clutter
 * Giảm attack surface + clean HTML output
 * ─────────────────────────────────────────────── */
remove_action( 'wp_head', 'rsd_link' );                    // Really Simple Discovery.
remove_action( 'wp_head', 'wlwmanifest_link' );            // Windows Live Writer.
remove_action( 'wp_head', 'wp_shortlink_wp_head' );        // Shortlink.
remove_action( 'wp_head', 'rest_output_link_wp_head' );    // REST API discovery link.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' ); // oEmbed discovery.
remove_action( 'wp_head', 'wp_resource_hints', 2 );        // DNS prefetch to s.w.org.
