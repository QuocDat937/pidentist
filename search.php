<?php
/**
 * Pi Dentist — Search Results
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="primary" class="site-main" role="main">
    <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <h1 class="page-title">
                <?php printf( 'Kết quả tìm kiếm: "%s"', esc_html( get_search_query() ) ); ?>
            </h1>
        </header>
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/card/post-card' );
        endwhile;
        the_posts_pagination();
    else :
        echo '<p>Không tìm thấy kết quả nào.</p>';
    endif;
    ?>
</main>

<?php
get_footer();
