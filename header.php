<?php
/**
 * Pi Dentist — Header Template Override
 * Phase 1 sẽ triển khai sticky header, logo π, navigation.
 */
defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#primary" class="skip-link screen-reader-text"><?php esc_html_e( 'Chuyển đến nội dung', 'pidentist' ); ?></a>

<header id="siteHeader" class="site-header" role="banner">
    <div class="container">
        <?php get_template_part( 'template-parts/header/site-branding' ); ?>
    </div>
</header>
