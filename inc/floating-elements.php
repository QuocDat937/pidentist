<?php
/**
 * Pi Dentist — Floating Elements
 *
 * Hook vào wp_footer → render 3 floating elements:
 * 1. Floating CTA bar (bottom center)
 * 2. Contact Widgets — Zalo + Phone (bottom right)
 * 3. Back to Top button (bottom right)
 *
 * Show/hide được xử lý bởi assets/js/floating.js
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', 'pi_render_floating_elements', 30 );

/**
 * Render floating elements vào trước </body>.
 *
 * - Skip admin pages và 404.
 * - Lấy phone + zalo_url từ Customizer (get_theme_mod).
 */
function pi_render_floating_elements() {
	// Không hiện trên admin hoặc trang 404.
	if ( is_admin() || is_404() ) {
		return;
	}

	$phone       = get_theme_mod( 'pi_phone', '0909000000' );
	$zalo        = get_theme_mod( 'pi_zalo_url', 'https://zalo.me/' );
	$contact_url = home_url( '/lien-he/' );

	// Xoá khoảng trắng trong số điện thoại cho href tel:
	$phone_clean = str_replace( array( ' ', '.', '-' ), '', $phone );
	?>

	<!-- Floating CTA -->
	<div class="floating-cta" id="floatingCta">
		<a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-gold"><?php esc_html_e( 'Đặt lịch ngay', 'pidentist' ); ?></a>
	</div>

	<!-- Contact Widgets -->
	<div class="contact-widgets" id="contactWidgets">
		<a href="<?php echo esc_url( $zalo ); ?>"
		   class="widget-btn widget-zalo"
		   aria-label="<?php esc_attr_e( 'Chat Zalo', 'pidentist' ); ?>"
		   target="_blank"
		   rel="noopener noreferrer">Z</a>
		<a href="tel:<?php echo esc_attr( $phone_clean ); ?>"
		   class="widget-btn widget-phone"
		   aria-label="<?php esc_attr_e( 'Gọi điện', 'pidentist' ); ?>">📞</a>
	</div>

	<!-- Back to Top -->
	<button class="back-to-top"
	        id="backToTop"
	        aria-label="<?php esc_attr_e( 'Lên đầu trang', 'pidentist' ); ?>"
	        type="button">↑</button>

	<?php
}
