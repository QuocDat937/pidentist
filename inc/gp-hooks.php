<?php
/**
 * Pi Dentist — GeneratePress Hook Injections
 *
 * Inject custom HTML vào các vị trí GP hooks KHÔNG cần override template.
 * Ref: PROJECT_SPEC_WP.md section 10.3
 *
 * Hooks sử dụng:
 * 1. generate_before_header  → Promo banner
 * 2. generate_after_header   → Page Hero cho trang con
 * 3. generate_before_footer  → CTA Booking synced pattern
 * 4. generate_logo_output    → Override logo HTML (filter)
 * 5. generate_credits        → Custom footer bottom (fallback khi dùng GP footer)
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/* ═══════════════════════════════════════════════
 * 1. PROMO BANNER — phía trên header
 *    Hiển thị khi Customizer bật pi_promo_active
 * ═══════════════════════════════════════════════ */
add_action( 'generate_before_header', 'pi_hook_promo_banner', 10 );

/**
 * Render promo banner nếu được bật trong Customizer.
 */
function pi_hook_promo_banner() {
	if ( ! get_theme_mod( 'pi_promo_active', false ) ) {
		return;
	}

	$text = get_theme_mod( 'pi_promo_text', '' );
	if ( ! $text ) {
		return;
	}
	?>
	<div class="pi-promo-banner" id="promoBanner">
		<div class="container">
			<span class="promo-emoji" aria-hidden="true">🎉</span>
			<span class="promo-text"><?php echo wp_kses_post( $text ); ?></span>
		</div>
	</div>
	<?php
}

/* ═══════════════════════════════════════════════
 * 2. PAGE HERO — cho mọi trang con (KHÔNG front page)
 *    Gắn ngay sau header, hiển thị label + heading + breadcrumb
 * ═══════════════════════════════════════════════ */
add_action( 'generate_after_header', 'pi_hook_page_hero', 10 );

/**
 * Render page hero cho trang con.
 * Skip: front page, 404, search, standalone pages (pages tự quyết content).
 */
function pi_hook_page_hero() {
	// Skip trang chủ — hero nằm trong Block Pattern
	if ( is_front_page() ) {
		return;
	}

	// Skip 404 và search — có template riêng render page hero
	if ( is_404() || is_search() ) {
		return;
	}

	// Skip các CPT singles — template riêng đã render page hero với params cụ thể
	if ( is_singular( 'pi_service' ) || is_singular( 'pi_doctor' ) || is_singular( 'pi_case' ) ) {
		return;
	}

	// Skip blog single — single.php đã render page hero
	if ( is_singular( 'post' ) ) {
		return;
	}

	// Skip CPT archives — archive-pi_*.php đã render page hero
	if ( is_post_type_archive( 'pi_service' ) || is_post_type_archive( 'pi_doctor' ) || is_post_type_archive( 'pi_case' ) ) {
		return;
	}

	// Skip blog archive — archive.php đã render page hero
	if ( is_home() ) {
		return;
	}

	// Skip taxonomy archives — dùng archive template của CPT tương ứng
	if ( is_tax( 'pi_service_category' ) || is_tax( 'pi_case_tag' ) ) {
		return;
	}

	// Xác định label theo loại nội dung còn lại (category, tag)
	$label   = '';
	$heading = '';

	if ( is_category() || is_tag() ) {
		$label   = 'KIẾN THỨC';
		$heading = single_term_title( '', false );
	} elseif ( is_page() ) {
		// Pages tự define content qua Block Editor — không auto inject hero
		return;
	} else {
		return;
	}

	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => $label,
		'heading'    => $heading,
		'breadcrumb' => true,
	) );
}

/* ═══════════════════════════════════════════════
 * 3. CTA BOOKING — cuối mọi trang (TRỪ front page, /lien-he/, 404)
 *    Render synced pattern 'pi-cta-booking'
 * ═══════════════════════════════════════════════ */
add_action( 'generate_before_footer', 'pi_hook_cta_booking', 10 );

/**
 * Render CTA Booking synced pattern trước footer.
 */
function pi_hook_cta_booking() {
	// Trang chủ đã có CTA trong Block Pattern
	if ( is_front_page() ) {
		return;
	}

	// Trang liên hệ là form chính — không cần CTA thêm
	if ( is_page( 'lien-he' ) ) {
		return;
	}

	// Trang bảng giá có CTA riêng trong template
	if ( is_page( 'bang-gia' ) ) {
		return;
	}

	// 404 không cần CTA
	if ( is_404() ) {
		return;
	}

	// Render synced pattern từ DB (post_type = wp_block)
	$pattern = get_page_by_path( 'pi-cta-booking', OBJECT, 'wp_block' );
	if ( $pattern ) {
		// do_blocks() xử lý block markup, do_shortcode() xử lý [pi_booking_form] + [pi_contact_block]
		// bên trong <!-- wp:html --> blocks.
		$content = do_blocks( $pattern->post_content );
		$content = do_shortcode( $content );
		echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Block content is already sanitized by WP
	}
}

/* ═══════════════════════════════════════════════
 * 4. LOGO OUTPUT — Override GP logo HTML
 *    Dùng π symbol custom thay vì ảnh logo
 * ═══════════════════════════════════════════════ */
add_filter( 'generate_logo_output', 'pi_hook_logo_output' );

/**
 * Override GeneratePress logo output.
 * Trả về HTML custom: π symbol + tên site.
 *
 * @param string $logo_output Default logo HTML từ GP.
 * @return string Custom logo HTML.
 */
function pi_hook_logo_output( $logo_output ) {
	return sprintf(
		'<a href="%1$s" class="logo" rel="home" aria-label="%2$s trang chủ">
			<img src="%3$s" alt="%2$s" class="logo-symbol" width="40" height="40">
			<span class="logo-text">%2$s</span>
		</a>',
		esc_url( home_url( '/' ) ),
		esc_attr( get_bloginfo( 'name' ) ),
		esc_url( get_stylesheet_directory_uri() . '/logo-white.svg' )
	);
}

/* ═══════════════════════════════════════════════
 * 5. CREDITS — Custom footer bottom
 *    Fallback khi dùng GP footer (không override footer.php)
 *    Nếu dùng custom footer.php thì template-parts/footer/footer-bottom.php
 *    đã xử lý phần này.
 * ═══════════════════════════════════════════════ */
add_filter( 'generate_copyright', 'pi_hook_credits' );

/**
 * Override GeneratePress copyright text.
 *
 * @param string $credits Default credits HTML từ GP.
 * @return string Custom credits HTML.
 */
function pi_hook_credits( $credits ) {
	$year = date( 'Y' ); // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date -- Simple year display

	return sprintf(
		'<div class="footer-bottom">
			<span>© %1$s Pi Dentist. All rights reserved.</span>
			<div class="footer-legal">
				<a href="%2$s">Privacy Policy</a>
				<a href="%3$s">Terms of Service</a>
			</div>
		</div>',
		esc_html( $year ),
		esc_url( home_url( '/privacy-policy/' ) ),
		esc_url( home_url( '/terms/' ) )
	);
}
