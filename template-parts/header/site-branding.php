<?php
/**
 * template-parts/header/site-branding.php
 * Logo + site name — reusable branding fragment.
 * Note: In header.php the logo is rendered inline (per spec section 7.7).
 *       This file is available for other contexts (e.g., admin header, emails).
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> trang chủ">
	<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/logo-white.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo-symbol" width="40" height="40">
	<span class="logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
</a>
