<?php
/**
 * Pi Dentist — Section Header
 *
 * Reusable section header component: label + h2 heading + gold line + subtitle.
 * Dùng trong mọi section cần header chuẩn Pi (section 2, 3, 4, 6, 8, 9, 10...).
 *
 * @param array $args {
 *     @type string $label   Uppercase label (vd: 'CAM KẾT PI').
 *     @type string $heading Section heading (h2).
 *     @type string $sub     Subtitle (optional).
 * }
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$label   = ! empty( $args['label'] )   ? $args['label']   : '';
$heading = ! empty( $args['heading'] ) ? $args['heading'] : '';
$sub     = ! empty( $args['sub'] )     ? $args['sub']     : '';
?>
<div class="section-header">
	<?php if ( $label ) : ?>
		<p class="section-label"><?php echo esc_html( $label ); ?></p>
	<?php endif; ?>

	<?php if ( $heading ) : ?>
		<h2 class="section-heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<div class="gold-line"></div>

	<?php if ( $sub ) : ?>
		<p class="section-sub"><?php echo esc_html( $sub ); ?></p>
	<?php endif; ?>
</div>
