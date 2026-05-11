<?php
/**
 * template-parts/header/nav-mobile.php
 * Mobile navigation overlay — full-screen menu for small screens.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="mobile-nav-overlay" id="mobileNav" aria-hidden="true">
	<div class="mobile-nav-inner">

		<!-- Mobile Header: Close button only (logo already in site header) -->
		<div class="mobile-nav-header">
			<button class="mobile-nav-close" id="mobileNavClose" aria-label="<?php esc_attr_e( 'Đóng menu', 'pidentist' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		</div>

		<?php
		// Mobile menu — fallback to primary if 'mobile' location not assigned
		wp_nav_menu( array(
			'theme_location'  => 'mobile',
			'container'       => false,
			'menu_class'      => 'mobile-nav-menu',
			'depth'           => 2,
			'fallback_cb'     => function() {
				wp_nav_menu( array(
					'theme_location'  => 'primary',
					'container'       => false,
					'menu_class'      => 'mobile-nav-menu',
					'depth'           => 2,
					'fallback_cb'     => false,
				) );
			},
		) );
		?>

		<!-- Mobile CTA -->
		<div class="mobile-nav-cta">
			<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold"><?php esc_html_e( 'Đặt lịch ngay', 'pidentist' ); ?></a>
		</div>

	</div>
</div>
