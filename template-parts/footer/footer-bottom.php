<?php
/**
 * template-parts/footer/footer-bottom.php
 * Copyright line + legal links (Privacy Policy, Terms of Service).
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="footer-bottom">
	<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Pi Dentist. <?php esc_html_e( 'All rights reserved.', 'pidentist' ); ?></span>
	<div class="footer-legal">
		<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'pidentist' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'pidentist' ); ?></a>
	</div>
</div>
