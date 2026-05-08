<?php
/**
 * Pi Dentist — Front Page Template
 * Renders the_content() — admin compose homepage từ Block Editor với patterns.
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="primary" class="site-main" role="main">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
