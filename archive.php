<?php
/**
 * Pi Dentist — Archive Template
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="primary" class="site-main" role="main">
    <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
        </header>
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/card/post-card' );
        endwhile;
        the_posts_pagination();
    else :
        echo '<p>Không tìm thấy bài viết nào.</p>';
    endif;
    ?>
</main>

<?php
get_footer();
