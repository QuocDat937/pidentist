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
