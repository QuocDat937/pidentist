<?php
/**
 * Pi Dentist — Generic Page Template
 *
 * Template mặc định cho WP Pages.
 * Layout đơn giản: header → main → footer.
 * Nội dung build từ Block Editor (Gutenberg).
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="pi-page" id="main-content">
	<?php
	while ( have_posts() ) :
		the_post();
	?>
		<div class="container">
			<div class="pi-page__content prose">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; ?>
</main>

<?php get_footer();
