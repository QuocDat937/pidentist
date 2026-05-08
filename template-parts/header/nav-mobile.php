<?php
/**
 * template-parts/header/nav-mobile.php
 * Mobile navigation overlay — full-screen menu for small screens.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

// Social URLs from Customizer
$social_links = array(
	'facebook'  => array(
		'url'   => get_theme_mod( 'pi_facebook_url', '#' ),
		'label' => 'Facebook',
		'icon'  => 'f',
	),
	'instagram' => array(
		'url'   => get_theme_mod( 'pi_instagram_url', '#' ),
		'label' => 'Instagram',
		'icon'  => '📷',
	),
	'youtube'   => array(
		'url'   => get_theme_mod( 'pi_youtube_url', '#' ),
		'label' => 'YouTube',
		'icon'  => '▶',
	),
	'tiktok'    => array(
		'url'   => get_theme_mod( 'pi_tiktok_url', '#' ),
		'label' => 'TikTok',
		'icon'  => '♪',
	),
	'zalo'      => array(
		'url'   => get_theme_mod( 'pi_zalo_url', '#' ),
		'label' => 'Zalo',
		'icon'  => 'Z',
	),
);
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
			<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold"><?php esc_html_e( 'Đặt lịch tư vấn', 'pidentist' ); ?></a>
		</div>

		<!-- Social Icons -->
		<div class="mobile-nav-social">
			<?php foreach ( $social_links as $key => $social ) :
				if ( ! empty( $social['url'] ) && '#' !== $social['url'] ) : ?>
					<a href="<?php echo esc_url( $social['url'] ); ?>"
					   aria-label="<?php echo esc_attr( $social['label'] ); ?>"
					   target="_blank"
					   rel="noopener noreferrer">
						<span aria-hidden="true"><?php echo esc_html( $social['icon'] ); ?></span>
					</a>
				<?php endif;
			endforeach; ?>
		</div>

	</div>
</div>
