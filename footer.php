<?php
/**
 * footer.php — Pi Dentist
 * Override GeneratePress footer with 4-column layout.
 * Ref: PROJECT_SPEC_WP.md section 7.8
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;
?>

<footer class="site-footer" id="siteFooter" role="contentinfo">
	<div class="container">
		<div class="footer-grid">
			<?php
			get_template_part( 'template-parts/footer/footer-brand' );
			get_template_part( 'template-parts/footer/footer-links' );
			?>
		</div>
		<?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
	</div>
</footer>

<?php
// Floating elements are hooked into wp_footer via inc/floating-elements.php
wp_footer();
?>
</body>
</html>
