<?php
/**
 * Pi Dentist — Page Hero
 *
 * Reusable hero section cho tất cả trang con (không phải front page).
 * Render: label, heading (h1), subtitle, breadcrumb.
 *
 * @param array $args {
 *     @type string $label      Uppercase label (vd: 'DỊCH VỤ').
 *     @type string $heading    Heading text (h1).
 *     @type string $sub        Subtitle (optional).
 *     @type bool   $breadcrumb Hiển thị Rank Math breadcrumbs (optional, default false).
 * }
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$label      = ! empty( $args['label'] )      ? $args['label']      : '';
$heading    = ! empty( $args['heading'] )     ? $args['heading']    : '';
$sub        = ! empty( $args['sub'] )         ? $args['sub']        : '';
$breadcrumb = ! empty( $args['breadcrumb'] )  ? $args['breadcrumb'] : false;
?>
<section class="page-hero">
	<div class="container">
		<div class="page-hero-content">
			<?php if ( $label ) : ?>
				<p class="section-label"><?php echo esc_html( $label ); ?></p>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h1><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>

			<?php if ( $sub ) : ?>
				<p class="page-hero-sub"><?php echo esc_html( $sub ); ?></p>
			<?php endif; ?>

			<?php if ( $breadcrumb && function_exists( 'rank_math_the_breadcrumbs' ) ) : ?>
				<div class="page-hero-breadcrumb">
					<?php rank_math_the_breadcrumbs(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
