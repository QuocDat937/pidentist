<?php
/**
 * template-parts/footer/footer-brand.php
 * Footer column 1: Logo + tagline + description + social icons.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

// Social links from Customizer
$social_links = array(
	'facebook'  => array(
		'url'   => get_theme_mod( 'pi_facebook_url', '#' ),
		'label' => 'Facebook',
		'icon'  => 'f',
	),
	'instagram' => array(
		'url'   => get_theme_mod( 'pi_instagram_url', '#' ),
		'label' => 'Instagram',
		'icon'  => 'ig',
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
<div class="footer-brand">
	<!-- Logo -->
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> trang chủ">
		<span class="logo-symbol">π</span>
		<span class="logo-text">Pi Dentist</span>
	</a>

	<!-- Tagline + Description -->
	<p class="footer-tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?> — Chính xác như hằng số Pi, mỗi ca chỉnh nha được tính toán tỉ mỉ đến từng milimet.</p>

	<!-- Social Icons -->
	<div class="social-links">
		<?php foreach ( $social_links as $key => $social ) :
			if ( ! empty( $social['url'] ) && '#' !== $social['url'] ) : ?>
				<a href="<?php echo esc_url( $social['url'] ); ?>"
				   class="social-link"
				   aria-label="<?php echo esc_attr( $social['label'] ); ?>"
				   target="_blank"
				   rel="noopener noreferrer">
					<?php echo esc_html( $social['icon'] ); ?>
				</a>
			<?php endif;
		endforeach; ?>
	</div>
</div>
