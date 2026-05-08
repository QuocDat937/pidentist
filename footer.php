<?php
/**
 * Pi Dentist — Footer Template Override
 * Phase 1 sẽ triển khai footer 4 columns + legal links.
 */
defined( 'ABSPATH' ) || exit;
?>

<footer id="siteFooter" class="site-footer" role="contentinfo">
    <div class="container">
        <?php get_template_part( 'template-parts/footer/footer-brand' ); ?>
        <?php get_template_part( 'template-parts/footer/footer-links' ); ?>
        <?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
