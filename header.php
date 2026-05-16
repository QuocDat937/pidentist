<?php
/**
 * header.php — Pi Dentist
 * Override GeneratePress header to match index.html structure exactly.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Chuyển đến nội dung', 'pidentist' ); ?></a>

<?php
// Promo banner — renders if enabled in Customizer (Pi - Ưu đãi).
if ( function_exists( 'pi_hook_promo_banner' ) ) {
	pi_hook_promo_banner();
}
?>

<header class="site-header" id="siteHeader" role="banner">
	<div class="container">
		<div class="header-inner">

			<!-- Logo -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> trang chủ">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/logo-white.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo-symbol" width="40" height="40">
				<span class="logo-text">Pi Dentist</span>
			</a>

			<!-- Main Nav -->
			<nav class="main-nav" aria-label="<?php esc_attr_e( 'Menu chính', 'pidentist' ); ?>">
				<?php
				if ( class_exists( 'Pi_Nav_Walker' ) ) {
					wp_nav_menu( array(
						'theme_location'  => 'primary',
						'container'       => false,
						'items_wrap'      => '%3$s',
						'walker'          => new Pi_Nav_Walker(),
						'depth'           => 2,
						'fallback_cb'     => false,
					) );
				} else {
					wp_nav_menu( array(
						'theme_location'  => 'primary',
						'container'       => false,
						'depth'           => 2,
						'fallback_cb'     => false,
					) );
				}
				?>
			</nav>

			<!-- Header CTA -->
			<div class="header-cta">
				<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold"><?php esc_html_e( 'Đặt lịch tư vấn', 'pidentist' ); ?></a>
			</div>

			<!-- Hamburger (mobile only) -->
			<button class="hamburger" id="hamburger" aria-label="<?php esc_attr_e( 'Mở menu', 'pidentist' ); ?>" aria-expanded="false" aria-controls="mobileNav">
				<span></span><span></span><span></span>
			</button>

		</div>
	</div>
</header>

<!-- Mobile Nav Overlay -->
<?php get_template_part( 'template-parts/header/nav-mobile' ); ?>

<?php
// Page Hero — renders on inner pages (not front page).
if ( function_exists( 'pi_hook_page_hero' ) ) {
	pi_hook_page_hero();
}
?>
