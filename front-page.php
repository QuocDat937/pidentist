<?php
/**
 * Pi Dentist — Front Page Template
 *
 * Trang chủ: render nội dung từ Block Editor (11 sections compose bằng Block Patterns).
 * KHÔNG hardcode layout — admin tự compose từ Block Editor.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="pi-front-page" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>

<?php
get_footer();

